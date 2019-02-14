<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class System extends controller {
	// system_base
	public function system_base() {
		$view = new View ();
		return $view->fetch ( 'system/system_base' );
	}
	
	// system_category
	public function system_category() {
		$view = new View ();
		return $view->fetch ( 'system/system_category' );
	}
	
	// system_category_add
	public function system_category_add() {
		$view = new View ();
		return $view->fetch ( 'system/system_category_add' );
	}
	
	// system_data
	public function system_data() {
		$view = new View ();
		return $view->fetch ( 'system/system_data' );
	}
	
	// system_data_edit
	public function system_data_edit() {
		$view = new View ();
		return $view->fetch ( 'system/system_data_edit' );
	}
	
	// system_shielding
	public function system_shielding() {
		$view = new View ();
		return $view->fetch ( 'system/system_shielding' );
	}
	
	// system_log
	public function system_log() {
		$view = new View ();
		return $view->fetch ( 'system/system_log' );
	}
}