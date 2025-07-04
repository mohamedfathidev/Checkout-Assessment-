<?php

namespace App\Services;

class ValidationService
{
    public function getValidationRules($prefix)
    {
        return [
            "$prefix.name" => "required|string",
            "$prefix.email" => "required|email",
            "$prefix.street1" => "required|string",
            "$prefix.city" => "required|string",
            "$prefix.state" => "required|string",
            "$prefix.country" => "required|string",
            "$prefix.zip" => "required|string",
        ];
    }
} 