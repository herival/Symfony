<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Record;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("artist", EntityType::class, [ "class" => Artist::class, "choice_label" => "name" , 'attr' => ['class'=> "form-control"]]) //la classe ici s'appelle Artist mais pa artist_id
            ->add('title', TextType::class, ["label"=>"Titre",  'attr' => ['class'=> "form-control"]])
            ->add('description', TextareaType::class,  ['attr' => ['class'=> "form-control"]])
            ->add('releasedAt', DateType::class, ["widget" => "single_text",
                                                    "label" => "Sortie le : ",
                                                    'attr' => ['class'=> "form-control"]
                                                    ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Record::class,
        ]);
    }
}
