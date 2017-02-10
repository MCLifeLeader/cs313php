<?php 
namespace phpProject\Models;

class AspNetUser
{
	public $Id;
	public $Email;
	public $EmailConfirmed;
	public $PasswordHash;
	public $SecurityStamp;
	public $PhoneNumber;
	public $PhoneNumberConfirmed;
	public $TwoFactorEnabled;
	public $LockoutEndDateUtc;
	public $LockoutEnabled;
	public $AccessFailedCount;
	public $UserName;
}
