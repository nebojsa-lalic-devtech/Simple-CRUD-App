<?php

namespace app\NL\Models\Employee;

interface IEmployeeService
{
    public function getAllEmployees();
    public function deleteEmployee($id, $table);
}