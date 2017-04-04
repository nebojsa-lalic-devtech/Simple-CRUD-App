<?php

namespace app\NL\bootstrap;

use app\NL\Models\Employee\EmployeeServiceMongodb;
use app\NL\Models\Employee\EmployeeServiceMysql;

require_once __DIR__ . '\..\database\config.php';

switch (CURRENT_DB) {
    case 'mysql':
        $employeeService = new EmployeeServiceMysql();
        break;
    case 'mongodb':
        $employeeService = new EmployeeServiceMongodb();
        break;
    default:
        break;
}

