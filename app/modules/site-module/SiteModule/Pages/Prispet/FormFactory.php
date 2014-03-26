<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace SiteModule\Pages\Prispet;

use Venne\Forms\Form;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class FormFactory extends \Venne\Forms\FormFactory
{

	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addGroup();
		$money = $form->addSelect('money', 'Přispívám částkou')->setItems(array(
			'1000' => '1 000',
			'100' => '100',
			'250' => '250',
			'500' => '500',
			'2500' => '2 500',
			'5000' => '5 000',
			'other' => 'jinou',
		));
		$money
			->setDefaultValue('1000')
			->addCondition($form::EQUAL, 'other')->toggle('group-other');

		$form->addGroup()->setOption('id', 'group-other');
		$form->addText('moneyOther', 'Částkou')
			->addConditionOn($money, $form::EQUAL, 'other')
			->addRule($form::INTEGER, 'Částka musí být celé kladné číslo');

		$form->addGroup();
		$form->addSelect('ucely', 'Peníze použít na', array(
			'1' => 'Nechám to na Vás',
			'2' => 'Kancelář',
			'4' => 'Internetová reklama',
			'8' => 'Billboardy',
			'16' => 'Kontaktní kampaň',
			'32' => 'Tiskoviny a reklamní materiály',
		));

		$person = $form->addRadioList('person', 'Osoba', array(
			'fyzicka' => 'Fyzická osoba',
			'pravnicka' => 'Právnická osoba',
		));
		$person
			->addRule($form::FILLED, 'Prosím vyplňte osobu');
		$person
			->addCondition($form::EQUAL, 'fyzicka')->toggle('group-fyzicka')
			->endCondition()->addCondition($form::EQUAL, 'pravnicka')->toggle('group-pravnicka')
			->endCondition()->addCondition($form::IS_IN, array('pravnicka', 'fyzicka'))->toggle('group-next');

		$fyzicka = $form->addContainer('fyzicka');
		$fyzicka->setCurrentGroup($form->addGroup()->setOption('id', 'group-fyzicka'));
		$fyzicka->addText('name', 'Jméno a příjmení')
			->addConditionOn($person, $form::EQUAL, 'fyzicka')
			->addRule($form::FILLED, 'Prosím vyplňte jméno a příjmení');
		$fyzicka->addText('bornDate', 'Datum narození')
			->addConditionOn($person, $form::EQUAL, 'fyzicka')
			->addRule($form::FILLED, 'Prosím vyplňte datum narození');


		$pravnicka = $form->addContainer('pravnicka');
		$pravnicka->setCurrentGroup($form->addGroup()->setOption('id', 'group-pravnicka'));
		$pravnicka->addText('name', 'Název firmy')
			->addConditionOn($person, $form::EQUAL, 'pravnicka')
			->addRule($form::FILLED, 'Prosím vyplňte název firmy');
		$pravnicka->addText('person', 'Jméno a příjmení zástupce')
			->addConditionOn($person, $form::EQUAL, 'pravnicka')
			->addRule($form::FILLED, 'Prosím vyplňte jméno a příjmení zástupce');
		$pravnicka->addText('IC', 'IČ')
			->addConditionOn($person, $form::EQUAL, 'pravnicka')
			->addRule($form::FILLED, 'Prosím vyplňte IČ');


		$form->addGroup()->setOption('id', 'group-next');
		$form->addText('street', 'Ulice a číslo popisné')
			->addRule($form::FILLED, 'Prosím vyplňte ulici');
		$form->addText('city', 'Město / obec')
			->addRule($form::FILLED, 'Prosím vyplňte město / obec');
		$form->addText('psc', 'PSČ')
			->addRule($form::FILLED, 'Prosím vyplňte PSČ');

		$email = $form->addText('email', 'E-mail');
		$email
			->addRule($form::FILLED, 'Prosím vyplňte e-mail')
			->addRule($form::EMAIL, 'E-mail není ve správném tvaru');
		$email->controlPrototype->placeholder = '@';


		$form->setCurrentGroup();
		$submit = $form->addSaveButton('Odeslat');
		$submit->getControlPrototype()->class = 'btn-primary btn-block';
		$submit->getControlPrototype()->style[] = 'font-size: 25px; font-style: italic;';
	}

}
