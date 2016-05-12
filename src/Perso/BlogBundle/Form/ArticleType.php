<?php

namespace Perso\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',	    'text')
            //->add('slug')
            ->add('content',    'textarea', array('attr' => array('class' => 'ckeditor')))
            ->add('author',     'text')
            ->add('datecreate', 'date')
            //->add('dateupdate')
            ->add('statut',     'checkbox', array('required' => false))
			->add('categories', 'entity', array(
				  'class'    => 'PersoBlogBundle:Category',
				  'property' => 'name',
				  'multiple' => true,
				  'expanded' => true
			))
			->add('Envoyer',      'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Perso\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'perso_blogbundle_article';
    }
}
