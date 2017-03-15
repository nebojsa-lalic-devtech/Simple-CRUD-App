<?php

namespace app\NL\Models\Employee;

use app\NL\Models\Person\Person;

class Employee extends Person implements IEmployee
{
    private $email;
    private $job;

    /**
     * Employee constructor.
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $job
     */
    public function __construct($first_name, $last_name, $email, $job)
    {
        parent::__construct($first_name, $last_name);
        $this->email = $email;
        $this->job = $job;
    }

    /**
     * @return string
     */
    public function getUserDetails()
    {
        return '<b>Name:</b> ' . $this->getFirstName() . ' ' . $this->getLastName() . ',<br><b>Email:</b> ' . $this->email . ',<br><b>Job:</b> ' . $this->job;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param mixed $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }
}