<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Record;
use App\Entity\Ranking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RankingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', null)
            ->add('comment', null)
            // ->add('record', EntityType::class, [ "class" => Record::class, "choice_label" => "id" , 'attr' => ['class'=> "form-control"]])
            // ->add('user', TextType::class)
            // ->add('user', EntityType::class, [ "class" => Artist::class, "choice_label" => "id" , 'attr' => ['class'=> "form-control"]])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ranking::class,
        ]);
    }
}
