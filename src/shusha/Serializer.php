<?php

declare(strict_types=1);

namespace shusha;

use ReflectionClass;
use ReflectionException;

class Serializer{

	/**
	 * Serialize an object to an array.
	 *
	 * @param object $obj
	 * @return array
	 */
	public static function serialize(object $obj) : array{
		$result = [];
		$clazz = new ReflectionClass($obj);

		foreach($clazz->getProperties() as $property){

			/** @noinspection PhpExpressionResultUnusedInspection */
			$property->setAccessible(true);
			$result[$property->getName()] = $property->getValue($obj);
		}

		return $result;
	}

	/**
	 * Deserialize an array to an object.
	 *
	 * @template T of object
	 * @param class-string<T> $class
	 * @param array $data
	 * @return T
	 * @throws ReflectionException
	 */
	public static function deserialize(string $class, array $data) : object{
		return ObjectFactory::dehydrate($class, $data);
	}
}