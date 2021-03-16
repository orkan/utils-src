<?php
/*
 * This file is part of the orkan/tvguide package.
 *
 * Copyright (c) 2020 Orkan <orkans@gmail.com>
 */
use Orkan\Utils;
use PHPUnit\Framework\TestCase;

/**
 * Importers test suite
 *
 * @author Orkan <orkans@gmail.com>
 */
class UtilsTest extends TestCase
{

	// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers Helpers
	// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function setUp(): void
	{
	}

	// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests: Tests:
	// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Print message to log file if defined( 'TESTING' )
	 * See: ./_cmd/phpunit.xml for defined constants
	 * See: ../src/TESTING-Orkan-Utils-print.log for output
	 */
	public function test_print()
	{
		Utils::print( sprintf( "Hello from %s() in %s, line: %d\n", __METHOD__, __FILE__, __LINE__ ) );

		$this->assertTrue( true );
	}

	public function test_print_r()
	{
		$needle = 'Hello World!';

	/* @formatter:off */
		$a = [
			'key1' => 'aaa',
			'key2' => [
				'key2.1' => 'bbb',
				'key2.2' => new Prop(),
				'key2.3' => 'ccc',
			],
			'key3' => new Prop( $needle ),
			'key4' => 'ddd',
		];
		/* @formatter:on */

		// Don't exclude Objects so PHP::print_r() will parse each property in output
		$result = Utils::print_r( $a, false );
		$this->assertStringContainsString( $needle, $result, 'Missing Object property in output' );

		// Replace each Object in array with class name string
		$result = Utils::print_r( $a );
		$this->assertStringNotContainsString( $needle, $result, 'Missing Object property in output' );
	}
}

class Prop
{
	public $prop;

	public function __construct( $set = 'property' )
	{
		$this->prop = $set;
	}
}

