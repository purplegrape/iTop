<?php

namespace Combodo\iTop\Controller\Form\Dependency;

use LogicException;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * Handle dependencies.
 */
class FormDependencyManager implements EventSubscriberInterface
{
	/** @var array triggered events */
	private array $events = [];

	/** @var FormDependencyRegister registered forms */
	private FormDependencyRegister $formRegister;

	/** @var FormDependencyDataRegister register for post set data events */
	private FormDependencyDataRegister $postSetDataRegister;

	/** @var FormDependencyDataRegister register for post submit events */
	private FormDependencyDataRegister $postSubmitRegister;

	/** @inheritdoc  */
	public static function getSubscribedEvents(): array
	{
		return [
			FormEvents::POST_SET_DATA => 'onPostSetData',
			FormEvents::POST_SUBMIT   => 'onPostSubmit',
		];
	}

	/**
	 * Constructor.
	 *
	 */
	public function __construct()
	{
		$this->formRegister = new FormDependencyRegister();
		$this->postSetDataRegister = new FormDependencyDataRegister();
		$this->postSubmitRegister = new FormDependencyDataRegister();
	}

	/**
	 * Listen the form builder.
	 *
	 * @param FormBuilderInterface $builder
	 */
	public function register(FormBuilderInterface $builder): void
	{
		// listen form builder events
		$builder->addEventSubscriber($this);
	}

	/**
	 * POST_SET_DATA event handler
	 *
	 * @param PostSetDataEvent $event
	 *
	 * @return void
	 */
	public function onPostSetData(PostSetDataEvent $event): void
	{
		$this->handleForm($this->postSetDataRegister, $event);
	}

	/**
	 * POST_SUBMIT event handler
	 *
	 * @param PostSubmitEvent $event
	 *
	 * @return void
	 */
	public function onPostSubmit(PostSubmitEvent $event): void
	{
		$this->handleForm($this->postSubmitRegister, $event);
	}

	/**
	 * Handle form dependencies.
	 *
	 * @param FormDependencyDataRegister $dataRegister
	 * @param FormEvent $event
	 */
	private function handleForm(FormDependencyDataRegister $dataRegister, FormEvent $event): void
	{
		// performed actions
		$performedActions = [];

		// get event form
		$formDeclaration = $this->formRegister->getFormDeclarations($event->getForm());

		// store the received event data
		$dataRegister->setPathValue($formDeclaration['path'], $event->getForm()->getData());

		// iterate throw binding...
		foreach ($formDeclaration['bindings'] as $uuid) {

			try{
				// handle bound form
				$performedAction = $this->handleBoundForm($uuid, $dataRegister);
				if($performedAction){
					$performedActions[] = $performedAction;
				}
			}
			catch(IncompleteDependenciesException|MissingFormException){
				// if a form is not available, we skip this element
				// if all dependencies data are not available, skip this element
				continue;
			}
		}

		// store the event process information
		$this->events[] = [
			'type' => (new ReflectionClass($event))->getShortName(),
			'event' => $event,
			'actions' => $performedActions,
		];
	}

	/**
	 * Handle bound form.
	 *
	 * @throws MissingFormException
	 * @throws IncompleteDependenciesException
	 */
	private function handleBoundForm(string $uuid,  FormDependencyDataRegister $dataRegister): ?array
	{
		// retrieve affected form declaration
		$formDeclaration = $this->formRegister->getFormDeclaration($uuid);
		$boundForm = $formDeclaration['form'];

		// missing form
		if(!$this->formRegister->isFormExist($boundForm->getRoot(), $boundForm)){
			throw new MissingFormException();
		}

		// get dependencies data
		$bounds = [];
		foreach($formDeclaration['bound'] as $bound){
			$bounds[] = [
				'form' => $this->formRegister->getFormDeclaration($bound['uuid']),
				'bound' => $bound,
			];
		}
		$dependenciesData = $dataRegister->getDependenciesData($boundForm, $bounds);

		// retrieve form type
		$type = $boundForm->getConfig()->getType()->getInnerType();

		// if type mutable, mutate it
		if($type instanceof AbstractMutableDependentType) {
			return $this->handleMutableTypeForm($type, $dependenciesData, $formDeclaration, $boundForm);
		}

		return null;
	}

	/**
	 * Handle mutable type form.
	 *
	 * @param AbstractMutableDependentType $type
	 * @param array $dependenciesData
	 * @param array $formDeclaration
	 * @param FormInterface $boundForm
	 *
	 * @return array
	 */
	private function handleMutableTypeForm(AbstractMutableDependentType $type, array $dependenciesData, array $formDeclaration, FormInterface $boundForm): array
	{
		// retrieve parent form
		$parentForm = $boundForm->getParent();

		// mutate form element
		$mutation = $type->mutate($boundForm, $dependenciesData);

		switch($mutation['status']){

			case MutableStatusEnumeration::MUTATION:
				$parentForm->add($boundForm->getName(), $mutation['type'], $mutation['options'] ?? []);
				return [
					'form' => $boundForm->getName(),
					'action' => $mutation['status']->name,
					'type' => $mutation['type'],
				];

			case MutableStatusEnumeration::ALTERATION:
				$parentForm->add($boundForm);
				return [
					'form' => $boundForm->getName(),
					'action' => $mutation['status']->name,
				];

			case MutableStatusEnumeration::SUPPRESSION:
				$this->removeFormElement($formDeclaration);
				return [
					'form' => $boundForm->getName(),
					'action' => $mutation['status']->name,
				];

			default:
				throw new LogicException('Unknown mutation status');
		}
	}

	/**
	 * Remove a form element.
	 *
	 * @param array $formDeclaration
	 *
	 * @return void
	 */
	private function removeFormElement(array $formDeclaration): void
	{
		$form = $formDeclaration['form'];
		$bindings = $formDeclaration['bindings'];

		// replace with unmapped|disabled hidden field
		$form->getParent()->add($form->getName(), HiddenType::class, [
			'mapped' => false,
			'disabled' => true,
		]);

		// remove bound forms...
		foreach($bindings as $affect){
			$this->removeFormElement($this->formRegister->getFormDeclaration($affect));
		}
	}



	public function getEvents(): array
	{
		return $this->events;
	}

	public function getPostSetData(): array
	{
		return $this->postSetDataRegister->getData();
	}

	public function getPostSubmit(): array
	{
		return $this->postSubmitRegister->getData();
	}

	public function getFormDeclarations(): array
	{
		return $this->formRegister->getForms();
	}
}