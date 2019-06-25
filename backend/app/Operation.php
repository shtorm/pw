<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Operation
 * @package App
 */
class Operation extends Model
{
    const TYPE_INTERNAL_TRANSFER = 1;

    public static function getAllTypes($joinWithComma = false)
    {
        $reflectionClass = new \ReflectionClass(self::class);

        $arrTypes = $reflectionClass->getConstants();
    }
}
