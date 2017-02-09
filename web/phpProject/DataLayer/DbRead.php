<?php 
namespace phpProject\DataLayer;

require 'DbBase.php';

use phpProject\DataLayer\DbBase;

class DbRead extends DbBase
{
    function __construct() 
    {
        parent::__construct();        
    }

    function GetUser($userName)
    {
        $this->dbHandler->Open();

        $query = "SELECT \"Id\"
        , \"Email\"
        , \"EmailConfirmed\"
        , \"PasswordHash\"
        , \"SecurityStamp\"
        , \"PhoneNumber\"
        , \"PhoneNumberConfirmed\"
        , \"TwoFactorEnabled\"
        , \"LockoutEndDateUtc\"
        , \"LockoutEnabled\"
        , \"AccessFailedCount\"
        , \"UserName\"
        FROM \"AspNetUsers\" 
        WHERE \"UserName\" = '" . $userName . "';";

        $sql = $this->dbHandler->dbConn->prepare($query);
        $sql->execute();
        $results = $sql->fetchAll();

        $this->dbHandler->Close();

        return $results;
    }
}
