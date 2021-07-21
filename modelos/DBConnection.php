<?php 

class DBConnection
{    
	private static $_connections = array();
	private static $logger;
	
	function __construct($log)
	{
		self::$logger = $log;
		
	}
    private static function createConnection($type)
    {
        switch($type){
            case 'dsd':
            	try {
					
				$dsn = "mysql:host=localhost;dbname=sinttecomv3;charset=utf8";
				$db_user = 'root';
				$db_pass='';
				$dbh = new PDO($dsn,  $db_user, $db_pass);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				return $dbh;
				//return new PDO("mysql:host=localhost;dbname=dsdv3;charset=utf8", $db_user, $db_pass);
				
            	} catch (PDOException $e) {
            		self::$logger->error ("File: DBConnection.php;	Method Name: createConnection()	Functionality: Create DB Connection objects;	Log:" . $e->getMessage () );
            	}
            	break;
			case 'sinttecom':
            	try {
					
				$dsn = "mysql:host=localhost;dbname=sinttecomv3;charset=utf8";
				$db_user = 'root';
				$db_pass='';
				$dbh = new PDO($dsn,  $db_user, $db_pass);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				return $dbh;
				//return new PDO("mysql:host=localhost;dbname=dsdv3;charset=utf8", $db_user, $db_pass);
				
            	} catch (PDOException $e) {
            		self::$logger->error ("File: DBConnection.php;	Method Name: createConnection()	Functionality: Create DB Connection objects;	Log:" . $e->getMessage () );
            	}
            	break;
            default:
                //return new PDO('mysql:dbname=berrysoft;host=127.0.0.1', 'root', 'root');
        }
    }

    public function getConnection($type)
    {
    	 if(!isset(self::$_connections[$type])){
        	        	
            self::$_connections[$type] = self::createConnection($type);
           	if(isset(self::$_connections[$type]))
            {
            	//$loggedUserName = $_SESSION['user'];
            	//self::$logger->connection("$type database connection estalished for the user : $loggedUserName");
            }
           	
        }
        return self::$_connections[$type];
    }
}
/*
 * The below single instance would be shared across the screens where the DB instance is in need.
 */
include(dirname(dirname(__FILE__)).'/log/log.php');
$db = new DBConnection($log);
?>
