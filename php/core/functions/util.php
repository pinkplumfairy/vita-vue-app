<?php
/**
 * util.php
 *
 * Contains utility functions
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

/** Extracts a value from an array if possible and normalises the value
 * @param string[] $array The array to extract the value from
 * @param string $key The key under which the value is stored
 * @param string $emptyValue The value that should be returned if the key does not exist
 * @param boolean $trim Should the value be trimmed
 * @param boolean $removeNewLines Should all CRs, NLs and tabs be removed from the value
 * @return mixed */
function getValue($array, $key, $emptyValue = NULL, $trim = TRUE, $removeNewLines = TRUE) {
  if (isset($array[$key]) && !(empty($array[$key]) && $array[$key] != '0')) {
    $value = $array[$key];
  } else {
    return $emptyValue;
  }
  if ($trim === TRUE) {
    $value = trim($value);
  }
  if ($removeNewLines === TRUE) {
    $value = str_replace (array("\r\n", "\n", "\r", "\t"), ' ', $value);
    $value = preg_replace('!\s+!', ' ', $value);
  }
  return $value;
}

/** Provides the functionality of var_dump but returns the string instead of echoing it
 * @param mixed $object
 * @return string */
function var_dump_r($object = NULL) {
  ob_start();
  var_dump($object);
  $contents = ob_get_contents();
  ob_end_clean();
  return $contents;
}

?>