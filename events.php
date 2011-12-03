<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Events_Store {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
    }
    
    public function run()
    {
    }
    
}
/* End of file events.php */