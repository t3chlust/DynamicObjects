<?php

declare(strict_types=1);

namespace shusha\dynamicobjects;

class Validator{

	/**
	 * Validate object properties based on provided rules.
	 *
	 * @param object $obj
	 * @param array $rules
	 * @return bool
	 */
	public static function validate(object $obj, array $rules) : bool{
		foreach($rules as $property => $rule){
			if(property_exists($obj, $property)){
				$value = $obj->$property;
				if(!call_user_func($rule, $value)){
					return false;
				}
			}
		}
		return true;
	}
}
