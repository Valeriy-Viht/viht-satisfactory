<?php


namespace App\Utils;

use InvalidArgumentException;

final class TypeAssert {

    public static function exists(string $type) {
        if (!class_exists($type) && !interface_exists($type)) {
            throw new InvalidArgumentException("Provided class or interface does't exists");
        }
    } 

}