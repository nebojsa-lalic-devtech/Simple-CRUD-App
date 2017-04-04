<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use app\NL\validation\Validation;

class EmployeeService implements IEmployeeService
{
    private $validation;
    private $db;

    /**
     * EmployeeService constructor.
     */
    public function __construct()
    {
        $this->validation = new Validation();
        $this->db = new Database();
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

        if (!$statement->rowCount() > 0) {
            throw new \Exception("***** CAN'T GET TABLE CONTENT! EMPTY TABLE! *****");
        }

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function deleteEmployee($id)
    {
        //$this->validation->validateId($id);
        try {
            $statement = $this->db->getDatabase()->createConnection()->prepare("DELETE FROM employee WHERE id = :id");
            $statement->execute(array(
                'id' => $id
            ));
            echo 'ITEM WITH ID: ' . $id . ' SUCCESSFULLY DELETED FROM DATABASE!';
        } catch (\PDOException $ex) {
            echo '***** CAN\'T DELETE EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
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
            $statement = $this->db->getDatabase()->createConnection()->prepare("SELECT * FROM employee WHERE id=:id LIMIT 1");
            $statement->execute(array(
                'id' => $id
            ));
            $oneEmployee = $statement->fetch(\PDO::FETCH_ASSOC);

            return $oneEmployee;
        } catch (\PDOException $ex) {
            echo '***** CAN\'T GET EMPLOYEE WITH ID: ' . $id . ' *****' . $ex->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    public function createEmployee()
    {
        try {
            if (isset($_POST['Submit']) && $_POST['first_name'] != '' && $_POST['last_name'] != '') {
                $connection = $this->db->getDatabase()->createConnection();
                $statement = $connection->prepare("INSERT INTO `simple-crud-app`.`employee` (`id`, `first_name`, `last_name`, `email`, `job`) VALUES (:id, :first_name, :last_name, :email, :job)");
                $id = $connection->lastInsertId();
                $statement->execute(array(
                    'id' => $_POST['id'] ? $_POST['id'] : $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));

                echo 'NEW EMPLOYEE CREATED SUCCESSFULLY!';
            } else {
                echo '***** FIELDS "FIRST NAME" & "LAST NAME" MUST BE FILLED *****';
            }
        } catch (\PDOException $ex) {
            echo '***** CAN\'T CREATE EMPLOYEE! *****' . $ex->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    public function updateEmployee()
    {
        $id = $_POST['id'];
        //$this->validation->validateId($id);
        try {
            if (isset($_POST['Update']) && $_POST['first_name'] != '' && $_POST['last_name'] != '') {
                $statement = $this->db->getDatabase()->createConnection()->prepare("UPDATE `simple-crud-app`.`employee` SET `first_name`=:first_name, `last_name`=:last_name, `email`=:email, `job`=:job WHERE `id`=:id");
                $statement->execute(array(
                    'id' => $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));

                echo 'EMPLOYEE WITH ID: ' . $_POST['id'] . ' UPDATED SUCCESSFULLY!';
            } else {
                echo '***** FIELDS "FIRST NAME" & "LAST NAME" MUST BE FILLED *****';
            }
        } catch (\PDOException $ex) {
            echo '***** CAN\'T UPDATE EMPLOYEE WITH ID: ' . $_POST['id'] . ' *****' . $ex->getMessage();
        }
    }
}