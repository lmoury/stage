<?php

namespace App\Form\Frontend;

use App\Entity\Operation;
use App\Entity\Remorque;
use App\Entity\Quai;
use App\Repository\RemorqueRepository;
use App\Repository\QuaiRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArrivageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remorque', EntityType::class, [
                'class' => Remorque::class,
                'choice_label' => 'remorque',
                'query_builder' => function (RemorqueRepository $qr) {
                    return $qr->createQueryBuilder('r')
                    ->andWhere('r.maintenance = false')
                    ->leftJoin('r.operation', 'o')
                    ->addSelect('r', 'o')
                    ->leftJoin('o.quai', 'q')
                    ->addSelect('o', 'q')
                    ->leftJoin('o.traction', 'tr')
                    ->addSelect('o', 'tr')
                    ->leftJoin('o.planning', 'pl')
                    ->addSelect('o', 'pl')
                    ->andWhere('r.maintenance = false')
                    ->andWhere('o.quai is null');
                },
            ])
            ->add('quai', EntityType::class, [
                'class' => Quai::class,
                'choice_label' => 'numero',
                'query_builder' => function (QuaiRepository $qr) {
                    return $qr->createQueryBuilder('q')
                    ->andWhere('q.maintenance = false')
                    ->leftJoin('q.operation', 'o')
                    ->addSelect('q', 'o')
                    ->leftJoin('o.quai', 'qu')
                    ->addSelect('o', 'qu')
                    ->andWhere('o.quai is null');
                }
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
