<?php

namespace Combodo\iTop\Controller\Form\Type\Dependency;

use Combodo\iTop\Controller\Form\Dependency\AbstractMutableDependentType;
use Combodo\iTop\Controller\Form\Dependency\MutableStatusEnumeration;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeType extends AbstractMutableDependentType
{
	public function getParent(): string
	{
		return FormType::class;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'attr' => [
				'class' => 'bg-light p-3 pb-2 rounded-1',
			],
		]);
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('office', FakeChoiceType::class,[
			'fake_collection' => 'office',
			'help' => '⚡ Will mutate place',
			// on office post submit
			'post_submit_callback' => function (FormEvent $event) {
				// add place field to parent form
				$event->getForm()->getParent()->add('place', IntegerType::class,[
					'required' => false,
					'disabled' => empty($event->getData()),
					// preset place default value
					'pre_set_data_callback' => function (FormEvent $event) {
						if($event->getData() === null){
							$event->setData(1); // prefer set this by model layer (not a form responsibility)
						}
					},
				]);
			}
		]);
	}

	public function mutate(FormInterface $form, array $data): array
	{
		// organization empty, we remove the form
		if(empty($data[OfficeTypeData::ORGANIZATION->name]['value'])){
			return [
				'status' => MutableStatusEnumeration::SUPPRESSION,
			];
		}

		// Combodo organization
		if($data[OfficeTypeData::ORGANIZATION->name]['value'] == 1){
			$form->add('media', ChoiceType::class, [
				'required' => true,
				'choices' => [
					'Ecran TV' => 1,
					'Vidéo Projecteur' => 2,
				]
			]);
		}

		return [
			'status' => MutableStatusEnumeration::ALTERATION,
		];
	}

}