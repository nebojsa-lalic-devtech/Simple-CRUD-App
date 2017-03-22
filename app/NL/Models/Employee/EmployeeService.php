<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;

class EmployeeService extends Database implements IEmployeeService
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getAllEmployees()
    {
        $rows = array();
        if ($this->getCurrentDb() == 'mysql') {
            $statement = $this->getDatabaseConnection()->prepare("SELECT * FROM `simple-crud-app`.employee");
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
        $statement = $this->getDatabaseConnection()->prepare("DELETE FROM employee WHERE id = :id");
        $statement->execute(array(
            'id' => $id
        ));

        if ($statement == false) {
            echo 'Error: cannot delete item with id ' . $id;
            return false;
        } else {
            echo 'Item with id: ' . $id . ' successfully deleted from database!';
            return true;
        }
    }

    public function getOneEmployee($id)
    {
        $statement = $this->getDatabaseConnection()->prepare("SELECT * FROM employee WHERE id=:id LIMIT 1");
        $statement->execute(array(
            'id' => $id
        ));
        $oneEmployee = $statement->fetch(\PDO::FETCH_ASSOC);

        return $oneEmployee;
    }

    public function createEmployee()
    {
        if (isset($_POST['Submit'])) {
            $statement = $this->getDatabaseConnection()->prepare("INSERT INTO `simple-crud-app`.`employee` (`first_name`, `last_name`, `email`, `job`) VALUES (:first_name, :last_name, :email, :job)");
            $statement->execute(array(
                'first_name' => $_POST['first_name'] ? $_POST['first_name'] : null,
                'last_name' => $_POST['last_name'] ? $_POST['last_name'] : null,
                'email' => $_POST['email'],
                'job' => $_POST['job']
            ));
            
            echo 'New Employee created successfully!';
        }
    }

    public function updateEmployee($id)
    {
        // TODO: Implement updateEmployee() method.
    }
}