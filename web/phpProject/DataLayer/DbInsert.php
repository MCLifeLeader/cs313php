<?php 
namespace phpProject\DataLayer;


require_once (dirname(__FILE__).'/../Models/AspNetUser.php');
require_once (dirname(__FILE__).'/../Helpers/Strings.php');
require_once 'DbBase.php';

use phpProject\DataLayer\DbBase;
use phpProject\Helpers\Strings;
use phpProject\Models\AspNetUser;
use \PDO;

class DbInsert extends DbBase
{
    function __construct() 
    {
        parent::__construct();        
    }

    function InsertUser($aspNetUser)
    {
        $this->dbHandler->Open();
        
        $query = "INSERT INTO \"AspNetUsers\"
        ( 
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
        )
        VALUES
        (
            '" . Strings::GUID() . "'
            , :Email
            , :EmailConfirmed
            , :PasswordHash
            , :SecurityStamp
            , :PhoneNumber
            , :PhoneNumberConfirmed
            , :TwoFactorEnabled
            , :LockoutEndDateUtc
            , :LockoutEnabled
            , :AccessFailedCount
            , :UserName
        )";

        $sql = $this->dbHandler->dbConn->prepare($query);

        $sql->bindValue( ":Email", $aspNetUser->Email, PDO::PARAM_STR );
        $sql->bindValue( ":EmailConfirmed", $aspNetUser->EmailConfirmed, PDO::PARAM_BOOL );
        $sql->bindValue( ":PasswordHash", $aspNetUser->PasswordHash, PDO::PARAM_STR );
        $sql->bindValue( ":SecurityStamp", $aspNetUser->SecurityStamp, PDO::PARAM_STR );
        $sql->bindValue( ":PhoneNumber", $aspNetUser->PhoneNumber, PDO::PARAM_STR );
        $sql->bindValue( ":PhoneNumberConfirmed", $aspNetUser->PhoneNumberConfirmed, PDO::PARAM_BOOL );
        $sql->bindValue( ":TwoFactorEnabled", $aspNetUser->TwoFactorEnabled, PDO::PARAM_BOOL );
        $sql->bindValue( ":LockoutEndDateUtc", $aspNetUser->LockoutEndDateUtc, PDO::PARAM_INT );
        $sql->bindValue( ":LockoutEnabled", $aspNetUser->LockoutEnabled, PDO::PARAM_BOOL );
        $sql->bindValue( ":AccessFailedCount", $aspNetUser->AccessFailedCount, PDO::PARAM_INT );
        $sql->bindValue( ":UserName", $aspNetUser->UserName, PDO::PARAM_STR );
        
        // echo $sql->debugDumpParams();

        $sql->execute();
        $this->dbHandler->Close();
    }
}
