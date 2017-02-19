<?php 
namespace phpProject\DataLayer;


require_once (dirname(__FILE__).'/../Models/AspNetUser.php');
require_once (dirname(__FILE__).'/../Models/MlmCompanyProfile.php');
require_once (dirname(__FILE__).'/../Helpers/Strings.php');
require_once 'DbBase.php';

use phpProject\DataLayer\DbBase;
use phpProject\Helpers\Strings;
use phpProject\Models\AspNetUser;
use phpProject\Models\MlmCompanyProfile;
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

    function InsertMlmProfile($mlmProfile)
    {
        $this->dbHandler->Open();
        
        $query = "INSERT INTO public.\"MlmCompanyProfiles\"
        (
            \"MlmCompanyName\"
            , \"YearFounded\"
            , \"RepCount\"
            , \"BaseCommissionRange\"
            , \"DownlineComissionRange\"
            , \"StartUpCost\"
            , \"Address1\"
            , \"Address2\"
            , \"City\"
            , \"StateOrProvince\"
            , \"Country\"
            , \"MlmCompanyHomePageUrl\"
            , \"FacebookUrl\"
            , \"TwitterUrl\"
            , \"PintrestUrl\"
            , \"YouTubeUrl\"
            , \"InstagramUrl\"
            , \"CompanyAboutPageUrl\"
            , \"CompensationPlanUrl\"
            , \"AboutCompany\"
            , \"PotentialEarnings\"
            , \"Height\"
            , \"Width\"
            , \"MlmCompanyLogo\"
            , \"ContentType\"
            , \"Votes\"
            , \"CompanyRank\"
            , \"IsDisabled\"
            , \"IsHidden\"
            , \"FiveStarRankAverage\"
            , \"LastUpdated\"
            , \"DateCreated\"
        )        
        VALUES
        (
             :MlmCompanyName
            , :YearFounded
            , :RepCount
            , :BaseCommissionRange
            , :DownlineComissionRange
            , :Address1
            , :Address2
            , :City
            , :StateOrProvince
            , :Country
            , :MlmCompanyHomePageUrl
            , :FacebookUrl
            , :TwitterUrl
            , :PintrestUrl
            , :YouTubeUrl
            , :InstagramUrl
            , :CompanyAboutPageUrl
            , :CompensationPlanUrl
            , :AboutCompany
            , :PotentialEarnings
            , :Height
            , :Width
            , :MlmCompanyLogo
            , :ContentType
            , :Votes
            , :CompanyRank
            , :IsDisabled
            , :IsHidden
            , :FiveStarRankAverage
            , :LastUpdated
            , :DateCreated
        )";

        $sql = $this->dbHandler->dbConn->prepare($query);

        $mlmProfile->LastUpdated = date("Y-m-d H:i:s");
        $mlmProfile->DateCreated = date("Y-m-d H:i:s");

        $sql->bindValue( ":MlmCompanyName", $mlmProfile->MlmCompanyName, PDO::PARAM_STR );
        $sql->bindValue( ":YearFounded", $mlmProfile->YearFounded, PDO::PARAM_INT );
        $sql->bindValue( ":RepCount", $mlmProfile->RepCount, PDO::PARAM_INT );
        $sql->bindValue( ":BaseCommissionRange", $mlmProfile->BaseCommissionRange, PDO::PARAM_STR );
        $sql->bindValue( ":DownlineComissionRange", $mlmProfile->DownlineComissionRange, PDO::PARAM_STR );
        $sql->bindValue( ":Address1", $mlmProfile->Address1, PDO::PARAM_STR );
        $sql->bindValue( ":Address2", $mlmProfile->Address2, PDO::PARAM_STR );
        $sql->bindValue( ":City", $mlmProfile->City, PDO::PARAM_STR );
        $sql->bindValue( ":StateOrProvince", $mlmProfile->StateOrProvince, PDO::PARAM_STR );
        $sql->bindValue( ":Country", $mlmProfile->Country, PDO::PARAM_STR );
        $sql->bindValue( ":MlmCompanyHomePageUrl", $mlmProfile->MlmCompanyHomePageUrl, PDO::PARAM_STR );
        $sql->bindValue( ":FacebookUrl", $mlmProfile->FacebookUrl, PDO::PARAM_STR );
        $sql->bindValue( ":TwitterUrl", $mlmProfile->TwitterUrl, PDO::PARAM_STR );
        $sql->bindValue( ":PintrestUrl", $mlmProfile->PintrestUrl, PDO::PARAM_STR );
        $sql->bindValue( ":YouTubeUrl", $mlmProfile->YouTubeUrl, PDO::PARAM_STR );
        $sql->bindValue( ":InstagramUrl", $mlmProfile->InstagramUrl, PDO::PARAM_STR );
        $sql->bindValue( ":CompanyAboutPageUrl", $mlmProfile->CompanyAboutPageUrl, PDO::PARAM_STR );
        $sql->bindValue( ":CompensationPlanUrl", $mlmProfile->CompensationPlanUrl, PDO::PARAM_STR );
        $sql->bindValue( ":AboutCompany", $mlmProfile->AboutCompany, PDO::PARAM_STR );
        $sql->bindValue( ":PotentialEarnings", $mlmProfile->PotentialEarnings, PDO::PARAM_STR );
        $sql->bindValue( ":Height", $mlmProfile->Height, PDO::PARAM_INT );
        $sql->bindValue( ":Width", $mlmProfile->Width, PDO::PARAM_INT );
        $sql->bindValue( ":MlmCompanyLogo", $mlmProfile->MlmCompanyLogo, PDO::PARAM_LOB );
        $sql->bindValue( ":ContentType", $mlmProfile->ContentType, PDO::PARAM_STR );
        $sql->bindValue( ":Votes", $mlmProfile->Votes, PDO::PARAM_STR );
        $sql->bindValue( ":CompanyRank", $mlmProfile->CompanyRank, PDO::PARAM_STR );
        $sql->bindValue( ":IsDisabled", $mlmProfile->IsDisabled, PDO::PARAM_BOOL );
        $sql->bindValue( ":IsHidden", $mlmProfile->IsHidden, PDO::PARAM_BOOL );
        $sql->bindValue( ":FiveStarRankAverage", $mlmProfile->FiveStarRankAverage, PDO::PARAM_STR );
        $sql->bindValue( ":LastUpdated", $mlmProfile->LastUpdated, PDO::PARAM_STR );
        $sql->bindValue( ":DateCreated", $mlmProfile->DateCreated, PDO::PARAM_STR );
        
        // echo $sql->debugDumpParams();

        $sql->execute();
        $this->dbHandler->Close();
    }
}
