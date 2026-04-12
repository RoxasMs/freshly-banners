<?php

namespace App\Form;

use App\Entity\Banner;
use App\Entity\Color;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\BannerContentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active')
            ->add('internal_name')
            ->add('start_date')
            ->add('end_date')
            ->add('background_color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un color',
            ])
            ->add('bannerContents', CollectionType::class, [
                'entry_type' => BannerContentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
