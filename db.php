<?php

 class Database {

    private $host = 'localhost';
    private $dbname = 'simple_blog';
    private $user = 'root';
    private $pass = '';

    public $db;

    public function __construct(){
      $this->db = $this->connect();   
    }

    protected function connect(){
        try{
            $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname; charset=utf8mb4", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        }catch(PDOException $e){
            die("Connection Failed To Database." . $e->getMessage());
        }
    }
 }