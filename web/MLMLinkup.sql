/**************************************************************************
	Copyright (c) 2016 A Game Empowerment, LLC. All Rights Reserved
	Author: Michael Carey

**************************************************************************/

-- The contents of the schema build script have been REDACTED and will not be published and may only be published after it has been submitted to
-- The Library of Congress for offical registered Copyright protection.

/*
-- use the following to export from MS-SQL database for import into PostgreSQL
SELECT 'INSERT INTO "CountryCodeList" ("CountryCode","CountryName") VALUES (''' + [CountryCode] + ''',''' + [CountryName] + ''')' 
	FROM [dbo].[CountryCodeList] 
	WHERE CountryCode = 'US' 
	order by CountryCode


-- use the following to export from MS-SQL database for import into PostgreSQL
SELECT 'INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES (''' + 
	ISNULL(CONVERT(varchar(256),[Country]),'') + ''',''' + 
	ISNULL(CONVERT(varchar(256),[Location]),'') + ''',''' + 
	ISNULL(CONVERT(varchar(256),[LocationLongName]),'') + ''',''' + 
	ISNULL(CONVERT(varchar(256),[Name]),'') + ''',''' + 
	ISNULL(CONVERT(varchar(256),[Subdivision]),'') + ''');' 
		FROM [dbo].[CountryCodeData] 
		WHERE [Country] = 'US'
		order by Country,Location

-- *** WARNING *** check for single ' quote characters in output. You'll find several that will need to be addressed before import
*/

INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('Credit','Account Credit','0.00','1','0',NULL,'0',NULL,NULL);
INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('Payment','Payment from Account Credit','0.00','1','0',NULL,'0',NULL,NULL);
INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('Free','Free Membership','0.00','1','0',NULL,'7',NULL,'0');
INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('Basic','Basic Membership','9.95','1','0',NULL,'6',NULL,'0');
INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('VIP','VIP Membership','99.95','1','0',NULL,'5',NULL,'0');
INSERT INTO "BillingSubscriptionTypes" ("Name", "Description", "Price", "IsActive", "IsPromoType", "PromoParentId", "MemberLevel", "PaypalBillingPlanId", "DurationInMonths") VALUES ('Executive','Executive Membership','499.95','1','0',NULL,'4',NULL,'0');

INSERT INTO "CountryCodeList" ("CountryCode","CountryName") VALUES ('00','~Please Select a Country~')
INSERT INTO "CountryCodeList" ("CountryCode","CountryName") VALUES ('US','United States')

INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES ('US','','','.UNITED STATES','');
INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES ('US','SLC','','Salt Lake City','UT');
INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES ('US','PVU','','Provo','UT');
INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES ('US','RBI','','Rexburg','ID');
INSERT INTO "CountryCodeData" ("Country","Location","LocationLongName","Name","Subdivision") VALUES ('US','SEA','','Seattle','WA');

INSERT INTO public."AspNetUsers"
  (
    "Id"
    , "Email"
    , "EmailConfirmed"
    , "PasswordHash"
    , "SecurityStamp"
    , "PhoneNumber"
    , "PhoneNumberConfirmed"
    , "TwoFactorEnabled"
    , "LockoutEndDateUtc"
    , "LockoutEnabled"
    , "AccessFailedCount"
    , "UserName"
  )
  VALUES
  (
      'F88987E6-60F5-4E20-A9A9-296905192A2C'
      ,'car03009@byui.edu'
      ,TRUE
      ,'P@ssword123'
      ,''
      ,'208.201.1179'
      ,TRUE
      ,FALSE
      ,'2017-01-01'
      ,FALSE
      ,0
      ,'car03009@byui.edu'
  );

INSERT INTO public."AspNetUsers"
  (
    "Id"
    , "Email"
    , "EmailConfirmed"
    , "PasswordHash"
    , "SecurityStamp"
    , "PhoneNumber"
    , "PhoneNumberConfirmed"
    , "TwoFactorEnabled"
    , "LockoutEndDateUtc"
    , "LockoutEnabled"
    , "AccessFailedCount"
    , "UserName"
  )
  VALUES
  (
      'F88987E6-60F5-4E20-A9A9-296905192A2D'
      ,'kb7ppb@hotmail.com'
      ,TRUE
      ,'P@ssword123'
      ,''
      ,'208.201.1179'
      ,TRUE
      ,FALSE
      ,'2017-01-01'
      ,FALSE
      ,0
      ,'kb7ppb@hotmail.com'
  );

INSERT INTO public."AspNetUsers"
  (
    "Id"
    , "Email"
    , "EmailConfirmed"
    , "PasswordHash"
    , "SecurityStamp"
    , "PhoneNumber"
    , "PhoneNumberConfirmed"
    , "TwoFactorEnabled"
    , "LockoutEndDateUtc"
    , "LockoutEnabled"
    , "AccessFailedCount"
    , "UserName"
  )
  VALUES
  (
      'F88987E6-60F5-4E20-A9A9-296905192A2E'
      ,'kb7ppb@gmail.com'
      ,TRUE
      ,'P@ssword123'
      ,''
      ,'208.201.1179'
      ,TRUE
      ,FALSE
      ,'2017-01-01'
      ,FALSE
      ,0
      ,'kb7ppb@gmail.com'
  );
