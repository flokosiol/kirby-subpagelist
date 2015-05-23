<?php
/**
 * Field plugin Subpagelist
 *
 * @package   Kirby CMS
 * @author    Flo Kosiol <git@flokosiol.de>
 * @link      http://flokosiol.de
 * @version   1.0.2
 */

class SubpagelistField extends BaseField {

  const LANG_DIR = 'languages';

  /**
   * Assets
   */
  public static $assets = array(
    'css' => array(
      'subpagelist.css',
    ),
  );


  /**
   * Constructor
   */
  public function __construct() {
    
    $baseDir = __DIR__ . DS . self::LANG_DIR . DS;
    $lang    = panel()->language();
    
    if (file_exists($baseDir . $lang . '.php')) {
      require $baseDir . $lang . '.php';
    } 
    else {
      require $baseDir . 'en.php';
    }

  }

  /**
   * Set field property and default value if required
   *
   * @param string $option
   * @param mixed  $value
   */
  public function __set($option, $value) {
      
    /* Set given value */
    $this->$option = $value;

    /* Validation */
    switch($option) {
      case 'flip':
        if(!is_bool($value))
          $this->flip = false;
        break;          
    }
  }
    
  /**
   * Generate label markup
   *
   * @return string
   */
  public function label() {
    
    $add = new Brick('a');
    $add->addClass('subpagelist-button file-add-button hgroup-option-right');
    $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('pages.show.subpages.add'));
    $add->attr('href', purl($this->page(), 'add'));

    $edit = new Brick('a');
    $edit->addClass('subpagelist-button file-edit-button hgroup-option-right');
    $edit->html('<i class="icon icon-left fa fa-pencil"></i>' . l('pages.show.subpages.edit'));
    $edit->attr('href', purl('subpages/index/'.$this->page()->id()));

    $label = parent::label();
    $label->addClass('hgroup-title');
    $label->append($edit);
    $label->append($add);

    return $label;

  }

  /**
   * Generate field content markup
   *
   * @return string
   */
  public function content() {

    $wrapper = new Brick('div');
    $wrapper->addClass('subpagelist');
    $wrapper->data(array(
        'field' => 'subpagelist',
        'name'  => $this->name(),
        'page'  => $this->page(),
    ));
    $wrapper->html(tpl::load(__DIR__ . DS . 'template.php', array('field' => $this)));
    return $wrapper;

  }


  /**
   * Get subpages
   *
   * @return object
   */
  public function subpages() {

    $field = &$this;
    $subpages = $this->page()->children();

    if (isset($this->flip) && $this->flip == TRUE) {
      $subpages = $subpages->flip();
    } 

    return $subpages;
  }


}
