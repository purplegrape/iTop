<?php

namespace Combodo\iTop\Controller\Form\Dependency;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;

abstract class AbstractMutableDependentType extends AbstractType
{
	public abstract function mutate(FormInterface $form, array $data): array;
}