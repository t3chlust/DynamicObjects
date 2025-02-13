<?php

declare(strict_types=1);

namespace shusha;

class Cloner{

	/**
	 * Clone an object.
	 *
	 * @param object $obj
	 * @return object
	 */
	public static function clone(object $obj) : object{
		return clone $obj;
	}
}