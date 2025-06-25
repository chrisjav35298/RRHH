<?php
namespace App\Form\Filtro;

use App\Entity\Pais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProvinciaFiltroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pais', EntityType::class, [
                'class' => Pais::class,
                'choice_label' => 'nombre',
                'required' => false,
                'placeholder' => 'Seleccione un país',
            ])
            ->add('minPoblacion', IntegerType::class, [
                'required' => false,
                'label' => 'Población mínima',
            ])
            ->add('maxSuperficie', NumberType::class, [
                'required' => false,
                'label' => 'Superficie máxima (km²)',
            ]);
    }
}
