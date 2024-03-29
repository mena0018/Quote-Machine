<?php

namespace App\Form;

use App\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être d\'au  moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new RollerworksPassword\PasswordRequirements([
                        'requireLetters' => true,
                        'requireNumbers' => true,
                        'requireCaseDiff' => true,
                    ]),
                ],
            ])
            ->add('Valider', SubmitType::class)
            ->add('captcha', CaptchaType::class, [
                'disabled' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
