<?php

namespace Perso\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentAddType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('published')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'perso_blogbundle_comment_add';
    }
	
	public function getParent()
	{
		return new CommentType();
	}
}
