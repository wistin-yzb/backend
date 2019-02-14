<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Picture extends controller {
	
	// picture-list
	public function picture_list() {
		$view = new View ();
		return $view->fetch ( 'picture/picture_list' );
	}
	
	// picture-add
	public function picture_add() {
		$view = new View ();
		return $view->fetch ( 'picture/picture_add' );
	}
	
	//picture-show
	public function picture_show() {
		$view = new View ();
		return $view->fetch ( 'picture/picture_show' );
	}
}