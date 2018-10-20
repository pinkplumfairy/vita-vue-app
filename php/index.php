<?php
/**
 * index.php
 *
 * Entry point of the application
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

set_exception_handler("fatalError");
try {
  /** The recipient email address for error mails */
  define('ERROR_MAIL_RECIPIENT', 'olga@hedderi.ch');
  /** The package name */
  define('PACKAGE', 'Vita');
  /** The dir of the index file */
  define('ROOT_PATH', dirname(__FILE__) );
  /** The path of the core directory */
  define('CORE_PATH', ROOT_PATH . '/core' );
  /** The path of the classes directory */
  define('CLASSES_PATH', CORE_PATH . '/classes' );
  /** The path of the config directory */
  define('CONFIG_PATH', ROOT_PATH . '/config' );
  $mtime = microtime(true);
  /** The startup timestamp */
  define('TIMESTAMP', sprintf('%s%s', date("YmdHis"), substr($mtime - floor($mtime), 1)));
  unset($mtime);
} catch (Throwable $t) {
  fatalError(new Error("startup error", 1, $t));
}

try {
  require_once CORE_PATH . '/wrapper.php';
} catch (Throwable $t) {
  fatalError(new Error("compilation error", 1, $t));
}

try {
  $ip = getIP();
  if ($ip == '127.0.0.1'){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
  }
  header('Content-Type: application/json');

  $vita = new Vita;
  if ($vita->version !==  getValue($_GET, 'version')) {
    $data = $vita->getData();
    echo json_encode(array('result' => 'update','version' => $vita->version, 'data' => $data));
  } else {
    echo json_encode(array('result' => 'noupdate'));
  }
  $data = array();



} catch (Throwable $t) {
  fatalError(new Error("runtime error", 1, $t));
}




/** Top level error handler
 * @param int|\Error $t An object of type Error or an error code
 * @param string $text if $t is not an object, mandatory error text
 * @param string $file if $t is not an object, mandatory name of the file in which the error occurred
 * @param int $line if $t is not an object, mandatory line number in which the error occurred
*/
function fatalError($t, $text = NULL, $file = NULL, $line = NULL) {
  http_response_code(500);
  global $CONFIG;
  $errors = array();

  if (is_numeric($t)) {
    switch ($t) {
      case E_USER_ERROR:
        $errors[] = array('type' => 'system', 'data' => new Error('user error [' . $t . '] "' . $text . '" in file ' . $file . ' line ' . $line . '<br>', $t));
        break;
      case E_USER_WARNING:
        $errors[] = array('type' => 'system', 'data' => new Error('warning [' . $t . '] "' . $text . '" in file ' . $file . ' line ' . $line . '<br>', $t));
        break;
      case E_USER_NOTICE:
        $errors[] = array('type' => 'system', 'data' => new Error('notice [' . $t . '] "' . $text . '" in file ' . $file . ' line ' . $line . '<br>', $t));
        break;
      default:
        $errors[] = array('type' => 'system', 'data' => new Error('unknown error [' . $t . '] "' . $text . '" in file ' . $file . ' line ' . $line . '<br>', $t));
        break;
    }
  }

  while($t !== NULL) {
    array_unshift($errors, array('type' => 'custom', 'data' => $t));
    $t = ($t->getPrevious()) ? $t->getPrevious() : NULL;
  }
  $trace = 'Trace:<br>';
  foreach($errors as $errorNo => $error) {
    switch ($error['type']) {
      case 'system':
        $trace .= '#' . $errorNo . ': ' . $error['data']->getMessage() . '(' . $error['data']->getCode() . ')<br>';
        break;
      default:
        $trace .= '#' . $errorNo . ': ' . $error['data']->getMessage() . '(' . $error['data']->getCode() . ') in file ' . $error['data']->getFile() . " line " . $error['data']->getLine() . '<br>';
        break;
    }
  }
  if (!@mail(ERROR_MAIL_RECIPIENT, '[ERROR] ' . PACKAGE, $trace)) {
    echo 'Fatal Error! Please contact the site administrator!<br>' . $trace;
  }
  exit(1);
}

?>