<?php
class AllInfinitasBotTestsTest extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All InfinitasBot tests');

		$path = CakePlugin::path('InfinitasBot') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}
}
