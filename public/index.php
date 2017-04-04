<?php

require_once '../vendor/autoload.php';
require_once '../app/NL/bootstrap/bootstrap.php';

use app\NL\Models\Company\Company;
use app\NL\Models\Project\Project;
use MongoDB\Driver\BulkWrite;

//***************************** CRUD START ****************************
//GET ALL Employees
$klein->respond('GET', '/', function () use ($employeeService, $smarty) {
    $smarty->assign('employeeArray', $employeeService->getAllEmployees());
    return $smarty->display('templates/index.tpl');
});

//GET ONE Employee
$klein->respond('GET', '/[:id]', function ($request) use ($employeeService, $smarty) {
    $employee = $employeeService->getOneEmployee($request->id);
    $smarty->assign('employeeId', $request->id);
    $smarty->assign('employee', $employee);
    return $smarty->display('templates/employeeById.tpl');
});

//CREATE Employee
$klein->respond('POST', '/employee/create', function () use ($employeeService, $smarty) {
    $employeeService->createEmployee();
    return $smarty->display('templates/createdEmployee.tpl');
});

//UPDATE Employee
$klein->respond('POST', '/employee/update', function () use ($employeeService, $smarty) {
    $employeeService->updateEmployee();
    return $smarty->display('templates/updatedEmployee.tpl');
});

//DELETE Employee
$klein->respond('DELETE', '/[:id]', function ($request) use ($employeeService, $smarty) {
    $employeeService->deleteEmployee($request->id);
});
//***************************** CRUD END ******************************

//****************************** ROUTES *******************************
//page with form for create new Employee
$klein->respond('GET', '/employee/create', function () use ($smarty) {
    return $smarty->display('templates/createEmployee.tpl');
});

//page with form for update excisting Employee
$klein->respond('GET', '/employee/update', function () use ($smarty) {
    return $smarty->display('templates/updateEmployee.tpl');
});

$klein->respond('GET', '/about', function () use ($smarty) {
    $company = new Company('DevTech', array('Mihajla Pupina 12', 'Janka Cmelika 7'), 'Information Technology');

    $smarty->assign('companyDetails', $company->getCompanyDetails());

    return $smarty->display('templates/about.tpl');
});

$klein->respond('GET', '/project', function () use ($smarty) {
    $project = new Project('AppRiver', 'In Progress', 'Google', 'Street 01', 'IT');

    $smarty->assign('projectDetails', $project->getProject());

    return $smarty->display('templates/project.tpl');
});

//TEMPORARY TEST Mongo Connection
$klein->respond('POST', '/mongodb', function () use ($database) {
    $bulk = new BulkWrite();
    $document1 = ['id' => '123123', 'first_name' => 'Nebojsa', 'last_name' => 'Lalic', 'job' => 'developer'];
    $bulk->insert($document1);
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $database->getDatabase()->execute('test.guest', $bulk, $writeConcern);
});

//URL Exception
$klein->onHttpError(function () use ($smarty) {
    $current_uri = $_SERVER['REQUEST_URI'];

    $errorMessage = "Oooups...your URL: \"" . $current_uri . "\" does not exist!";

    $smarty->assign('errorMessage', $errorMessage);

    return $smarty->display('templates/404.tpl');
});

$klein->dispatch();
