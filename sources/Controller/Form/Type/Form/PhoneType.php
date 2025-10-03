<?php

namespace Combodo\iTop\Controller\Form\Type\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneType extends AbstractType
{
	public function getParent(): string
	{
		return FormType::class;
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('phone', TelType::class,[
			'required' => false,
			])
			->add('allow_commercial', CheckboxType::class, [
				'required' => false
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefault('attr', [
			'class' => 'bg-light p-3 pb-2 rounded-1',
		]);
	}
}