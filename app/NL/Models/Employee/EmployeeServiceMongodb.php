<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use app\NL\validation\ValidationMongodb;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
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

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllEmployees()
    {
        $query = new Query([]);
        $allEmployees = $this->db->getDatabase()->createConnection()->executeQuery(CURRENT_MONGO_TABLE, $query);
        $employeesArray = array();
        foreach ($allEmployees as $employee) {
            $employeesArray[] = $employee;
        }

        if (!(sizeof($employeesArray) > 0)) {
            throw new \Exception("***** CAN'T GET TABLE CONTENT! EMPTY TABLE! *****");
        }

        return $employeesArray;
    }

    /**
     * @param $id
     */
    public function deleteEmployee($id)
    {
        $this->validation->validateId($id);
        try {
            $this->bulk->delete(["_id" => new ObjectID($id)], ['limit' => 1]);
            self::execute();
            echo 'ITEM WITH OBJECT ID: ' . $id . ' SUCCESSFULLY DELETED FROM DATABASE!';
        } catch (\MongoException $ex) {
            echo '***** CAN\'T DELETE EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function getOneEmployee($id)
    {
        $employee = $this->validation->validateId($id);
        var_dump($employee[]->first_name);
        return $employee;
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
                self::execute();
                echo 'NEW EMPLOYEE CREATED SUCCESSFULLY!';
            } else {
                echo '***** FIELDS "FIRST NAME" & "LAST NAME" MUST BE FILLED *****';
            }
        } catch (\MongoException $ex) {
            echo '***** CAN\'T CREATE EMPLOYEE! *****' . $ex->getMessage();
        }
    }


    /**
     * @throws \Exception
     */
    public function updateEmployee()
    {
        $id = $_POST['id'];
        $employeeFromDb = $this->validation->validateId($id);
        $oldEmployee = (array)$employeeFromDb[0];
        try {
            if (isset($_POST['Update'])) {
                $newEmployee = [
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : $employeeToArray['first_name'],
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : $employeeToArray['last_name'],
                    'email' => $_POST['email'] ? $_POST['email'] : $employeeToArray['email'],
                    'job' => $_POST['job'] ? $_POST['job'] : $employeeToArray['job']
                ];
                $this->bulk->update($oldEmployee, $newEmployee);
                self::execute();
                echo 'EMPLOYEE WITH ID: ' . $id . ' UPDATED SUCCESSFULLY!';
            }
        } catch (\MongoException $ex) {
            echo '***** CAN\'T UPDATE EMPLOYEE WITH OBJECT ID: ' . $id . ' *****' . $ex->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    private function execute()
    {
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $this->db->getDatabase()->createConnection()->executeBulkWrite(CURRENT_MONGO_TABLE, $this->bulk, $writeConcern);
    }
}