<?php

namespace App\Form;

use App\DTO\SeriesCreateFormInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seriesName', options: ['label' => 'Nome:'])
            ->add('seasonsQuantity', options: ['label' => 'Nº de temporadas:'])
            ->add('episodesPerSeason', options: ['label' => 'Ep. por temporada:'])
            ->add('save', SubmitType::class, options: ['label' => $options['label']])
            ->setMethod($options['method'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeriesCreateFormInput::class,
            'label' => 'Salvar',
            'method' => 'POST'
        ]);
    }
}
