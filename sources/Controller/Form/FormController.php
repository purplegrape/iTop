<?php

namespace Combodo\iTop\Controller\Form;

use Combodo\iTop\Controller\Form\Type\Dependency\AttributeChoiceType;
use Combodo\iTop\Controller\Form\Type\Dependency\AttributeChoiceTypeData;
use Combodo\iTop\Controller\Form\Type\Dependency\ContactTypeData;
use Combodo\iTop\Controller\Form\Type\Dependency\FakeChoiceTypeData;
use Combodo\iTop\Controller\Form\Dependency\FormDependencyManager;
use Combodo\iTop\Controller\Form\Type\Dependency\OfficeTypeData;
use Combodo\iTop\Controller\Form\Type\Dependency\ContactType;
use Combodo\iTop\Controller\Form\Type\Dependency\FakeChoiceType;
use Combodo\iTop\Controller\Form\Type\Dependency\OfficeType;
use Combodo\iTop\Controller\Form\Type\Dependency\OQLType;
use Combodo\iTop\Controller\Form\Type\Form\Form2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormController extends AbstractController
{

	#[Route('/form')]
	public function CreateFormAction(Request $request, FormDependencyManager $formDependencyManager): Response
	{
		$form = $this->createFormBuilder([
//				'organization' => 1
			])
			->add('organization', ChoiceType::class, [
				'choices' => FakeDataProvider::getFakeData('organization'),
				'required' => false,
				'placeholder' => 'Select an organization...',
				'help' => '⚡ Will mutate person, location, location.office, country',
				'bindings' => [
					'person' => FakeChoiceTypeData::FILTER,
					'location' => OfficeTypeData::ORGANIZATION,
					'location.office' => FakeChoiceTypeData::FILTER,
					'country' => FakeChoiceTypeData::FILTER
				],
			])
			->add('country', FakeChoiceType::class, [
				'fake_collection' => 'country',
				'bindings' => [
					'location.office' => FakeChoiceTypeData::ADDITIONAL_FILTER,
				],
				'placeholder' => 'Select a country...',
				'help' => '⚡ Will mutate location.office',
			])
			->add('person', FakeChoiceType::class, [
				'fake_collection' => 'person',
				'placeholder' => 'Select a person...',
				'help' => '⚡ Will mutate email',
				'bindings' => [
					'email' => FakeChoiceTypeData::FILTER
				],
			])
			->add('email', FakeChoiceType::class,[
				'fake_collection' => 'email',
				'placeholder' => 'Select an email...',
			])
			->add('location', OfficeType::class)
			->add('contact_type', ChoiceType::class,[
				'choices' => [
					'Email' => 1,
					'Phone' => 2,
				],
				'required' => false,
				'placeholder' => 'Select a contact type...',
				'help' => '⚡ Will mutate contact form',
				'bindings' => [
					'contact' => ContactTypeData::CONTACT_TYPE
				],
			])
			->add('contact', ContactType::class)
			->add('oql', OQLType::class, [
				'bindings' => [
					'object_class' => AttributeChoiceTypeData::OBJECT_CLASS
				],
			])
			->add('object_class', AttributeChoiceType::class, [
				'required' => false,
			])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			// $form->addError(new FormError(json_encode($form->getData(), JSON_PRETTY_PRINT)));

		}

		return $this->render('form.html.twig', [
			'form' => $form->createView(),
			'events' => $formDependencyManager->getEvents(),
			'data' => [
				'form' => $this->GetPrettyJson($form->getData()),
				'post_set_data' => $this->GetPrettyJson($formDependencyManager->getPostSetData()),
				'post_submit' => $this->GetPrettyJson($formDependencyManager->getPostSubmit()),
				'declarations' => $this->GetPrettyJson($formDependencyManager-> getFormDeclarations()),
			]
		]);
	}

	private function GetPrettyJson($data): array|bool|string|null
	{
		try {
			$strData = json_encode($data, JSON_PRETTY_PRINT |JSON_THROW_ON_ERROR);
			$strData = str_replace("\n", "<br>", $strData);
			return str_replace(" ", "&nbsp;", $strData);
		}
		catch (\JsonException $exception) {
			return null;
		}

	}
}