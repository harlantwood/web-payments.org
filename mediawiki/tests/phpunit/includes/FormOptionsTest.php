<?php
/**
 * This file host two test case classes for the MediaWiki FormOptions class:
 *  - FormOptionsInitializationTest : tests initialization of the class.
 *  - FormOptionsTest : tests methods an on instance
 *
 * The split let us take advantage of setting up a fixture for the methods
 * tests.
 */

/**
 * Test class for FormOptions methods.
 * Generated by PHPUnit on 2011-02-28 at 20:46:27.
 *
 * Copyright © 2011, Ashar Voultoiz
 *
 * @author Ashar Voultoiz
 */
class FormOptionsTest extends MediaWikiTestCase {
	/**
	 * @var FormOptions
	 */
	protected $object;

	/**
	 * Instanciates a FormOptions object to play with.	 
	 * FormOptions::add() is tested by the class FormOptionsInitializationTest
	 * so we assume the function is well tested already an use it to create
	 * the fixture.
	 */
	protected function setUp() {
		$this->object = new FormOptions;
		$this->object->add( 'string1', 'string one' );
		$this->object->add( 'string2', 'string two' );
		$this->object->add( 'integer',  0 );
		$this->object->add( 'intnull',  0, FormOptions::INTNULL );
	}

	/** Helpers for testGuessType() */
	/* @{ */
	private function assertGuessBoolean( $data ) {
		$this->guess( FormOptions::BOOL, $data );
	}
	private function assertGuessInt( $data ) {
		$this->guess( FormOptions::INT, $data );
	}
	private function assertGuessString( $data ) {
		$this->guess( FormOptions::STRING, $data );
	}

	/** Generic helper */
	private function guess( $expected, $data ) {
		$this->assertEquals(
			$expected,
			FormOptions::guessType( $data )
		);
	}
	/* @} */

	/**
	 * Reuse helpers above assertGuessBoolean assertGuessInt assertGuessString
	 */
	public function testGuessTypeDetection() {
		$this->assertGuessBoolean( true  );
		$this->assertGuessBoolean( false );

		$this->assertGuessInt(    0 );
		$this->assertGuessInt(   -5 );
		$this->assertGuessInt(    5 );
		$this->assertGuessInt( 0x0F );

		$this->assertGuessString( 'true'  );
		$this->assertGuessString( 'false' ); 
		$this->assertGuessString( '5'     ); 
		$this->assertGuessString( '0'     ); 
	}

	/**
	 * @expectedException MWException 
	 */
	public function testGuessTypeOnArrayThrowException() {
		$this->object->guessType( array( 'foo' ) ); 
	}
	/**
	 * @expectedException MWException 
	 */
	public function testGuessTypeOnNullThrowException() {
		$this->object->guessType( null ); 
	}
}
