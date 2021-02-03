<?php

namespace App;

use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

class Tester {

	protected function getDemoForm(): FormInterface {
		$validator = Validation::createValidator();
		$formFactory = Forms::createFormFactoryBuilder()
			->addExtension(new ValidatorExtension($validator))
			->getFormFactory();
		return $formFactory->create(DemoFormType::class);
	}

	public function run() {
		echo "testWithNoData():".PHP_EOL;
		$this->testWithNoData();
		echo "".PHP_EOL;

		echo "testWithFulldataAndInvalidField3():".PHP_EOL;
		$this->testWithFulldataAndInvalidField3();
		echo "".PHP_EOL;

		echo "testWithOnlyField3Data():".PHP_EOL;
		$this->testWithOnlyField3Data();
	}

	/**
	 * Expected output:
	 * field_1: field_1 is empty
	 * field_2: field_2 is empty
	 *
	 * Current output (with Symfony 5.2.3):
	 * field_1: field_1 is empty
	 * field_2: field_2 is empty
	 *
	 * -> okay
	 */
	public function testWithNoData() {
		$postData = [];

		$form = $this->getDemoForm();
		$form->submit($postData)->isValid();
		$errors = $form->getErrors(true);
		$this->outputErrors($errors);
	}

	/**
	 * Expected output:
	 * field_3: This value should satisfy at least one of the following constraints: [1] This value should be blank. [2] This value is too short. It should have 10 characters or more.
	 *
	 * Current output (with Symfony 5.2.3):
	 * field_3: This value should satisfy at least one of the following constraints: [1] This value should be blank. [2] This value is too short. It should have 10 characters or more.
	 *
	 * -> okay
	 */
	protected function testWithFulldataAndInvalidField3() {
		$postData = [
			"field_1" => "sdsd",
			"field_2" => "sdcs",
			"field_3" => "kaktus"
		];

		$form = $this->getDemoForm();
		$form->submit($postData)->isValid();
		$errors = $form->getErrors(true);
		$this->outputErrors($errors);
	}

	/**
	 * Expected output:
	 * field_1: field_1 is empty
	 * field_2: field_2 is empty
	 * field_3: This value should satisfy at least one of the following constraints: [1] This value should be blank. [2] This value is too short. It should have 10 characters or more.
	 *
	 * Current output (with Symfony 5.2.3):
	 * field_1: field_1 is empty
	 * field_2: field_2 is empty
	 * field_3: This value should satisfy at least one of the following constraints: [1] field_1 is empty [2] field_1 is empty
	 *
	 * -> Error message of field_3 is wrong
	 */
	protected function testWithOnlyField3Data() {
		$postData = [
			"field_3" => "kaktus"
		];

		$form = $this->getDemoForm();
		$form->submit($postData)->isValid();
		$errors = $form->getErrors(true);
		$this->outputErrors($errors);
	}

	protected function outputErrors(FormErrorIterator $errors) {
		foreach ($errors as $error) {
			/** @var FormError $error */
			echo $error->getOrigin()->getName().": ".$error->getMessage().PHP_EOL;
		}
	}
}
