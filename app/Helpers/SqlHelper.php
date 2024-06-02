<?php

namespace App\Helpers;

class SqlHelper
{
    public static function getEmployeeFullNameSql(): string
    {
        return 'CONCAT(employees.last_name, " ", employees.first_name, " ", employees.patronymic)';
    }
}
