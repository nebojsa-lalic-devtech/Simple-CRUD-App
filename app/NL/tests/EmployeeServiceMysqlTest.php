<?php

namespace app\NL\tests;

use app\NL\database\Database;
use app\NL\database\MongoAdapter;
use app\NL\database\MysqlAdapter;
use app\NL\Models\Employee\EmployeeServiceMysql;
use app\NL\validation\ValidationMongodb;
use app\NL\validation\ValidationMysql;
use DI\Container;
use DI\ContainerBuilder;
use Klein\Klein;
use MongoDB\Driver\BulkWrite;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Mockery as m;

define('CURRENT_DB', 'mysql');

define('DB_HOST', 'localhost');
define('DB_NAME', 'simple-crud-app');
define('DB_USER', 'root');
define('DB_PASS', 'root');

class EmployeeServiceMysqlTest extends TestCase
{
    public function testGetsOneEmployeeFromDatabase()
    {
        $returnEmployeeFromDb = array(
            'id' => 1,
            'first_name' => 'Nebojsa',
            'last_name' => 'Lalic',
            'email' => 'lalicnebojsa@gmail.com',
            'job' => 'developer'
        );
        $mockedContainer = m::mock('ContainerBuilder');
        $validationMysql = m::mock('ValidationMysql');
        $logger = m::mock('Logger');
        $mockedContainer->shouldReceive('get')->times(2)->andReturn($validationMysql, $logger);
        $validationMysql->shouldReceive('validateId')->once()->with(1)->andReturn($returnEmployeeFromDb);
        $logger->shouldReceive('info')->once()->andReturn('** NEW EMPLOYEE successfully created MySQL database **');
        $expectedReturnEmployee = array(
            'id' => 1,
            'first_name' => 'Nebojsa',
            'last_name' => 'Lalic',
            'email' => 'lalicnebojsa@gmail.com',
            'job' => 'developer'
        );
        $employeeService = new EmployeeServiceMysql($mockedContainer);

        $this->assertEquals($expectedReturnEmployee, $employeeService->getOneEmployee(1));
    }
}