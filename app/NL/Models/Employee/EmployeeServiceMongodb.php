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
    private $connection;
    private $validation;

    /**
     * EmployeeServiceMongodb constructor.
     */
    public function __construct()
    {
        $this->bulk = new BulkWrite();
        $db = new Database();
        $this->connection = $db->getDatabase()->createConnection();
        $this->validation = new ValidationMongodb();
    }

    public function getAllEmployees()
    {
        // TODO: Implement getAllEmployees() method.
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
                self::execute();

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

    /**
     *ExecuteBulkWrite command $ WriteConcern initialisation
     */
    private function execute()
    {
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $this->connection->executeBulkWrite(CURRENT_MONGO_TABLE, $this->bulk, $writeConcern);
    }
}