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
            $query = "SELECT * FROM `simple-crud-app`.employee";
            $results = $this->getDatabaseConnection()->query($query);

            if ($results == false) {
                throw new \Exception("Can't get table content!");
            }

            while ($row = $results->fetch(\PDO::FETCH_ASSOC)) {
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
        $query = "DELETE FROM employee WHERE id = $id";
        $result = $this->getDatabaseConnection()->query($query);

        if ($result == false) {
            echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
            return false;
        } else {
            echo 'Item with id: ' . $id . ' deleted from table: ' . $table . ' in database!';
            return true;
        }
    }

    public function getOneEmployee($id)
    {
        $query = "SELECT * FROM employee WHERE id=$id LIMIT 1";
        $result = $this->getDatabaseConnection()->query($query);
        $oneEmployee = $result->fetch(\PDO::FETCH_ASSOC);
        $dtoEmployee = new Employee($oneEmployee['first_name'], $oneEmployee['last_name'],$oneEmployee['email'],$oneEmployee['job']);
//        $dtoEmployee->setFirstName($oneEmployee['first_name']);
//        $dtoEmployee->setLastName($oneEmployee['last_name']);
//        $dtoEmployee->setEmail($oneEmployee['email']);
//        $dtoEmployee->setJob($oneEmployee['job']);
        var_dump($oneEmployee);
        return $dtoEmployee;
    }

}