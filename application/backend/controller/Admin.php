<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Admin extends controller {
	// admin_role
	public function admin_role() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_role' );
	}
	
	// admin_role_add
	public function admin_role_add() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_role_add' );
	}
	
	//admin_permission
	public function admin_permission() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_permission' );
	}
	
	//admin_permission_add
	public function admin_permission_add() {		
		return 'admin_permission_add';
	}
	
	//admin_password_edit
	public function admin_password_edit() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_password_edit' );
	}
	
	//admin_list
	public function admin_list() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_list' );
	}
	
	//admin_add
	public function admin_add() {
		$view = new View ();
		return $view->fetch ( 'admin/admin_add' );
	}
}