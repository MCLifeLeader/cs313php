<?php 
namespace phpProject\DataLayer;	

require_once 'DbConnHandler.php';

use phpProject\DataLayer\DbConnHandler;

class DbBase 
{
    protected $dbHandler = null;
    
    function __construct() 
    {
        $this->dbHandler = new DbConnHandler();
    }

    // Explicit setting of $dbHandler to null to ensure DB connection closes
    function __destruct()
    {
        $this->dbHandler = null;
    }
}
