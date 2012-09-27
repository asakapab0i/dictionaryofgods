<?php

$host = "localhost";
$loginame = "root";
$logpassword = "";
$db_name = "dictionary";


mysql_connect("$host", "$loginame", "$logpassword") or die("cannot connect");
mysql_select_db("$db_name") or die("cannot select DB");
?>


<?php

/**
 * @desc Database connection set up, Object Oriented Style! 
 * @author Bryan Bojorque
 * 
 */
class Database {

    public $host = "localhost";
    public $username = "root";
    public $password = "";
    public $database = "InventorySystem";

    public function __construct() {
        /**
         * @desc Grouping together the inner functions. 
         */
        $this->MysqlCheckConnection();
        $this->MysqCheckSelection();
    }

    public function MysqlCheckConnection() {

        /**
         * @desc Check if the mysql_connect is succesful or not. 
         */
        if (!mysql_connect($this->host, $this->username, $this->password)) {
            die("Cannot connect to Database, please fix Connection/ folder.");
        } else {
            return true;
        }
    }

    public function MysqCheckSelection() {

        /**
         * @desc Check if there is a database to select. 
         */
        if (!mysql_select_db($this->database)) {
            die("Cannot select a Database, Database $this->database does not exist please fix Connection/ folder.");
        } else {
            return true;
        }
    }

    public function MysqlClose() {

        mysql_close();
    }

}

/**
 * @desc Instantiating the Database object. 
 */
$connect = new Database();
?>
