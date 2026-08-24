<?php

namespace App\Controller\Admin;

use App\Entity\Solution;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SolutionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Solution::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Solution')
            ->setEntityLabelInPlural('Solutions')
            ->setDefaultSort(['ordreAffichage' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('nom');
        yield SlugField::new('slug')->setTargetFieldName('nom');
        yield TextField::new('icone')->setHelp('Emoji ou nom d\'icône, ex : ✈️');
        yield TextField::new('categorie');
        yield TextField::new('description')->setHelp('Courte description affichée sur la carte');
        yield TextareaField::new('descriptionComplete')
            ->setLabel('Description complète')
            ->hideOnIndex();
        yield ImageField::new('image')
            ->setUploadDir('public/uploads/solutions')
            ->setBasePath('uploads/solutions')
            ->hideOnIndex();
        yield UrlField::new('lienGooglePlay')->setLabel('Lien Google Play');
        yield ChoiceField::new('statut')
            ->setChoices([
                'Brouillon' => 'brouillon',
                'Publié' => 'publie',
                'Archivé' => 'archive',
            ]);
        yield IntegerField::new('ordreAffichage')->setLabel('Ordre d\'affichage');
        yield TextField::new('createdAt')->hideOnForm()->hideOnIndex();
    }
}