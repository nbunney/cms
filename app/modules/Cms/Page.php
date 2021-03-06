<?php namespace Cms; 
/**
 * Model to deal with the menu
 * @author Matthew Davies <daviesgeek@icloud.com>
 * @created March 31st, 2014
 */

class Page extends \Eloquent{

  protected $table = 'page';

  protected $guarded = array();
  protected $fillable = array();

  public function edits() {
    return $this->hasMany('\Cms\Edit', 'page_id');
  }

  public function template() {
    return $this->belongsTo('\Cms\Template');
  }

  public function scopeDisplay($query) {
    return $query->where('active', 1);
  }

  /**
   * Checks to see if the page exists or not
   * And returns either a static instance of this class or false
   * @param  string $page
   * @return false|void
   */
  public static function doesExist($page) {

    // Get this page
    self::$page = \DB::table('page')->where('url', $page)->first();
    
    // If this page exists
    if(!empty(self::$page)) {

      // Get the template name
      self::$page->template = \DB::table('template')->where('id', self::$page->template)->pluck('name');
      // Get the edits
      self::$edits = \Cms\Edit::get(self::$page, true);
      
      // Return a new instance of this class
      return new static;
    }else{

      // Else return false
      return false;
    }
  }

  public function getAll() {
    return $this->all()->toArray();
  }

}