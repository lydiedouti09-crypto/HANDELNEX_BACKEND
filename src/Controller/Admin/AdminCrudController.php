<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use Doctrine\ORM\Event\PostPersistEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Administrateur')
            ->setEntityLabelInPlural('Administrateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('nom');
        yield EmailField::new('email');

        // Champ "mot de passe" affiché uniquement sur le formulaire, jamais dans les listes.
        yield TextField::new('plainPassword', 'Mot de passe')
            ->setFormType(PasswordType::class)
            ->setFormTypeOptions(['required' => 'new' === $pageName])
            ->onlyOnForms()
            ->setHelp('Laisser vide pour ne pas modifier le mot de passe.');

        yield ArrayField::new('roles')
            ->setHelp('Ex: ROLE_ADMIN, ROLE_SUPER_ADMIN')
            ->hideOnIndex();
    }

    public function persistEntity($entityManager, $entityInstance): void
    {
        $this->hashPasswordIfProvided($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity($entityManager, $entityInstance): void
    {
        $this->hashPasswordIfProvided($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function hashPasswordIfProvided(mixed $entityInstance): void
    {
        if (!$entityInstance instanceof Admin) {
            return;
        }

        // plainPassword est un champ "virtuel" rempli par le formulaire (voir getter/setter ci-dessous)
        $plainPassword = $entityInstance->getPlainPassword();
        if (null !== $plainPassword && '' !== $plainPassword) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword($entityInstance, $plainPassword)
            );
        }
    }
}