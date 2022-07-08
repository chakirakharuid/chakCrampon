<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('nom',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('prenom',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('adresse',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]])
            ->add('ville',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
