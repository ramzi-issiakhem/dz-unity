<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextareaType::class)
            ->add('wilaya',ChoiceType::class,[
                "choices" => ["Algérie" => Users::WILAYAS ,"France" => Users::DPT],
            ])
            ->add('type',ChoiceType::class,[
                "choices" => ["Association" => "Association","Point de Collecte" => "Point de Collecte"]
            ])
            ->add('contacts',TextareaType::class)

            ->add('adresse',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
