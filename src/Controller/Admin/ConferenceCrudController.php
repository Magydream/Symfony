<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('year')->setLabel('Année');
        yield TextField::new('city')->setLabel('Ville');
        yield TextField::new('name')->setLabel('Nom');
        yield BooleanField::new('isInternational')->setLabel('Internationale ?');
        
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Liste d’une conférence')
            ->setEntityLabelInPlural('Listes de plusieurs conférences')
            ->setSearchFields(['city', 'year'])
            ->setDefaultSort(['year' => 'ASC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('city', 'Auteur'))
            ->add(TextFilter::new('year','Année'))
            ;
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
