<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\Quai;
use App\Entity\Remorque;
use App\Repository\QuaiRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OperationQuaiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remorque', EntityType::class, [
                'class' => Remorque::class,
                'choice_label' => 'remorque'
            ])
            ->add('quai', EntityType::class, [
                'label' => 'select some colors',
                'class' => Quai::class,
                'choice_label' => 'numero',
                'query_builder' => function (QuaiRepository $qr) {
                    return $qr->createQueryBuilder('q')
                    ->andWhere('q.maintenance = false');
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
