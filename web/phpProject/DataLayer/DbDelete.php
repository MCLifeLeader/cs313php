<?php 
namespace phpProject\DataLayer;

require_once 'DbBase.php';

use phpProject\DataLayer\DbBase;
use \PDO;

class DbDelete extends DbBase
{
    function __construct() 
    {
        parent::__construct();        
    }
}
