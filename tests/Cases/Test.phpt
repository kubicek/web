<?php

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class Test extends TestCase
{

	/** @var \Selenium\Browser */
	private $browser;


	protected function setUp()
	{
		$client = new \Selenium\Client('127.0.0.1');
		$this->browser = $client->getBrowser('http://s-web.zvara.cz');
		$this->browser->start();
	}


	public static function dataTestReplaceBlock()
	{
		return array(
			'/' => array('Úvod | Svobodní'),

			'/clanky' => array('Články | Svobodní'),
			'/clanky/stanoviska-strany' => array('Stanoviska strany | Svobodní'),
			'/clanky/kratka-sdeleni' => array('Krátká sdělení | Svobodní'),

			'/program' => array('Program | Svobodní'),
			'/program/politicka-filosofie' => array('Politická filosofie | Svobodní'),
			'/program/politicky-program' => array('Politický program | Svobodní'),
			'/program/otazky-a-odpovedi' => array('Otázky a odpovědi | Svobodní'),
			'/program/archiv-programovych-dokumentu' => array('Archiv programových dokumentů | Svobodní'),
			'/program/ustavujici-projevy' => array('Ustavující projevy | Svobodní'),

			'/lide' => array('Lidé | Svobodní'),
			'/lide/kandidati-v-eurovolbach' => array('Kandidáti v eurovolbách | Svobodní'),
			'/lide/republikove-predsednictvo' => array('Republikové předsednictvo | Svobodní'),
			'/lide/republikovy-vybor' => array('Republikový výbor | Svobodní'),
			'/lide/krajska-predsednictva' => array('Krajská předsednictva | Svobodní'),
			'/lide/zvoleni-zastupitele' => array('Zvolení zastupitelé | Svobodní'),

			'/udalosti' => array('Události | Svobodní'),
			'/udalosti?archive=1' => array('Události | Svobodní'),

			'/pro-media' => array('Pro média | Svobodní'),
			'/pro-media/fotobanka' => array('Fotobanka | Svobodní'),
			'/pro-media/kontakty' => array('Kontakty | Svobodní'),

			'/mapa-webu' => array('Mapa webu | Svobodní'),
			'/tv' => array('TV | Svobodní'),
			'/vyhledat' => array('Vyhledat | Svobodní'),
			'/external' => array('External | Svobodní'),
		);
	}


	public function testReplaceBlock()
	{
		foreach (self::dataTestReplaceBlock() as $url => $data)

			$this->browser
				->open($url)
				->waitForPageToLoad(5);

		Assert::same($data[0], $this->browser->getTitle());
	}


	protected function tearDown()
	{
		$this->browser->stop();
	}

}

$testCase = new Test;
$testCase->run();
