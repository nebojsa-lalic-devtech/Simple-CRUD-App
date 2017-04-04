<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use app\NL\validation\ValidationMongodb;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\WriteConcern;

class EmployeeServiceMongodb implements IEmployeeService
{
    private $bulk;
    private $validation;
    private $db;

    /**
     * EmployeeServiceMongodb constructor.
     * @param BulkWrite $bulk
     * @param ValidationMongodb $val
     * @param Database $db
     */
    public function __construct(BulkWrite $bulk, ValidationMongodb $val, Database $db)
    {
        $this->bulk = $bulk;
        $this->validation = $val;
        $this->db = $db;
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
                $this->db->getDatabase()->createConnection()->executeBulkWrite(CURRENT_MONGO_TABLE, $this->bulk, $writeConcern);

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