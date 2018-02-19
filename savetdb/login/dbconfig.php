<?php
class Database
{
     
    private $host = "db17.cpanelhosting.rs";
    private $db_name = "uprava_sbsns";
    private $username = "uprava_savet";
    private $password = "saobracaj3975";
    public $conn;

    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>