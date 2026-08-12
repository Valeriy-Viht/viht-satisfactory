<?php


namespace App\Utils;

use InvalidArgumentException;

final class TypeAssert {

    public static function exists(string $type) {
        if (!class_exists($type) && !interface_exists($type)) {
            throw new InvalidArgumentException("Provided class or interface does't exists");
        }
    } 

    public static function isSubClassOf(string $child, string $parent) {
        if (!is_subclass_of($child, $parent)) {
            throw new InvalidArgumentException("Provided type isn't subclass of other type");
        }
    } 
}