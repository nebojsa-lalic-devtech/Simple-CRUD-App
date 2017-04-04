<?php

namespace app\NL\bootstrap;

use Klein\Klein;
use MongoDB\Driver\BulkWrite;
use Smarty;
use app\NL\database\Database;
use app\NL\validation\ValidationMysql;
use app\NL\validation\ValidationMongodb;
use app\NL\Models\Employee\EmployeeServiceMysql;
use app\NL\Models\Employee\EmployeeServiceMongodb;

require_once __DIR__ . '\..\database\config.php';

$klein = new Klein();
$smarty = new Smarty();
$database = new Database();
$validationMysql = new ValidationMysql($database);
$validationMongodb = new ValidationMongodb($database);
$employeeServiceMysql = new EmployeeServiceMysql($validationMysql, $database);
$bulk = new BulkWrite();
$employeeServiceMongodb = new EmployeeServiceMongodb($bulk, $validationMongodb, $database);

switch (CURRENT_DB) {
    case 'mysql':
        $employeeService = $employeeServiceMysql;
        break;
    case 'mongodb':
        $employeeService = $employeeServiceMongodb;
        break;
    default:
        break;
}

