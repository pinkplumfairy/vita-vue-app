<?php
/**
 * Mysql.php
 *
 * Contains the Mysql database class
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

/**
 * Mysql
 *
 * Allows establishing a connection and communication with a mysql database
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/
class Mysql {
	/** Database host
   * @var string $host */
	private $host;
	/** Database name
   * @var string $database */
	private $database;
	/** Database login
   * @var string $username */
	private $username;
	/** Database password
   * @var string $password */
	private $password;
	/** The character encoding
   * @var string $charset */
	private $charset;
	/** Database handle
   * @var string $handle */
	private $handle;
	
	/** Constructor that sets required properties
	 * @param string $host - The database host
	 * @param string $database - The database name
	 * @param string $username - The login name
	 * @param string $password - The password
	 * @param string $charset - The encoding
	 * @param boolean $connect - Establish connection right away?
	 * @return void */
	function __construct(
		string $host = NULL
		,string $database = NULL
		,string $username = NULL
		,string $password = NULL
		,string $charset = 'utf8mb4'
		,bool $connect = TRUE
	) {
		$this->host = $host;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->charset = $charset;
		if ($connect === TRUE) {$this->connect();}
	}
	
	/** Establishes a connection to the database
	 * @return boolean */
	function connect() {
		try {
			$this->handle = new PDO("mysql:host=$this->host;dbname=$this->database;charset=$this->charset", $this->username, $this->password);
		} catch (PDOException $e) {
			throw new Error(__FUNCTION__ . " error: " . $e->getMessage(), $e->getCode());
		}
		return TRUE;
	}

	/** Closes the db connection
	 * @return void */
	function disconnect() {
		$this->handle = NULL;
	}
	
	/** Executes a query and returns a 2D array
	 * @param string $query
	 * @param string[] $params
	 * @return array[] */
	function get(string $query, array $params = array()) {
		try{
   	 		$stmt = $this->handle->prepare($query);
			$stmt->execute($params);	 
   	 	} 
    	catch(PDOException $e){
				throw new Error(__FUNCTION__ . " error: " . $e->getMessage() . " in query \"" . $query . "\" using parameters: " . var_dump_r($params), $e->getCode());
    	} 
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/** Executes a query and returns the affected rows
	 * @param string $query
	 * @param string[] $params
	 * @return integer */
	function set(string $query, array $params = array()) {
		try {
			$stmt = $this->handle->prepare($query);
			$result = $stmt->execute($params);
		} catch (PDOException $e) {
			throw new Error(__FUNCTION__ . " error: " . $e->getMessage() . " in query \"" . $query . "\" using parameters: " . var_dump_r($params), $e->getCode());
		}
		if ($result) {
			return $stmt->rowCount();			
		} else {
			return 0;
		}
	}

	/** Executes a query and returns a string
	 * @param string $query
	 * @param string[] $params
	 * @return string */
	function getString(string $query, array $params = array()) {
		$data = $this->get($query, $params);
		if (empty($data)) {return FALSE;}
		return reset($data[0]);
	}

	/** Executes a query and returns the first row
	 * @param string $query
	 * @param string[] $params
	 * @return string[] */
	function getRow(string $query, array $params = array()) {
		$data = $this->get($query, $params);
		return $data[0];
	}

	/** Executes a query and returns the first column
	 * @param string $query
	 * @param string[] $params
	 * @return string[] */
	function getColumn(string $query, array $params = array()) {
		$data = $this->get($query, $params);
		$result = array();
		foreach($data as $key => $row) {
			$result[] = reset($row);
		}
		return $result;
	}

	/** Returns the last inserted Id
	 * @return integer */
	function getLastId() {
		return $this->handle->lastInsertId();
	}

	/** Begins a transaction
	 * @return boolean */
	function beginTransaction() {
		return $this->handle->beginTransaction();
	}

	/** Commits a transaction
	 * @return boolean */
	function commitTransaction() {
		return $this->handle->commit();
	}

	/** Rolls back a transaction
	 * @return boolean */
	function rollbackTransaction() {
		return $this->handle->rollBack();
	}
	
}


