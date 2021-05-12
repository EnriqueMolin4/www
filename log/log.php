<?php
//Multiline error log class
// ersin g�ven� 2008 eguvenc@gmail.com
//For break use "\n" instead '\n'
date_default_timezone_set('America/Monterrey');

class Log {
	//
	//const USER_ERROR_DIR = '/home/site/error_log/Site_User_errors.log';
	
	const GENERAL_ERROR_DIR = '/log/error_2017.log';
	const GENERAL_CONNECTION_DIR = '/log/connection_2017.log';
	const SYNC_DIR = '/log/sync_2017.log';

	/*
	 User Errors...
	*/
	public function user($msg,$username)
	{
		$date = date('d.m.Y h:i:s');
		$message = $msg."   |  Date:  ".$date."  |  User:  ".$username."\n";
		error_log($message, 3, self::USER_ERROR_DIR);
	}
	/*
	 General Errors...
	*/
	public function error($msg)
	{
		$myVar = str_replace("\\","/",dirname(dirname(__FILE__))) .self::GENERAL_ERROR_DIR ;
		$date = date('d.m.Y h:i:s');
		$message = $date.' '.$msg."\n";
		error_log($message, 3, $myVar);
	}
	/*
	 Connection Log...
	*/
	public function connection($msg)
	{
		$myVar = str_replace("\\","/",dirname(dirname(__FILE__))) . self::GENERAL_CONNECTION_DIR;
 
		$date = date('d.m.Y h:i:s');
		$message = $date.' '.$msg."\n";
		error_log($message, 3, $myVar);
	}
	
	/*
	 Sync Errors...
	*/
	public function sync($msg)
	{
		$myVar = str_replace("\\","/",dirname(dirname(__FILE__))) .self::SYNC_DIR ;
		$date = date('d.m.Y h:i:s');
		$message = $date.'	:	'.$msg."\n";
		error_log($message, 3, $myVar);
	}
}

$log = new Log();

//$log->user($msg,$username); //use for user errors
//$log->general($msg); //use for general errors