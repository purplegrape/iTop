<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Combodo\iTop\Controller\Form\Dependency\AbstractMutableDependentType;
use Combodo\iTop\Controller\Form\Dependency\MutableStatusEnumeration;
use Combodo\iTop\Controller\Form\Type\Form\MailType;
use Combodo\iTop\Controller\Form\Type\Form\PhoneType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;

class ContactType extends AbstractMutableDependentType
{
	public function getParent(): string
	{
		return HiddenType::class;
	}

	public function mutate(FormInterface $form, array $data): array
	{
		return match ($data[ContactTypeData::CONTACT_TYPE->name]['value']) {

			1 => [
				'status'  => MutableStatusEnumeration::MUTATION,
				'type'    => MailType::class,
			],
			2 => [
				'status'  => MutableStatusEnumeration::MUTATION,
				'type'    => PhoneType::class,
			],
			default => [
				'status' => MutableStatusEnumeration::SUPPRESSION,
			],
		};

	}

}