<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserRegistrationFormType
 * @package App\Form
 */
class UserRegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class,
                [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Choose a password!'
                        ]),
                        new Length([
                            'min' => 5,
                            'minMessage' => 'Come on, you can think of a password longer than that!'
                        ])
                    ]
                ]
            );

//            ->add('register', ButtonType::class,
//                [
//                    'attr' => ['class' => 'save btn btn-default pull-right', 'type' => 'submit'],
//                ]
//            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['class' => 'form-signin', 'novalidate' => 'true']
        ]);
    }
}
