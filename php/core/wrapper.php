<?php
/**
 * wrapper.php
 *
 * Loads all required php files
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

$paths = array(
  CORE_PATH . '/classes'
  ,CORE_PATH . '/functions'
  ,CONFIG_PATH
);
$includeFiles = getPhpFiles($paths);
foreach ($includeFiles as $id => $file) {
  require_once $file;
}

/** Recursively finds all php files in directories and returns an array of their full paths
 * @param string[] $paths
 * @return string[] */
function getPhpFiles(array $paths) {
  $files = array();
  foreach ($paths as $iPath => $dir) {
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
      if (preg_match('/\.php$/', $path)) {
        $files[] = $path;
      }
      elseif (is_dir($path)) {
        $files = array_merge($files, getPhpFiles(array($path)));
      }
    }
  }
  return $files;
}

?>