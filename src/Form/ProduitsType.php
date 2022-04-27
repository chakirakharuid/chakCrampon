<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image', FileType::class, [
            'mapped' => false,])
            ->add('description',TextareaType::class)
            ->add('couleur')
            ->add('prix',NumberType::class)
            ->add('taille', ChoiceType::class, [
            'choices' => [
                '0' => 0,
                '39' => 39,
                '40' => 40,
                '41' => 41,
                '42' => 42,
                '43' => 43,
                '44' => 44,
                '45' => 45,
                '46' => 46,
            ] ]) 
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
