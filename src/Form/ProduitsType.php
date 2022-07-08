<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('image', FileType::class, [
                'mapped'=>false,
                'help' => 'PNG, JPG, JPEG, JP2, WEBP ou PDF - 2 Mo maximum',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). 
                        La taille maximum autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            // 'image/*',
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Le format de fichier est invalide ({{ type }}). 
                        Les types autorisés sont : {{ types }}'
                    ])
                ]
            ])


            ->add('description',TextareaType::class)
            ->add('couleur',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('prix',NumberType::class)
            ->add('categories');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
