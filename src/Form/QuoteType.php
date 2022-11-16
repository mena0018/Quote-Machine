<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Quote;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['max' => 255])],
                'label' => 'Contenu',
            ])
            ->add('meta', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['max' => 255])],
                'label' => 'Méta',
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (CategoryRepository $q) {
                    return $q->createQueryBuilder('q')
                        ->orderBy('q.name');
                },
            ])
            ->add('Sauvegarder', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
