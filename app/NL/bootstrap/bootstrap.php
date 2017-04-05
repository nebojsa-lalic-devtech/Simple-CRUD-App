<?php

namespace app\NL\bootstrap;

use app\NL\database\MysqlAdapter;
use app\NL\database\MongoAdapter;
use Klein\Klein;
use Smarty;
use app\NL\database\Database;
use app\NL\validation\Validation;
use app\NL\Models\Employee\EmployeeService;

require_once __DIR__ . '\..\database\config.php';

$klein = new Klein();
$smarty = new Smarty();
$mysqlAdapter = new MysqlAdapter();
$mongodbAdapter = new MongoAdapter();
$database = new Database($mysqlAdapter, $mongodbAdapter);
$validation = new Validation($database);
$employeeService = new EmployeeService($validation, $database);
