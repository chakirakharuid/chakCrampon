<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'maxLength'=>40
                ]
            ])
            ->add('prenom',TextType::class,[
                'attr'=>[
                    'maxLength'=>50
                ]])
            ->add('email',EmailType::class,[
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
            ->add('RGPD', CheckboxType::class, [
                'mapped' => false,
                'help'=>'En créant un compte, vous acceptez de vous conformer à la Politique de confidentialité et aux Conditions générales de Chak crampon.',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez cocher la case rgpd.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                 'help' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.',
                'attr' => ['autocomplete' => 'nouveau-mot-de-passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer votre mot de passe',
                    ]),
                    
                    new PasswordStrength([
                        'minLength' => 8,
                    'tooShortMessage' => 'Le mot de passe doit contenir au moins {{length}} caractères',
                    'minStrength' => 4,
                    'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
