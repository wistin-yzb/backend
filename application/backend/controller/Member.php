<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Member extends controller {	
	// member_list
	public function member_list() {
		$view = new View ();
		return $view->fetch ( 'member/member_list' );
	}
	
	// member_add
	public function member_add() {
		$view = new View ();
		return $view->fetch ( 'member/member_add' );
	}
	
	//member_del
	public function member_del() {
		$view = new View ();
		return $view->fetch ( 'member/member_del' );
	}
	
	//member_show
	public function member_show() {
		$view = new View ();
		return $view->fetch ( 'member/member_show' );
	}
	
	//member_record_browse
	public function member_record_browse() {
		$view = new View ();
		return $view->fetch ( 'member/member_record_browse' );
	}
	
	//member_record_download
	public function member_record_download() {
		$view = new View ();
		return $view->fetch ( 'member/member_record_download' );
	}
	
	//member_record_share
	public function member_record_share() {
		$view = new View ();
		return $view->fetch ( 'member/member_record_share' );
	}
	
	//member_scoreoperation
	public function member_scoreoperation() {
		return 'member_scoreoperation';
	}
	
	//member_level
	public function member_level() {
		return 'member_level';
	}
	
	//change_password
	public function change_password() {
		$view = new View ();
		return $view->fetch ( 'member/change_password' );
	}
}