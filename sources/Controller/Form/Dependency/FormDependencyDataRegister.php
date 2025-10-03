<?php

namespace Combodo\iTop\Controller\Form\Dependency;

use Symfony\Component\Form\FormInterface;


/**
 * Store the dependencies data for a form.
 */
class FormDependencyDataRegister
{
	/** @var array data */
	private array $data = [];

	/**
	 * Set a value.
	 *
	 * @param array $path
	 * @param mixed|null $value
	 *
	 * @return void
	 */
	public function setPathValue(array $path, mixed $value = null): void
	{
		$key = $path[0];

		if(count($path) === 1) {
			$this->data[$key] = $value;
		}
		else{
			if(!array_key_exists($key, $this->data) || $this->data[$key] === null){
				$this->data[$key] = [];
			}
			array_shift($path);
			$this->setPathValue($path, $value);
		}
	}

	/**
	 * Get a value.
	 *
	 * @param array $path
	 *
	 * @return mixed
	 * @throws MissingDataException
	 */
	public function getPathValue(array $path): mixed
	{
		$key = $path[0];

		if(!array_key_exists($key, $this->data)){
			throw new MissingDataException("data $key doesn't exists");
		}

		if(count($path) === 1) {
			return $this->data[$key];
		}
		else{
			array_shift($path);
			return $this->getPathValue($path);
		}
	}

	/**
	 * Get dependencies data.
	 *
	 * @param FormInterface $form
	 * @param array $bounds
	 *
	 * @return array
	 * @throws IncompleteDependenciesException
	 */
	public function getDependenciesData(FormInterface $form, array $bounds): array
	{
		$result = [];

		foreach($bounds as $boundElement){

			try{
				$value = $this->getPathValue($boundElement['form']['path']);
			}
			catch(MissingDataException){
				throw new IncompleteDependenciesException();
			}

			$result[$boundElement['bound']['slot']] = [
				'bound_name' => $boundElement['form']['name'],
				'value' => $value
			];

		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}
}