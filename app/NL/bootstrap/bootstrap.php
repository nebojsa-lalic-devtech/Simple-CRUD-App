<?php

namespace app\NL\bootstrap;

use app\NL\database\MongoAdapter;
use app\NL\database\MysqlAdapter;
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
$mysqlAdapter = new MysqlAdapter();
$mongodbAdapter = new MongoAdapter();
$database = new Database($mysqlAdapter, $mongodbAdapter);
$validationMysql = new ValidationMysql($database);
$validationMongodb = new ValidationMongodb($database);
$employeeServiceMysql = new EmployeeServiceMysql($validationMysql, $database);
$bulk = new BulkWrite();
$employeeServiceMongodb = new EmployeeServiceMongodb($bulk, $validationMongodb, $database);

switch (CURRENT_DB) {
    case 'mysql':
        $employeeService = $employeeServiceMysql;
        $getAllEmployeesView = 'templates/indexMysql.tpl';
        $getOneEmployeeView = 'templates/employeeByIdMysql.tpl';
        $createEmployeeView = 'templates/createdEmployee.tpl';
        $updateEmployeeView = 'templates/updatedEmployee.tpl';
        break;
    case 'mongodb':
        $employeeService = $employeeServiceMongodb;
        $getAllEmployeesView = 'templates/indexMongodb.tpl';
        $getOneEmployeeView = 'templates/employeeByIdMongodb.tpl';
        $createEmployeeView = 'templates/createdEmployee.tpl';
        $updateEmployeeView = 'templates/updatedEmployee.tpl';
        break;
    default:
        break;
}
