<?php 
class Config 
{
    public $config = array(
        'servername'=> 'localhost',
        'username'=> 'root', 
        'password'=> '', 
        'dbname'=> 'lab2'
    );

    public $conn;
    function __construct()
    {
        // Create connection
        $this->conn = new mysqli($this->config['servername'], $this->config['username'], $this->config['password'], $this->config['dbname']);

        // Check connection
        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
?>