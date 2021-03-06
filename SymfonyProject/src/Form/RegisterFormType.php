<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Planets;

class RegisterFormType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Email', EmailType::class, array(
                'label' => 'Votre Mail',
                'attr' => array(
                    'class' => 'form-input-item',
                    'placeholder' => 'Mail'
                ),
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Votre Mail ne peut pas être vide.'
                    ))
                )
            ))
            ->add('Password', PasswordType::class, array(
                'label' => 'Votre Mot de Passe',
                'attr' => array(
                    'class' => 'form-input-item',
                    'placeholder' => 'Mot de Passe'

                ),
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Votre Mot de Passe ne peut pas être vide.'
                    ))
                )
            ))
            ->add('Planet', ChoiceType::class, [
              'choices' => array(
                'Mercure' => 1,
                'Venus' => 2,
                'Terre' => 3,
                'Mars' => 4,
                'Jupiter' => 5,
                'Saturne' => 6,
                'Uranus' => 7,
                'Neptune' => 8,
              ),
            ])
            ->add('confirmer', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ))
            ->add('reset', ResetType::class, array(
                'label' => 'Réinitialiser',
                'attr' => array(
                    'class' => 'btn btn-warning'
                )
            ))
        ;
    }
}