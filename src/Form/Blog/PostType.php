<?php

namespace App\Form\Blog;

use App\Entity\Blog\Category;
use App\Entity\Blog\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "Titre de l'article",
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            /*->add('cover')*/
            ->add('content', TextareaType::class, [
                'required' => false,
                'label' => "Contenu de l'article",
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '10',
                ],
            ])
            ->add('publishedAt', DateType::class, [
                'required' => false,
                'label' => "Date de publication",
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('categories', EntityType::class, [
                'required' => true,
                'label' => "Catégories de l'article",
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
