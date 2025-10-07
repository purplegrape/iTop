<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Combodo\iTop\Controller\Form\Dependency\AbstractMutableDependentType;
use Combodo\iTop\Controller\Form\Dependency\MutableStatusEnumeration;
use Combodo\iTop\Controller\Form\Dependency\SlotEnumeration;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;

class AttributeChoiceType extends AbstractMutableDependentType
{

	public function getParent(): string
	{
		return ChoiceType::class;
	}

	public function mutate(FormInterface $form, array $data): array
	{
		$options = $form->getConfig()->getOptions();

		$value = $data[AttributeChoiceTypeData::OBJECT_CLASS->name]['value'];

		$options['choices'] = [];

		if($value !== null){
			// attributes of the selected class
			$objectClass = $value->GetObjectClass();
			foreach (\MetaModel::GetAttributesList($objectClass) as $attCode){
				$options['choices'][$attCode] = $attCode;
			}
			// mute type
			return [
				'status' => MutableStatusEnumeration::MUTATION,
				'type' => ChoiceType::class,
				'options' => $options
			];
		}
		else{
			// delete type
			return [
				'status' => MutableStatusEnumeration::SUPPRESSION,
			];
		}

	}

}