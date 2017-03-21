<?php

namespace app\NL\Models\Employee;

use app\NL\database\Database;

class EmployeeService extends Database implements IEmployeeService
{
    public function getAllEmployees()
    {
        $query = "SELECT * FROM `simple-crud-app`.employee";
        $results = $this->getDatabaseConnection()->query($query);

        if ($results == false) {
            throw new \Exception("Can't get table content!");
        }

        $rows = array();

        while ($row = $results->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }
}