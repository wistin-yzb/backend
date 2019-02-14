<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class User extends controller {
	// user_list
	public function user_list() {
		$view = new View ();
		return $view->fetch ( 'user/user_list' );
	}
	
	// user_add
	public function user_add() {
		$view = new View ();
		return $view->fetch ( 'user/user_add' );
	}
	
	// user_show
	public function user_show() {
		$view = new View ();
		return $view->fetch ( 'user/user_show' );
	}
	
	// user_password_edit
	public function user_password_edit() {
		$view = new View ();
		return $view->fetch ( 'user/user_password_edit' );
	}
	
	// record_browse
	public function record_browse() {
		$view = new View ();
		return $view->fetch ( 'user/record_browse' );
	}
	
	// record_download
	public function record_download() {
		$view = new View ();
		return $view->fetch ( 'user/record_download' );
	}
	
	// record_share
	public function record_share() {
		$view = new View ();
		return $view->fetch ( 'user/record_share' );
	}
}