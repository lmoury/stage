<?php

namespace App\Form\Backend;

use App\Entity\Traction;
use App\Entity\Quai;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('affectation')
            ->add('quai', EntityType::class, [
                'class' => Quai::class,
                'choice_label' => 'numero'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Traction::class,
        ]);
    }
}
