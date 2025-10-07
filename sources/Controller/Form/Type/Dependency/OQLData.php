<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

class OQLData implements ClassProviderInterface
{


	public function __construct(private string $sOQL)
	{

	}

	public function GetOQL(): string
	{
		return $this->sOQL;
	}

	public function GetObjectClass(): string
	{
		return 'Contact';
	}
}