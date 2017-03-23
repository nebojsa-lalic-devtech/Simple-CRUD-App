<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;
use app\NL\validation\Validation;

class EmployeeService extends Database implements IEmployeeService
{
    private $validation;
    private $db;

    /**
     * EmployeeService constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
        if ($this->getCurrentDb() == 'mysql') {
            $statement = $this->db->getDatabaseConnection()->prepare("SELECT * FROM `simple-crud-app`.employee");
            $statement->execute();

            if ($statement == false) {
                throw new \Exception("Can't get table content!");
            }

            while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
        }

        if ($this->getCurrentDb() == 'mongodb') {
            echo 'mongodb get all';
        }
        return $rows;
    }

    public function deleteEmployee($id)
    {
        $this->validation->validateId($id);
        try {
            $statement = $this->db->getDatabaseConnection()->prepare("DELETE FROM employee WHERE id = :id");
            $statement->execute(array(
                'id' => $id
            ));
            echo 'Item with id: ' . $id . ' successfully deleted from database!';
        } catch (\PDOException $ex) {
            echo 'Can\'t delete Employee with id: ' . $id . $ex->getMessage();
        }
    }

    public function getOneEmployee($id)
    {
        $this->validation->validateId($id);
        try {
            $statement = $this->db->getDatabaseConnection()->prepare("SELECT * FROM employee WHERE id=:id LIMIT 1");
            $statement->execute(array(
                'id' => $id
            ));
            $oneEmployee = $statement->fetch(\PDO::FETCH_ASSOC);

            return $oneEmployee;
        } catch (\PDOException $ex) {
            echo 'Can\'t get Employee with id: ' . $id . $ex->getMessage();
        }
    }

    public function createEmployee()
    {
        try {
            if (isset($_POST['Submit'])) {
                $connection = $this->db->getDatabaseConnection();
                $statement = $connection->prepare("INSERT INTO `simple-crud-app`.`employee` (`id`, `first_name`, `last_name`, `email`, `job`) VALUES (:id, :first_name, :last_name, :email, :job)");
                $id = $connection->lastInsertId();
                $statement->execute(array(
                    'id' => $_POST['id'] ? $_POST['id'] : $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));

                echo 'New Employee created successfully!';
            }
        } catch (\PDOException $ex) {
            echo 'Can\'t create Employee! ' . $ex->getMessage();
        }
    }

    public function updateEmployee()
    {
        $id = $_POST['id'];
        $this->validation->validateId($id);
        try {
            if (isset($_POST['Update'])) {
                $statement = $this->db->getDatabaseConnection()->prepare("UPDATE `simple-crud-app`.`employee` SET `first_name`=:first_name, `last_name`=:last_name, `email`=:email, `job`=:job WHERE `id`=:id");
                $statement->execute(array(
                    'id' => $id,
                    'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                    'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                    'email' => $_POST['email'],
                    'job' => $_POST['job']
                ));

                echo 'Employee with id: ' . $_POST['id'] . ' updated successfully!';
            }
        } catch (\PDOException $ex) {
            echo 'Can\'t update Employee with id: ' . $_POST['id'] . $ex->getMessage();
        }
    }
}