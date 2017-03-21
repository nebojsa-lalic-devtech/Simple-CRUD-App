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

    public function deleteEmployee($id, $table)
    {
        $query = "DELETE FROM $table WHERE id = $id";
        $result = $this->getDatabaseConnection()->query($query);

        if ($result == false) {
            echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
            return false;
        } else {
            echo 'Item with id: ' . $id . ' deleted from table: ' . $table . ' in database!';
            return true;
        }
    }


}