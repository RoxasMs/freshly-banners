<?php

namespace App\Form;

use App\Entity\BannerContent;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active_lang')
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'label_attr' => [
                    'class' => 'form-label mb-2',
                ],
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'rows' => 4,
                ],
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BannerContent::class,
        ]);
    }
}
