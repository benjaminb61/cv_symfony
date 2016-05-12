<?php

namespace Perso\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleEditType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('datecreate',	  'text')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'perso_blogbundle_article_edit';
    }
	
	public function getParent()
	{
		return new ArticleType();
	}
}
