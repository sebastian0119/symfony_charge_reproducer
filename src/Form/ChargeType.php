<?php

namespace App\Form;

use App\Entity\Charge;
use App\Entity\Company;
use App\Entity\CompanyLegaltype;
use App\Entity\Currency;
use App\Entity\Project;
use App\Entity\Subcontract;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CompanyLegaltype', EntityType::class, [
                'class' => CompanyLegaltype::class,
                'choice_label' => 'full',
                'placeholder' => '-- Please select --',
                // Makes sure that a simple select field is shown
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'disabled' => false,
            ])
            ->add('CompanyIdentification', NumberType::class, [
                'required' => true,
            ])
            ->add('CompanyActivity', NumberType::class, [
                'required' => true,
            ])
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('Reply', ChoiceType::class, [
                'placeholder' => '-- Please select --',
                'choices'  => [
                    'Aceptado' => 1,
                    'Rechazado' => 3,
                ],
                'required' => true,
            ])
            ->add('Number', NumberType::class, [
                'required' => true,
            ])
            ->add('Code', TextType::class, [
                'required' => true,
            ])
            ->add('Description', TextType::class, [
                'required' => true,
            ])
            ->add('Related')
            ->add('TaxAmount', NumberType::class, [
                'required' => true,
                'scale' => 5,
                'input' => 'string',
            ])
            ->add('TaxCondition', ChoiceType::class, [
                'placeholder' => '-- Please select --',
                'choices'  => [
                    'Genera crédito IVA' => 1,
                    'Genera crédito parcial' => 2,
                    'Gasto; no genera crédito' => 4,
                    'Proporcionalidad' => 5,
                ],
                'required' => true,
            ])
            ->add('TaxCredit', NumberType::class, [
                'required' => true,
                'scale' => 5,
                'input' => 'string',
            ])
            ->add('TaxExpense', NumberType::class, [
                'required' => true,
                'scale' => 5,
                'input' => 'string',
            ])
            ->add('Amount', NumberType::class, [
                'required' => true,
                'scale' => 5,
                'input' => 'string',
            ])
            ->add('Comment')
            ->add('Company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'placeholder' => '-- Please select --',
                // Makes sure that a simple select field is shown
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'disabled' => false,
            ])
            ->add('Project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'placeholder' => '-- Select company --',
                // Makes sure that a simple select field is shown
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'disabled' => false,
            ])
            ->add('Subcontract', EntityType::class, [
                'class' => Subcontract::class,
                'choice_label' => 'description',
                'placeholder' => '-- Select project --',
                // Makes sure that a simple select field is shown
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'disabled' => false,
            ])
            ->add('Currency', EntityType::class, [
                'class' => Currency::class,
                'choice_label' => 'short',
                // Makes sure that a simple select field is shown
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'disabled' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charge::class,
        ]);
    }
}
