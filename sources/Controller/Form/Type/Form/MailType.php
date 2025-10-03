<?php

namespace Combodo\iTop\Controller\Form\Type\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
	public function getParent(): string
	{
		return FormType::class;
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class,[
			'required' => false,
			])
			->add('provider', ChoiceType::class,[
				'choices' => [
					'Gmail' => 1,
					'Outlook' => 2,
					'Yahoo' => 3,
				],
			]);
	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefault('attr', [
			'class' => 'bg-light p-3 pb-2 rounded-1',
		]);
	}
}