<?php 
namespace phpProject\DataLayer;

require_once (dirname(__FILE__).'/../Models/AspNetUser.php');
require_once 'DbBase.php';

use phpProject\DataLayer\DbBase;
use phpProject\Models\AspNetUser;
use \PDO;

class DbRead extends DbBase
{
    function __construct() 
    {
        parent::__construct();        
    }

    function GetUser($userName)
    {
        $this->dbHandler->Open();

        $query = "SELECT 
            \"Id\"
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
        WHERE \"UserName\" = :UserName;";

        $sql = $this->dbHandler->dbConn->prepare($query);
        $sql->bindValue( ":UserName", $userName, PDO::PARAM_STR );

        // echo $sql->debugDumpParams();

        $sql->execute();
        $results = $sql->fetchAll();
        
        $aspNetUser = null;

        if(isset($results) && isset($results[0])) {
            $aspNetUser = new AspNetUser();
            $aspNetUser->Id = $results[0]['Id'];
            $aspNetUser->Email = $results[0]['Email'];
            $aspNetUser->EmailConfirmed = $results[0]['EmailConfirmed'];
            $aspNetUser->PasswordHash = $results[0]['PasswordHash'];
            $aspNetUser->SecurityStamp = $results[0]['SecurityStamp'];
            $aspNetUser->PhoneNumber = $results[0]['PhoneNumber'];
            $aspNetUser->PhoneNumberConfirmed = $results[0]['PhoneNumberConfirmed'];
            $aspNetUser->TwoFactorEnabled = $results[0]['TwoFactorEnabled'];
            $aspNetUser->LockoutEnabled = $results[0]['LockoutEnabled'];
            $aspNetUser->AccessFailedCount = $results[0]['AccessFailedCount'];
            $aspNetUser->UserName = $results[0]['UserName'];
        }

        $this->dbHandler->Close();

        return $aspNetUser;
    }
}
