<?php

namespace App\Form;

use App\Entity\Remorque;
use App\Entity\RemorqueType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RemorquesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maintenance')
            ->add('remorque')
            ->add('immatriculation')
            ->add('type', EntityType::class, [
                'class' => RemorqueType::class,
                'choice_label' => 'denomination'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Remorque::class,
        ]);
    }
}
