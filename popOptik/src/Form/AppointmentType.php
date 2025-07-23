<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('appointmentDate')
        //     ->add('appointmentHour')
        //     ->add('userAppointment', EntityType::class, [
        //         'class' => User::class,
        //         'choice_label' => 'id',
        //     ])
        //     ->add('userRDV', EntityType::class, [
        //         'class' => User::class,
        //         'choice_label' => 'id',
        //     ])
        // ;
        $builder
            ->add('appointmentDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date du rendez-vous',
            ])
            ->add('appointmentHour', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure du rendez-vous',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
