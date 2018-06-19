<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
                    'attr' => array(
                        'autofocus' => true
                    )
                ))
                ->add('brochure',FileType::class, array(
                    'label' => 'Image',
                    'required' => null,
                    'data_class' => null
                ))
                ->add('text', TextareaType::class,array(
                    'attr' => array(
                        'rows' => 10,
                    ),
                    'required' => false
                ))
                ->add('note', RangeType::class, array(
                    'attr' => array(
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'value' => 0
                    )
                ))
                ->add('dateStart', DateTimeType::class, array(
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'startView' => 'year',
                    'minView' => 'day',
                    'maxView' => 'decade',
                    'todayBtn' => true,
                    'todayHighlight' => true,
                    'keyboardNavigation' => true,
                    'forceParse' => true,
                    'minuteStep' => 5,
                    'pickerReferer ' => 'default', //deprecated
                    'pickerPosition' => 'bottom-right',
                    'viewSelect' => 'hour',
                ),
                'attr' => array(
                    "placeholder" => "Renseignez une date de début",
                    "readonly" => "readonly"
                ),
            ))
                ->add('dateEnd', DateTimeType::class, array(
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'startView' => 'year',
                    'minView' => 'day',
                    'maxView' => 'decade',
                    'todayBtn' => true,
                    'todayHighlight' => true,
                    'keyboardNavigation' => true,
                    'forceParse' => true,
                    'minuteStep' => 5,
                    'pickerReferer ' => 'default', //deprecated
                    'pickerPosition' => 'bottom-right',
                    'viewSelect' => 'hour',
                ),
                'attr' => array(
                    "placeholder" => "Renseignez une date de début",
                    "readonly" => "readonly"
                ),
            ))
                ->add('categorie', null, array(
                    'required' => true
                ));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Content'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_content';
    }


}
