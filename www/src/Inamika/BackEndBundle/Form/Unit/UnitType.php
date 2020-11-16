<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackEndBundle\Form\Unit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class,array('label'=>'LOTE_NUMBER','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'')))
        ->add('price',NumberType::class,array('label'=>'PRICE','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'')))
        ->add('areaGround',NumberType::class,array('label'=>'AREA_GROUND','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('areaCovered',NumberType::class,array('label'=>'AREA_COVERED','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('areaSemiCovered',NumberType::class,array('label'=>'AREA_SEMI_GROUND','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('rooms',NumberType::class,array('label'=>'ROOMS','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('orientation',TextType::class,array('label'=>'ORIENTATION','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('catchment',TextType::class,array('label'=>'CATCHMENT','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('floors',NumberType::class,array('label'=>'FLOORS','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('expenses',NumberType::class,array('label'=>'EXPENSES','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'')))
        // ->add('lastContact',DateType::class,array('label'=>'LAST_CONTACT','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        // ->add('comments',TextareaType::class,array('label'=>'COMMENTS','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control')))
        ->add('code',TextType::class,array('label'=>'LOTE_CODE','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'')))
        ->add('description',TextareaType::class,array('label'=>'DESCRIPTION','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control','placeholder'=>'')))
        ->add('project', EntityType::class, array(
            'label'=>'Emprendimiento',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:Project',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control'),
            'placeholder' => '--Seleccione una opción--',
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)
                    ->orderBy('e.name', 'ASC');
                return $choices;
            }
        ))
        ->add('currencyPrice', EntityType::class, array(
            'label'=>'Moneda precio',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:Currency',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control'),
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)->orderBy('e.isDefault', 'DESC');
                return $choices;
            }
        ))
        ->add('currencyExpenses', EntityType::class, array(
            'label'=>'Moneda expensas',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:Currency',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control'),
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)->orderBy('e.isDefault', 'DESC');
                return $choices;
            }
        ))
        ->add('status', EntityType::class, array(
            'label'=>'STATUS',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:UnitStatus',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control'),
            'placeholder' => '--Seleccione una opción--',
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)
                    ->orderBy('e.name', 'ASC');
                return $choices;
            }
        ))
        ->add('type', EntityType::class, array(
            'label'=>'TYPE',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:UnitType',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control'),
            'placeholder' => '--Seleccione una opción--',
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)
                    ->orderBy('e.name', 'ASC');
                return $choices;
            }
        ))
        ->add('customer', EntityType::class, array(
            'label'=>'CUSTOMER',
            'label_attr'=>array('class'=>'control-label'),
            'class' => 'InamikaBackEndBundle:Customer',
            'choice_label' => 'name',
            'attr'=>array('class'=>'form-control combobox'),
            'placeholder' => '--Seleccione una opción--',
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('e');
                $choices=$qb->where("e.isDelete=:isDelete")->setParameter('isDelete',false)
                    ->orderBy('e.name', 'ASC');
                return $choices;
            }
        ))
        ->add('isActive',ChoiceType::class, array('label'=>'ACTIVE','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control'),'choices' => array(
            'YES' => true,
            'NO' => false
        )))
        ->add('isOpportunity',ChoiceType::class, array('label'=>'OPPORTUNITY','label_attr'=>array('class'=>'control-label'),'attr'=>array('class'=>'form-control'),'choices' => array(
            'YES' => true,
            'NO' => false
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'=>false,
            'allow_extra_fields'=>true,
            'data_class' => 'Inamika\BackEndBundle\Entity\Unit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }

}
