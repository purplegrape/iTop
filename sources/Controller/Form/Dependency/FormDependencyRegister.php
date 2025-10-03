<?php

namespace Combodo\iTop\Controller\Form\Dependency;

use Symfony\Component\Form\FormInterface;

/**
 * Store the dependencies of forms.
 *
 */
class FormDependencyRegister
{
	/** @var array form dependencies declaration */
	private array $formDeclarations = [];

	/**
	 * Get form declaration
	 *
	 * @param FormInterface $form
	 *
	 * @return array
	 */
	public function &getFormDeclarations(FormInterface $form): array
	{
		// construct uuid
		$uuid = $this->getFormPathAsString($form);

		// create declaration if not exists
		if(!array_key_exists($uuid, $this->formDeclarations)){
			$formDeclaration = [
				'uuid' => $uuid,
				'name' => $form->getName(),
				'form' => $form,
				'path' => $this->getFormPathAsFlatArray($form),
				'bound' => [],
				'bindings' => [],
				'order' => count($this->formDeclarations) + 1,
			];

			$this->formDeclarations[$uuid] = $formDeclaration;

			if($form->getConfig()->hasOption(FormTypeExtension::OPTION_BINDINGS)) {
				foreach ($form->getConfig()->getOption(FormTypeExtension::OPTION_BINDINGS) as $dependencyPath => $slot) {

					$dependentForm = $this->getFormFromPathAsString($form->getRoot(), $dependencyPath);
					$dependencyFormDeclaration = &$this->getFormDeclarations($dependentForm);
					$dependencyFormDeclaration['bound'][] = [
						'uuid' => $uuid,
						'slot' => $slot->name,
					];
					$this->formDeclarations[$uuid]['bindings'][] = $dependencyFormDeclaration['uuid'];
				}
			}

		}

		return $this->formDeclarations[$uuid];
	}

	public function getFormDeclaration(string $uuid): array
	{
		return $this->formDeclarations[$uuid];
	}

	public function getForms(): array
	{
		return $this->formDeclarations;
	}


	/**
	 * Get a form from a array of path elements.
	 *
	 * @param FormInterface $root the root form
	 * @param array $pathElements the path elements
	 * @param bool $withRoot
	 *
	 * @return FormInterface
	 */
	public function getFormFromPathAsArray(FormInterface $root, array $pathElements, bool $withRoot = false): FormInterface
	{
		$name = array_pop($pathElements);

		if(!$withRoot){
			array_shift($pathElements);
		}

		if(count($pathElements) > 0) {
			foreach ($pathElements as $pathElement) {
				$root = $root->get($pathElement);
			}
		}

		return $root->get($name);
	}

	/**
	 * Get form from a string path.
	 *
	 * @param FormInterface $root the root form
	 * @param string $path the path as a string
	 *
	 * @return FormInterface
	 */
	public function getFormFromPathAsString(FormInterface $root, string $path): FormInterface
	{
		$pathElements = explode('.', $path);

		return $this->getFormFromPathAsArray($root, $pathElements, true);
	}

	/**
	 * @param FormInterface $root
	 * @param string $path
	 *
	 * @return bool
	 */
	public function isFormPathExist(FormInterface $root, string $path): bool
	{
		$pathElements = explode('.', $path);

		$name = array_pop($pathElements);

		if(count($pathElements) > 0) {
			foreach ($pathElements as $pathElement) {
				if($root->has($pathElement))
				{
					$root = $root->get($pathElement);
				}
				else return false;
			}
		}

		return $root->has($name);
	}

	/**
	 * @param FormInterface $root
	 * @param FormInterface $formInterface
	 *
	 * @return bool
	 */
	public function isFormExist(FormInterface $root, FormInterface $formInterface): bool
	{
		$path = $this->getFormPathAsString($formInterface, false);
		return $this->isFormPathExist($root, $path);
	}




	/**
	 * Get a form path as an array.
	 *
	 * @param FormInterface $form
	 *
	 * @return array
	 */
	public function getFormPathAsFlatArray(FormInterface $form): array
	{
		$result = [$form->getName()];

		while($form->getParent() !== null){
			$form = $form->getParent();
			array_unshift($result, $form->getName());
		}

		return $result;
	}

	/**
	 * Get a form path as a string.
	 *
	 * @param FormInterface $form
	 * @param bool $withRoot
	 *
	 * @return string
	 */
	public function getFormPathAsString(FormInterface $form, bool $withRoot = true): string
	{
		$path = $this->getFormPathAsFlatArray($form);

		if(!$withRoot){
			array_shift($path);
		}

		return implode( '.', $path);
	}
}