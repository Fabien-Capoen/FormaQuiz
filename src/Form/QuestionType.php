<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('quiz')
            ->add('questionType')
            ->add('note_max', IntegerType::class)
            ->add('question', TextareaType::class)
            ->add('reponse1', TextareaType::class, ['required'   => false, 'empty_data' => ''])
            ->add('reponse2', TextareaType::class, ['required'   => false, 'empty_data' => ''])
            ->add('reponse3', TextareaType::class, ['required'   => false, 'empty_data' => ''])
            ->add('reponse4', TextareaType::class, ['required'   => false, 'empty_data' => ''])
            ->add("Envoyer", SubmitType::class, ["attr" => ["class" => "button"]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
