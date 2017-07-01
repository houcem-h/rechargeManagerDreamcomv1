<?php
    class Database{
        private $host = "localhost";//"dreamcomsadba.mysql.db";
        private $dbname = "dreamcomsadba";
        private $username = "root";// "dreamcomsadba";
        private $password = "";// "XdR2016Ho";
        public $conn;

        public function cnxBD(){
            $this->conn =null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
            catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>
