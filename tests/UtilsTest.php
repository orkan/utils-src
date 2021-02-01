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
	public function testPrint()
	{
		Utils::print( sprintf( "Hello from %s() in %s, line: %d\n", __METHOD__, __FILE__, __LINE__ ) );

		$this->assertTrue( true );
	}
}
