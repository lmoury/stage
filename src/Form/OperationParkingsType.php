<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\Remorque;
use App\Entity\Parking;
use App\Repository\RemorqueRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OperationParkingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remorque', EntityType::class, [
                'class' => Remorque::class,
                'choice_label' => 'remorque',
                'query_builder' => function (RemorqueRepository $qr) {
                    return $qr->createQueryBuilder('q')
                    ->andWhere('q.maintenance = false');
                }
            ])
            ->add('parking', EntityType::class, [
                'class' => Parking::class,
                'choice_label' => 'denomination',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
