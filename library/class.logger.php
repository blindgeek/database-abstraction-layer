<?php

/**
*
* Database logger class
* @author Joey Garcia
*/
class LoggerDb
{
private $log_filename = 'error.txt';

protected function logErr($err_message)
{

if (!is_writable($this->log_filename)) {
throw new Exception('Log file is not accessible.');
}

$fp = fopen('../logs/' . $this->log_filename, 'r+') or die('Unable to access log file.' . '<br>');
fwrite($fp, $err_message . "\n");
fclose($fp);
}
