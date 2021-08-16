<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventSearch;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Users;
use App\Entity\UsersSearch;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wilaya',ChoiceType::class,[
                'label' => "Wilaya de résidence",
                "choices" => [  "Tous" => "Tous","Algérie" => Users::WILAYAS ,"France" => Users::DPT],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UsersSearch::class,
            'translation_domain' => 'forms',
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }


}
