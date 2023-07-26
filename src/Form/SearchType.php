<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchBar', TextType::class,[
                "required"=> false,
                "label"=>"Recherche textuelle",
                "attr"=>[
                    "class"=> "form-control"
                ]
            ])
            ->add('category', EntityType::class, [
                "label"=>"Recherche par catégorie",
                "required"=> false,
                "attr"=>[
                    "class" =>"form-select"
                ],
                'class'=> Category::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->where('c.parent IS NULL');
                }
            ])
            ->add('categoryChild', EntityType::class, [
                "label"=>"Recherche par sous-catégorie",
                "required"=> false,
                "attr"=>[
                    "class" =>"form-select"
                ],
                'class'=> Category::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->where('c.parent IS NOT NULL');
                }
            ])
            ->add("userAjout", EntityType::class,[
                'class' => User::class,
                "attr"=>[
                    "class" =>"form-select"
                ],
                "label"=>"Recherche par les NFT ajoutés par",
                "required"=> false,
            ])

            ->add("valueMin", NumberType::class,[

                "label"=>"Prix min ",
                "required"=> false,
                "attr"=>[
                    "class"=> "form-control"
                ]
            ])

            ->add("valueMax", NumberType::class,[

                "label"=>"Prix max ",
                "required"=> false,
                "attr"=>[
                    "class"=> "form-control"
                ]
            ])

            ->add("valider", SubmitType::class, [
                "attr"=> [
                    "class"=> "mt-2 btn btn-success"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
