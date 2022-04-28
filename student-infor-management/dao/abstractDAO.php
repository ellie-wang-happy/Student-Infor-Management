<?php
//Used to throw mysqli_sql_exceptions for database
//errors instead or printing them to the screen.
mysqli_report(MYSQLI_REPORT_STRICT);
/**
 * Abstract data access class. Holds all of the database
 * connection information, and initializes a mysqli object
 * on instantiation.
 */
class abstractDAO {
    protected $mysqli;
    
    // Host address for the database
    protected static $DB_HOST = "localhost:3306";// or 127.0.0.1

	
	// For this example, if you only have one instance of mysql you may discard the port
	// we usually get the port and host from environmental variable as best practice 
	// Never leave IPs or ports in code - this is ommitted here for simplicity
	// I have 2 instance of mySQL installed that's why I have to use port number
	
	
	/* Port number on the host */
    protected static $DB_PORT = 3306;// your port can be different than mine
    /* Database username */
    protected static $DB_USERNAME = "root";
    /* Database password */
    protected static $DB_PASSWORD = "K4C87Zk8HXtb";
    /* Name of database */
    protected static $DB_DATABASE = "assign2";
    
    /*
     * Constructor. Instantiates a new MySQLi object.
     * Throws an exception if there is an issue connecting
     * to the database.
     */
    function __construct() {
        try{
          // $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
           // self::$DB_PASSWORD, self::$DB_DATABASE, self::$DB_PORT);
           $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
            self::$DB_PASSWORD, self::$DB_DATABASE);
        }      
        catch(mysqli_sql_exception $e){
            throw $e;
        }
    }
    
    public function getMysqli(){
        return $this->mysqli;
        
    }
    
}

?>
