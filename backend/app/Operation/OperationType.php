<?php
/**
 * Created by PhpStorm.
 * User: Emil Vililyaev
 * Date: 23.01.19
 * Time: 12:29
 */

namespace App\Operation;

class OperationType
{
    const TYPE_INTERNAL_TRANSFER = 1;

    /**
     * @return array|string
     * @throws \ReflectionException
     */
    public static function getAll()
    {
        $reflectionClass = new \ReflectionClass(self::class);

        return $reflectionClass->getConstants();
    }
}