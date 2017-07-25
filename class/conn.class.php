<?php
class Conn{
    public $dbhost;
    public $dbuser;
    public $dbpwd;
    public $dbname;
    public $dsn;
    public $conn;
    private $str = PDO::PARAM_STR;
    private $int = PDO::PARAM_INT;

    public function __construct(){ }

    public function connect(){
        $this->dbhost = 'localhost';
        $this->dbuser = 'fonti';
        $this->dbpwd = 'f0Nt1aDmIn';
        $this->dbname = 'fonti';
        $this->dsn = "pgsql:host=".$this->dbhost." user=".$this->dbuser." password=".$this->dbpwd." dbname=".$this->dbname;
        $this->conn = new PDO($this->dsn);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function pdo(){
        if (!$this->conn){ $this->connect();}
        return $this->conn;
    }

    public function __destruct(){ if ($this->conn){ $this->conn = null; } }

}

?>
