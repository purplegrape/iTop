<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Symfony\Component\Form\DataTransformerInterface;

class OQLDataTransformer implements DataTransformerInterface
{

	public function transform(mixed $value): string
	{
		if (null === $value) {
			return '';
		}

		return $value->getOQL();
	}

	public function reverseTransform(mixed $value): ?OQLData
	{
		if (!$value) {
			return null;
		}

		return new OQLData($value);
	}
}