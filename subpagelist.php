<?php
/**
 * Field plugin Subpagelist
 *
 * @package   Kirby CMS
 * @author    Flo Kosiol <git@flokosiol.de>
 * @link      http://flokosiol.de
 * @version   2.0.2
 */

use Kirby\Panel\Snippet;

class SubpagelistField extends BaseField {

  /**
   * Assets
   */
  public static $assets = array(
    'css' => array(
      'subpagelist.css',
    ),
  );

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
    return NULL;
  }

  /**
   * Generate field content markup
   *
   * @return string
   */
  public function content() {

    $wrapper = new Brick('div');
    $wrapper->addClass('subpagelist');

    $children = $this->subpages();
    
    // add pagination to the subpages
    $limit = ($this->limit()) ? $this->limit() : 10000;
    $children = $children->paginated('sidebar');

    // Kirby >= 2.2
    $pagination = new Snippet('pagination', array(
      'pagination' => $children->pagination(),
      'nextUrl'    => $children->pagination()->nextPageUrl(),
      'prevUrl'    => $children->pagination()->prevPageUrl(),
    ));

    // use existing snippet to build the list
    // @see panel/app/controllers/views/pages.php
    // Kirby 2.2 @see /panel/app/src/panel/models/page/sidebar.php
    $subpages = new Snippet('pages/sidebar/subpages', array(
      'title'      => $this->i18n($this->label),
      'page'       => $this->page(),
      'subpages'   => $children,
      'addbutton'  => $this->page->addButton(),
      'pagination' => $pagination,

    ));

    // use template with defined vars
    $wrapper->html(tpl::load(__DIR__ . DS . 'template.php', array('subpages' => $subpages)));
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

    // Check for filters
    if (isset($this->filter) && is_array($this->filter)) {
      $filter = $this->filter();

      // only visible subpages
      if (isset($filter['visible']) && $filter['visible'] == TRUE) {
        $subpages = $subpages->visible();
      }

      // only invisible subpages
      if (isset($filter['visible']) && $filter['visible'] == FALSE) {
        $subpages = $subpages->invisible();
      }

      // only specific template
      if (!empty($filter['template'])) {
        $subpages = $subpages->filterBy('template',$filter['template']);
      }

      // only specific intendedTemplate
      if (!empty($filter['intendedTemplate'])) {
        $subpages = $subpages->filterBy('intendedTemplate',$filter['template']);
      }

      // filterBy
      if (!empty($filter['filterBy']) && !empty($filter['filterMethod']) && !empty($filter['filterValue'])) {
        $subpages = $subpages->filterBy($filter['filterBy'],$filter['filterMethod'],$filter['filterValue']);
      }

      
    }

    // reverse order
    if (isset($this->flip) && $this->flip == TRUE) {
      $subpages = $subpages->flip();
    } 

    return $subpages;
  }

}
