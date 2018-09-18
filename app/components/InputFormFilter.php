<?php

namespace app\components;

class InputFormFilter
{
    public static function filterDataForm(array $data): array
    {
        foreach ($data as $key => $value) {
            $formData[$key] = htmlspecialchars($value);
        }
        return $formData;
    }
}