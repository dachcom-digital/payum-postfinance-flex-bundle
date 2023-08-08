<?php

namespace PayumPostFinanceFlexBundle\Form\Payment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PostFinanceFlexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sandbox', CheckboxType::class, [
                'constraints' => [],
            ])
            ->add('spaceId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('postFinanceUserId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('postFinanceSecret', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ]
            ])
            ->add('optionalParameters', CollectionType::class, [
                'allow_add'    => true,
                'allow_delete' => true,
                'required'     => false
            ]);

    }
}
