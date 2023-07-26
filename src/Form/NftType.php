<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\NFT;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('image', FileType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid format (png, jpg)',
                    ])
                ],
            ])
            ->add('valeur', NumberType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('quantity', NumberType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('valider', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NFT::class,
        ]);
    }
}
