<?php

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
      return $this->page()->children();
    }

}
