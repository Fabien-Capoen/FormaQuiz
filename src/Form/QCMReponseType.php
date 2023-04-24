<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QCMReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $reponse=$builder->getData();
        /**
         * @var Question $question
         */
        $question = $reponse->getQuestion();
        $builder
//            -> add('user', options:['label'=>$currentUser])
//            ->add('question')
            ->add('choixrep1', options:['label'=>$question->getReponse1()])
            ->add('choixrep2', options:['label'=>$question->getReponse2()])
            ->add('choixrep3', options:['label'=>$question->getReponse3()])
            ->add('choixrep4', options:['label'=>$question->getReponse4()])
            ->add("Envoyer", SubmitType::class, ["attr" => ["class" => "button"]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
