<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Fuse\Fuse;

class IdNumberTest extends TestCase {
	protected static $fuse;

	public static function setUpBeforeClass() {
		static::$fuse = new Fuse([[
			'ISBN' => 1111,
			'title' => "Old Man's War",
			'author' => 'John Scalzi'
		], [
			'ISBN' => 2222,
			'title' => 'The Lock Artist',
			'author' => 'Steve Hamilton'
		]], [
			'keys' => ['title', 'author'],
			'id' => 'ISBN',
			'include' => ['score']
		]);
	}

	// When searching for the term "Stve"...
	public function testSearchStve() {
		$result = static::$fuse->search('Stve');

		// ...we get a list containing 1 item...
		$this->assertEquals(sizeof($result), 1);

		// ...whose value is the ISBN of the book...
		$this->assertEquals($result[0]['item'], 2222);

		// ...and has a score different than zero
		$this->assertTrue($result[0]['score'] !== 0);
	}
}