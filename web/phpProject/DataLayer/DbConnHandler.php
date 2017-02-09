<?php
namespace phpProject\DataLayer;

use \PDO;

class DbConnHandler
{
	public $connStr;
	public $dbConn;
	
	// Open database connection
	public function Open()
	{
		if (empty($this->dbConn) || $this->dbConn == null)
		{
			// Database connection string from ENV variable
			$this->connStr = getenv("DATABASE_URL");
			// If there is no database connection string from the "getenv" method then I am running on my local development machine
			if (empty($this->connStr))
			{
				$this->connStr = "postgres://cs313:P@ssword123@localhost:5432/MLMLinkupData";
			}

			$url = parse_url($this->connStr);
			$dbopts = $url;

			try
			{
				// Create the PDO connection
				$this->dbConn = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
			}
			catch (PDOException $ex)
			{
				// If this were in production, you would not want to echo
				// the details of the exception.
				echo "Error connecting to DB. Details: $ex";
				die();
			}

			$this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	// Close the Database Connection
	public function Close()
	{
		//http://stackoverflow.com/questions/18277233/pdo-closing-connection
		$this->dbConn = null;
	}

	// Explicit setting of $dbConn to null to ensure DB connection closes
	function __destruct()
	{
		//http://stackoverflow.com/questions/18277233/pdo-closing-connection
		$this->dbConn = null;
	}
}
