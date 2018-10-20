<?php
/**
 * http.php
 *
 * Contains http functions
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

/** Retrieves the clients IP address
 * @return string */
function getIP(){
  $ip = '';
  if( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) AND strlen($_SERVER['HTTP_X_FORWARDED_FOR'])>6 ){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }elseif( !empty($_SERVER['HTTP_CLIENT_IP']) AND strlen($_SERVER['HTTP_CLIENT_IP'])>6 ){
     $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['REMOTE_ADDR']) AND strlen($_SERVER['REMOTE_ADDR'])>6){
     $ip = $_SERVER['REMOTE_ADDR'];
  }
  return strip_tags($ip);
}

?>