<?php
/**
 * config.php
 *
 * Contains the app configuration
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

/** The global variable for the database 
 * @var \Mysql $DB */
$DB = new Mysql("localhost", "YOURDB", "YOURUSER", "YOURPW");
?>