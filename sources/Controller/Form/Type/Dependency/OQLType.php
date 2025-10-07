<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OQLType extends FormType
{
	public function getParent(): string
	{
		return TextType::class;
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->addViewTransformer(new OQLDataTransformer());
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => OQLData::class,
		]);
	}

}