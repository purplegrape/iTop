<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Combodo\iTop\Controller\Form\Dependency\AbstractMutableDependentType;
use Combodo\iTop\Controller\Form\Dependency\MutableStatusEnumeration;
use Combodo\iTop\Controller\Form\Dependency\SlotEnumeration;
use Combodo\iTop\Controller\Form\FakeDataProvider;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FakeChoiceType extends AbstractMutableDependentType
{

	public function getParent(): string
	{
		return ChoiceType::class;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefault('required', false);
		$resolver->setDefault('placeholder', 'Please, select an option...');
		$resolver->setDefault('reset_bad_values', true);
		$resolver->setRequired('fake_collection');
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		// option reset bad values
		if(isset($options['reset_bad_values']) && $options['reset_bad_values']){

			// on pre submit
			$builder->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event) use ($options){

				// reset value if not in available choices
				if(!empty($event->getData()) && !in_array($event->getData(), $options['choices'])){

					$value = $event->getData();
					$event->getForm()->addError(new FormError("The value $value has been reset because it is not part of the available choices anymore."));

					// unset if not required or first element
					$event->setData($options['required'] ? array_values($options)[0] : null);
				}

			});
		}
	}

	public function mutate(FormInterface $form, array $data): array
	{
		// update options with dependency value
		$options = $form->getConfig()->getOptions();
		$collection = $options['fake_collection'];

		// dynamic data
		$hasAdditionalData = array_key_exists(FakeChoiceTypeData::ADDITIONAL_FILTER->name, $data);
		$filterData = $data[FakeChoiceTypeData::FILTER->name];
		if($hasAdditionalData){
			$additionalFilterData = $data[FakeChoiceTypeData::ADDITIONAL_FILTER->name];
		}

		// filter empty, we remove the form
		if(empty($filterData['value'])){
			return [
				'status' => MutableStatusEnumeration::SUPPRESSION,
			];
		}

		if(!$hasAdditionalData){

			// filter
			$options['choices'] = FakeDataProvider::getFakeData($collection,
				$filterData['bound_name'], $filterData['value']);
		}
		else{

			// filter + additional
			$options['choices'] = FakeDataProvider::getFakeData2($collection,
				$filterData['bound_name'], $filterData['value'],
				$additionalFilterData['bound_name'], $additionalFilterData['value']);
		}

		return [
			'status' => MutableStatusEnumeration::MUTATION,
			'type' => FakeChoiceType::class,
			'options' => $options
		];
	}

}