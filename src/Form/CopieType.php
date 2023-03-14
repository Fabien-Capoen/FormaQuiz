<?php

namespace App\Form;

use App\Entity\Copie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CopieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user')
            ->add('quiz')
            ->add('annotation')
            ->add('note')
            ->add("Envoyer", SubmitType::class, ["attr" => ["class" => "button"]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Copie::class,
        ]);
    }
}
