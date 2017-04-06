<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use app\NL\validation\ValidationMysql;
use Monolog\Logger;

class EmployeeServiceMysql implements IEmployeeService
{
    private $validation;
    private $db;
    private $logger;

    /**
     * EmployeeServiceMysql constructor.
     * @param ValidationMysql $val
     * @param Database $db
     * @param Logger $log
     */
    public function __construct(ValidationMysql $val, Database $db, Logger $log)
    {
        $this->validation = $val;
        $this->db = $db;
        $this->logger = $log;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllEmployees()
    {
        $rows = array();
        $statement = $this->db->getDatabase()->createConnection()->prepare("SELECT * FROM `simple-crud-app`.employee");
        $statement->execute();

        if (!($statement->rowCount() > 0)) {
            $this->logger->error("***** CAN'T GET TABLE CONTENT! EMPTY TABLE! *****");
            throw new \Exception("***** CAN'T GET TABLE CONTENT! EMPTY TABLE! *****");
        }

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        $this->logger->info('** Get list of ALL EMPLOYEES from MySQL database **');
        return $rows;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function deleteEmployee($id)
    {
        $this->validation->validateId($id);
        try {
            $statement = $this->db->getDatabase()->createConnection()->prepare("DELETE FROM employee WHERE id = :id");
            $statement->execute(array(
                'id' => $id
            ));
            echo 'ITEM WITH ID: ' . $id . ' SUCCESSFULLY DELETED FROM DATABASE!';
            $this->logger->info("** EMPLOYEE with id:{$id} successfully DELETED from Mongo DB database**");
        } catch (\PDOException $ex) {
            echo '***** CAN\'T DELETE EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
            $this->logger->error("***** CAN'T DELETE EMPLOYEE WITH ID:{$id} *****");
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getOneEmployee($id)
    {
        $this->validation->validateId($id);
        try {
            $statement = $this->db->getDatabase()->createConnection()->prepare("SELECT * FROM employee WHERE id = :id LIMIT 1");
            $statement->execute(array(
                'id' => $id
            ));
            $oneEmployee = $statement->fetch(\PDO::FETCH_ASSOC);
            $this->logger->info("** Get one EMPLOYEE from MongoDB database with id:{$id} **");
            return $oneEmployee;
        } catch (\PDOException $ex) {
            echo '***** CAN\'T GET EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
            $this->logger->error("***** CAN'T GET EMPLOYEE WITH ID:{$id} *****");
        }
    }

    /**
     * @throws \Exception
     */
    public function createEmployee()
    {
        try {
            if (isset($_POST['Submit']) && $_POST['first_name'] != '' && $_POST['last_name'] != '') {
                $statement = $this->db->getDatabase()->createConnection()->prepare("INSERT INTO `simple-crud-app`.`employee` (`id`, `first_name`, `last_name`, `email`, `job`) VALUES (:id, :first_name, :last_name, :email, :job)");
                $id = $this->db->getDatabase()->createConnection()->lastInsertId();
                $statement->execute(array(
                    'id' => $_POST['id'] ? $_POST['id'] : $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));
                echo 'NEW EMPLOYEE CREATED SUCCESSFULLY!';
                $this->logger->info('** NEW EMPLOYEE successfully created MySQL database **');
            } else {
                echo '***** FIELDS "FIRST NAME" & "LAST NAME" MUST BE FILLED *****';
            }
        } catch (\PDOException $ex) {
            echo '***** CAN\'T CREATE EMPLOYEE! *****' . $ex->getMessage();
            $this->logger->error("***** CAN'T CREATE EMPLOYEE! *****");
        }
    }

    /**
     * @throws \Exception
     */
    public function updateEmployee()
    {
        $id = $_POST['id'];
        $this->validation->validateId($id);
        try {
            if (isset($_POST['Update'])) {
                $statement = $this->db->getDatabase()->createConnection()->prepare("UPDATE `simple-crud-app`.`employee` SET `first_name`=:first_name, `last_name`=:last_name, `email`=:email, `job`=:job WHERE `id`=:id");
                $statement->execute(array(
                    'id' => $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));
                echo 'EMPLOYEE WITH ID: ' . $id . ' UPDATED SUCCESSFULLY!';
                $this->logger->info("** EMPLOYEE WITH ID:{$id} UPDATED SUCCESSFULLY **");
            }
        } catch (\PDOException $ex) {
            echo '***** CAN\'T UPDATE EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
            $this->logger->error("***** CAN'T UPDATE EMPLOYEE WITH OBJECT ID: {$id} *****");
        }
    }
}