<?php
/**
 * Vita.php
 *
 * Contains the vita class
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/

/**
 * Vita
 *
 * Loads the Vita version and provides the function to fetch vita data
 *
 * PHP version 7.2
 *
 * @package    Vita
 * @author     Michael Hedderich
 * @copyright  2018 Michael Hedderich
 * @license    None
 * @version    1.0.0
*/
class Vita {
  /** The vita version
   * @var boolean $version */
  public $version;

  /** Constructor that retrieves the vita version
	 * @return void */
  function __construct() {
    global $DB;
    $this->version = $DB->getString('select versionnumber from system where name = ?', array('version'));
  }
  
  /** Retrieves the vita data
	 * @return mixed[] */
  function getData() {
    global $DB;
    $heading = $DB->getString("select TT.text from system SY join text_translations TT on SY.text = TT.name where SY.name = ?", array('header'));
    $menu = $DB->getString("select TT.text from system SY join text_translations TT on SY.text = TT.name where SY.name = ?", array('menu'));

    $query = 'select vt.id, vt.name as type, vt.animatable, tt.text from vita_type vt
      join text_translations tt on vt.text = tt.name';
    $result = $DB->get($query, array());
    $vita = array();
  
    foreach ($result as $key => $value) {
      $type = $value['type'];
      unset($value['type']);
      $vita[$type] = $value;
    }
  
    $query = 'select ve.id, tt.text as name, tt2.text as value, ve.`type` from vita_elements ve
      join text_translations tt on ve.name = tt.name
      join text_translations tt2 on ve.value = tt2.name';
    $result = $DB->get($query, array());
    foreach ($result as $key => $value) {
      $type = $value['type'];
      unset($value['type']);
      $vita[$type]['values'][] = $value;
    }
  
    $query = 'select st.id, st.vita_type, st.name as type, tt.text as name from skill_type st
      join text_translations tt on st.text = tt.name';
    $result = $DB->get($query, array());
  
    foreach ($result as $key => $value) {
      $vita_type = $value['vita_type'];
      $type = $value['type'];
      unset($value['type']);
      unset($value['vita_type']);
      $vita[$vita_type]['skills'][$type] = $value;
    }
  
    $query = 'select sk.id, tt.text, sk.level, sk.`type`, st.vita_type, tt2.text as description from skills sk
      join text_translations tt on tt.name = sk.name
      join knowledge_level kl on kl.name = sk.`level`
      join text_translations tt2 on kl.text = tt2.name
      join skill_type st on sk.`type` = st.name
      order by sk.id asc';
    $result = $DB->get($query, array());
  
    foreach ($result as $key => $value) {
      $vita_type = $value['vita_type'];
      $type = $value['type'];
      unset($value['type']);
      unset($value['vita_type']);
      $vita[$vita_type]['skills'][$type]['values'][] = $value;
    }
    return array('heading' => $heading, 'menu' => $menu, 'vita' => $vita);
  }
}

?>