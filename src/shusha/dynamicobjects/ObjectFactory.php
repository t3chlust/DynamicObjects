<?php

declare(strict_types=1);

namespace shusha\dynamicobjects;

use ReflectionClass;
use ReflectionException;

class ObjectFactory{

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 * @throws ReflectionException
	 */
	public static function newInstance(string $class) : object{
		$clazz = new ReflectionClass($class);
		$numberOfParameters = $clazz->getConstructor()?->getNumberOfParameters() ?? 0;
		if($numberOfParameters <= 0){
			return new $class();
		}
		return $clazz->newInstanceWithoutConstructor();
	}

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 * @throws ReflectionException
	 */
	public static function dehydrate(string $class, array $params, array $constructorArgs = []) : object{
		if($class === \stdClass::class){
			return (object) $params;
		}

		$clazz = new ReflectionClass($class);
		$obj = self::newInstance($class);

		foreach($params as $k => $v){
			if($clazz->hasProperty($k)){
				$property = $clazz->getProperty($k);

				/** @noinspection PhpExpressionResultUnusedInspection */
				$property->setAccessible(true);
				if($property->isPromoted()){
					$constructorArgs[$k] = $v;
				}else{
					$property->setValue($obj, $v);
				}
			}
		}

		$clazz->getConstructor()?->invokeArgs($obj, $constructorArgs);

		return $obj;
	}
}