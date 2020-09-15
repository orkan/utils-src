<?php

namespace Orkan\Tests;

use ReflectionClass;

class Utils
{

	/**
	 * Set Object's private property
	 *
	 * @param object $obj
	 * @param string $property Property name
	 * @param mixed $value New value
	 */
	public static function setPrivateProperty( object $obj, string $property, $value ): void
	{
		$class = new ReflectionClass( $obj );
		$item = $class->getProperty( $property );
		$item->setAccessible( true );
		$item->setValue( $obj, $value );
	}

	/**
	 * Get Object's private property
	 *
	 * @param object $obj
	 * @param string $property Property name
	 * @return mixed
	 */
	public static function getPrivateProperty( object $obj, string $property )
	{
		$class = new ReflectionClass( $obj );
		$item = $class->getProperty( $property );
		$item->setAccessible( true );
		return $item->getValue( $obj );
	}

	/**
	 * Call Object's private method
	 *
	 * @param object $obj
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public static function callPrivateMethod( object $obj, string $method, $args = [] )
	{
		$class = new ReflectionClass( $obj );
		$name = $class->getMethod( $method );
		$name->setAccessible( true ); // Set method to public
		return $name->invokeArgs( $obj, $args ); // Call $this->name( $args );
	}
}
