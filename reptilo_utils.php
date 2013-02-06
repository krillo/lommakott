<?php
/*
 * Description: The file contains functions commonly used by Reptilo 
 * Author: Kristian Erendi
 * Author URI: http://reptilo.se
 * Date: 2012-12-06
 * License: GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Version: 1.0
 */

/**
 * Get the logfile name. a new file every month 
 * @return string 
 */
function rep_getLogFileName() {
  $logFile = dirname(__FILE__) . '/log/reptilo' . "." . date("y-m") . ".log";
  return $logFile;
}

/**
 * Writes to log file. Adds datetime end serverity. INFO is the default severity
 * If the file does not exist then it will be created first 
 */
function rep_saveToLogFile($filename, $data, $type = 'INFO') {
  if (!file_exists($filename)) {
    touch($filename);
  }
  $fh = fopen($filename, 'a') or die("can't open file");
  fwrite($fh, "\n" . date('Y-m-d H:m:s') . ' [' . $type . '] ');
  fwrite($fh, $data);
  fclose($fh);
}

/**
 * Send email, in utf8, check for valid email. Writes to log file 
 */
function rep_sendMail($title, $message, $to, $to_name, $from, $from_name) {
  $errMsg = '';
  if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
    rep_saveToLogFile(rep_getLogFileName(), "Sending email: " . $title . ", to: $to ", 'INFO');

    $headers = 'To: ' . $to_name . ' <' . $to . '>' . "\r\n";
    $headers .= 'From: ' . $from_name . ' <' . $from . '>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $success = mail($to, $title , $message, $headers);
  } else {
    $success = false;
    $errMsg = "Invalid email, doesn't pass filter";
  }
  if (!$success) {
    rep_saveToLogFile(rep_getLogFileName(), "Failed to send email: " . $title . ", to: $to \r\nError message: " . $errMsg, 'ERROR');
  }
}