<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Messages de contact')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        // Les messages ne sont pas créés depuis l'admin : ils arrivent via le formulaire du site.
        return $actions
            ->disable(Actions::NEW)
            ->disable(Actions::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('nom')->setFormTypeOption('disabled', true);
        yield TextField::new('email')->setFormTypeOption('disabled', true);
        yield TextField::new('sujet')->setFormTypeOption('disabled', true);
        yield TextareaField::new('message')
            ->setFormTypeOption('disabled', true)
            ->hideOnIndex();
        yield DateTimeField::new('createdAt')->setLabel('Reçu le')->setFormTypeOption('disabled', true);
        yield BooleanField::new('traite')->setLabel('Traité');
    }
}