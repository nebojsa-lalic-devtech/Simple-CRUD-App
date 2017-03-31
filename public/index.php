<?php
require_once '../app/NL/bootstrap/bootstrap.php';
require_once '../vendor/autoload.php';

use Klein\Klein;
use app\NL\Models\Employee\Employee;
use app\NL\Models\Company\Company;
use app\NL\Models\Project\Project;
use app\NL\database\Database;
use MongoDB\Driver\BulkWrite;

$klein = new Klein();

$smarty = new Smarty();

$database = new Database();

$klein->respond('GET', '/', function () use ($smarty) {
    $user = new Employee('Nebojsa', 'Lalic', 'nebojsa.lalic@devtechgroup.com', 'Software developer');
    $user2 = new Employee('Petar', 'Petrovic', 'petarpetrovic@gmail.com', 'QA');
    $user3 = new Employee('X', 'Man', 'xman@yahoo.com', 'Project manager');

    $smarty->assign('userDetails', $user->getUserDetails());
    $smarty->assign('user2Details', $user2->getUserDetails());
    $smarty->assign('user3Details', $user3->getUserDetails());

    return $smarty->display('templates/index.tpl');
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

$klein->onHttpError(function () use ($smarty) {
    $current_uri = $_SERVER['REQUEST_URI'];

    $errorMessage = "Oooups...your URL: \"" . $current_uri . "\" does not exist!";

    $smarty->assign('errorMessage', $errorMessage);

    return $smarty->display('templates/404.tpl');
});

//TEMPORARY TEST MySQL Connection
$klein->respond('POST', '/mysql', function () use ($database) {
    $queryString = "INSERT INTO employee (first_name, last_name, email, job) VALUES (\"8998 First Name\", \"Test Last Name\", \"ln@gmail.com\", \"developer\")";
    $database->connectToDatabase()->execute($queryString);
});


//TEMPORARY TEST Mongo Connection
$klein->respond('POST', '/mongodb', function () use ($database) {
    $bulk = new BulkWrite();
    $document1 = ['id' => '123123', 'first_name' => 'Nebojsa', 'last_name' => 'Lalic', 'job' => 'developer'];
    $bulk->insert($document1);
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $database->connectToDatabase()->execute('test.guest', $bulk, $writeConcern);

    var_dump($document1);
});

$klein->dispatch();
