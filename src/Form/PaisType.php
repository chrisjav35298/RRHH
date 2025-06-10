<?php
namespace App\Form;
use App\Entity\Pais;
use App\Form\ProvinciaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'País',
                'attr' => ['style' => 'max-width: 400px;'],
            ]) 
            ->add('provincias', CollectionType::class, [
                'entry_type' => ProvinciaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => ['attr' => ['style' => 'max-width: 400px;']],
            ]);
            
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pais::class,
        ]);
    }
}
