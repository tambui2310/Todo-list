<?php

class DB{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $databaseName = 'todo-list';
    private $charset = 'utf8';
    public $conn;
 
    public function __construct()
    {
        $this->connect();
    }
    /**
     * connect to database
     * @return void
     */
    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->databaseName);
        if ($this->conn->connect_error) {
            die("Connection to database failed: " . $this->conn->connect_error);
        }
    }

}

?>