<?php 

namespace App\Helpers;

class ValidatorHelper
{
    public static function shouldValidateField(array $fields, string $field):bool
    {
        return array_key_exists($field, $fields);
    }

    public function existsCategoryId(array $fields, string $field): bool{
        return array_key_exists($field,$fields);
    }
}