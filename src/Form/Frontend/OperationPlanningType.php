<?php

namespace App\Form\Frontend;

use App\Entity\Operation;
use App\Entity\Remorque;
use App\Repository\RemorqueRepository;
use App\Repository\OperationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OperationPlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('affectation', null, [
                'required' => true,
            ])
            ->add('remorque', EntityType::class, [
                'class' => Remorque::class,
                'choice_label' => 'remorque',
                'query_builder' => function (RemorqueRepository $qr) {
                    return $qr->createQueryBuilder('r')
                    ->andWhere('r.maintenance = false')
                    ->leftJoin('r.operation', 'o')
                    ->addSelect('r', 'o')
                    ->leftJoin('o.traction', 'tr')
                    ->addSelect('o', 'tr')
                    ->leftJoin('o.planning', 'pl')
                    ->addSelect('o', 'pl')
                    ->andWhere('r.maintenance = false')
                    ->andWhere('o.traction is null')
                    ->andWhere('o.planning is null')
                    ->andWhere('o.parking is not null');
                },
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
