<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dayOfBirth', IntegerType::class, [
                'label' => 'Jour de naissance',
                'attr' => [
                    'placeholder' => 'Jour de naissance',
                    'min' => 1,
                    'max' => 31,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre jour de naissance']),
                    new Range([
                        'min' => 1,
                        'max' => 31,
                        'notInRangeMessage' => 'Le jour doit être compris entre {{ min }} et {{ max }}.',
                    ]),
                ],
            ])
            ->add('monthOfBirth', ChoiceType::class, [
                'label' => 'Mois de naissance',
                'choices' => [
                    'Janvier'   => 'janvier',
                    'Février'   => 'février',
                    'Mars'      => 'mars',
                    'Avril'     => 'avril',
                    'Mai'       => 'mai',
                    'Juin'      => 'juin',
                    'Juillet'   => 'juillet',
                    'Août'      => 'août',
                    'Septembre' => 'septembre',
                    'Octobre'   => 'octobre',
                    'Novembre'  => 'novembre',
                    'Décembre'  => 'décembre',
                ],
                'placeholder' => 'Sélectionnez un mois',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un mois',
                    ]),
                ],
            ])

            ->add('yearOfBirth', IntegerType::class, [
                'label' => 'Année de naissance',
                'attr' => [
                    'placeholder' => 'AAAA',
                    'min' => 1900,
                    'max' => date('Y'),
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre année de naissance']),
                    new Range([
                        'min' => 1900,
                        'max' => date('Y'),
                        'notInRangeMessage' => 'L’année doit être comprise entre {{ min }} et {{ max }}.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => '••••••••',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 32,
                    ]),
                    new NotCompromisedPassword([
                        'message' => 'Ce mot de passe est compromis, veuillez en choisir un autre.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,32}$/',
                        'message' => 'Le mot de passe doit contenir entre 8 et 32 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])

            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur-rice' => 'ROLE_USER',
                    'Administrateur-rice' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true, // checkbox
            ])

            ->add('userInfo', UserInfoType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
