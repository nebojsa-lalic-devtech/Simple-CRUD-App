<?php

namespace app\NL\database;

class Config
{
    /**
     * Choose Database
     * 'mongodb' for MongoDB Database
     * 'mysql' for MySQL Database
     */
    const CURRENT_DB = 'mysql';
    
    const DB_HOST_MYSQL = 'localhost';
    const DB_NAME_MYSQL = 'guest';
    const DB_USER_MYSQL = 'root';
    const DB_PASS_MYSQL = 'root';

    const DB_HOST_MONGO = 'localhost';
    const DB_NAME_MONGO = 'guest';
    const DB_USER_MONGO = 'root';
    const DB_PASS_MONGO = 'root';
}