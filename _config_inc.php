<?php 
/* Initial Timezoone */
date_default_timezone_set('Asia/Phnom_Penh');
/* DATABASE CONNECTIVITY SETTINGS */
$configs['hostname'] = '127.0.0.1';
$configs['username'] = 'root';
$configs['password'] = '';
$configs['database'] = 'fmc_db';
$configs['char_set'] = 'utf8';
$configs['dbcollat'] = 'utf8_unicode_ci';
$configs['dbprefix'] = '';
$configs['dbport']	 = '';

$siteLanguages 		 = array('kh'=>'Khmer','en' => 'English');
/* Application path */
define('BASE_PATH', str_replace("\\", "/", dirname(__FILE__)).'/'); 
define('ADMIN_PATH',BASE_PATH . 'adminpage/'); 
$selfPath  = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
$selfPath .= $_SERVER['HTTP_HOST'].'/';
$selfPath .= trim(str_replace($_SERVER['DOCUMENT_ROOT'],'',BASE_PATH),"/");
define('BASE_URL',$selfPath . '/'); 
/*define('ADMIN_URL',BASE_URL . '/' . 'adminpage/'); */
define('ADMIN_URL',BASE_URL . 'adminpage/'); 
unset($selfPath);