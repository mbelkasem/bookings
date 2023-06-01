<?php

namespace App\Form;

use App\Entity\Representation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Show;
use App\Entity\Room;



class RepresentationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('schedule', null, [
                'label' => 'Date et Heure',
            ])
            ->add('the_show', EntityType::class,[
                'class' =>  Show::class, 
                'choice_label' => 'description',
                'label' => 'Déscription',
            ] )
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'name',
                'label' => 'Nom Salles',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Representation::class,
        ]);
    }
}
