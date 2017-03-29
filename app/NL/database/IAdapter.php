<?php

namespace app\NL\database;

interface IAdapter
{
    public function createConnection();
}