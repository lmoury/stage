<?php

namespace App\Form\Frontend\Remorque;

use App\Entity\Operation;
use App\Entity\Quai;
use App\Repository\QuaiRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmplacementQuaiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
