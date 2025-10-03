<?php

namespace Combodo\iTop\Controller\Form\Dependency;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension declaring dependencies options.
 */
class FormTypeExtension extends AbstractTypeExtension
{
	const OPTION_BINDINGS = 'bindings';
	const OPTION_POST_SUBMIT_CALLBACK  = 'post_submit_callback';
	const OPTION_PRE_SET_DATA_CALLBACK = 'pre_set_data_callback';

	public function __construct(private readonly FormDependencyManager $formDependencyManager)
	{

	}

	public static function getExtendedTypes(): iterable
	{
		return [FormType::class];
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefined(self::OPTION_BINDINGS);
		$resolver->setDefined(self::OPTION_POST_SUBMIT_CALLBACK);
		$resolver->setDefined(self::OPTION_PRE_SET_DATA_CALLBACK);
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		// register form events for bindings
		if(isset($options[self::OPTION_BINDINGS])) {
			$this->formDependencyManager->register($builder);
		}

		// facility to add a callback to the POST_SUBMIT event
		if(array_key_exists(self::OPTION_POST_SUBMIT_CALLBACK, $builder->getOptions())){
			$builder->addEventListener(FormEvents::POST_SUBMIT, $builder->getOptions()[self::OPTION_POST_SUBMIT_CALLBACK]);
		}

		// facility to add a callback to the PRE_SET_DATA event
		if(array_key_exists(self::OPTION_PRE_SET_DATA_CALLBACK, $builder->getOptions())){
			$builder->addEventListener(FormEvents::PRE_SET_DATA, $builder->getOptions()[self::OPTION_PRE_SET_DATA_CALLBACK]);
		}
	}


}