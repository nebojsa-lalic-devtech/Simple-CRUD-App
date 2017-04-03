<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\WriteConcern;

class EmployeeServiceMongodb implements IEmployeeService
{
    private $bulk;
    private $db;

    /**
     * EmployeeServiceMongodb constructor.
     */
    public function __construct()
    {
        $this->bulk = new BulkWrite();
        $this->db = new Database();
    }

    public function getAllEmployees()
    {
        // TODO: Implement getAllEmployees() method.
    }

    public function deleteEmployee($id)
    {
        // TODO: Implement deleteEmployee() method.
    }

    public function getOneEmployee($id)
    {
        // TODO: Implement getOneEmployee() method.
    }

    /**
     * @throws \Exception
     */
    public function createEmployee()
    {
        try {
            if (isset($_POST['Submit']) && $_POST['first_name'] != '' && $_POST['last_name'] != '') {
                $query = [
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'] ? $_POST['email'] : null,
                    'job' => $_POST['job'] ? $_POST['job'] : null
                ];
                $this->bulk->insert($query);
                $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
                $this->db->getDatabase()->execute('test.guest', $this->bulk, $writeConcern);

                echo 'NEW EMPLOYEE CREATED SUCCESSFULLY!';
            } else {
                echo '***** FIELDS "FIRST NAME" & "LAST NAME" MUST BE FILLED *****';
            }
        } catch (\MongoException $ex) {
            echo '***** CAN\'T CREATE EMPLOYEE! *****' . $ex->getMessage();
        }
    }

    public function updateEmployee()
    {
        // TODO: Implement updateEmployee() method.
    }

}