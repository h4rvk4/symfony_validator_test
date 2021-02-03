<?php

namespace App;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DemoFormType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('field_1', TextType::class, [
				'empty_data' => '',
				'constraints' => [
					new NotBlank(["message" => "field_1 is empty"])
				]
			])
			->add('field_2', TextType::class, [
				'empty_data' => '',
				'constraints' => [
					new NotBlank(["message" => "field_2 is empty"])
				]
			])
			->add('field_3', TextType::class, [
				'empty_data' => '',
				'constraints' => [
					new AtLeastOneOf([
						'constraints' => [
							new Blank(),
							new Length(["min" => 10, "max" => 20 ])
						]
					])
				]
			])
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([
			'data_class' => null,
			'csrf_protection' => false
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return '';
	}
}
