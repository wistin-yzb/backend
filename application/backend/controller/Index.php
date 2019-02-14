<?php

namespace app\backend\controller;

use \think\View;
use \think\Controller;
use think\Db;

class Index extends controller {
	// index
	public function index() {		
		action('Common/checkSession');
		$view = new View ();
		return $view->fetch ();
	}
	
	// login
	public function login() {
		$view = new View ();
		return $view->fetch ();
	}
	
	//checklogin
	public function checklogin() {
		$account = input ( 'post.account' );
		$password = input ( 'post.password' );
		if ($account == "" || $password == "") {
			$this->error ( '请填写登录信息' );
			exit ();
		}
		if($account!='zysys2019admin'&&$password!='zysys2019passwd'){
			$this->error ( '登录信息填写错误' );
			exit ();
		}
		$captcha = input ( 'post.captcha' );
		if (! captcha_check ( $captcha )) {
			$this->error ( '验证码错误' );
			exit ();
		}	
		session('account', $account);
		$this->redirect ( 'backend/index/index');
	}
	
	// welcome
	public function welcome() {
		action('Common/checkSession');
		$view = new View ();		
		$view->lastLoginIp = $this->request->ip();
		$view->lastLoginTime = date('Y-m-d H:i:s',time());
		return $view->fetch ();
	}
	
	// loginout
	public function loginout() {
		session('account',null);
		$this->redirect ( 'backend/index/login' );
	}
	
	//clearcache
	public function clearcache(){		
		$R = RUNTIME_PATH;
		//执行删除函数
		if($this->_deleteDir($R))
		exit(json_encode(1));
		else
		exit(json_encode(-1));
	}
	
	//删除文件夹
	private function _deleteDir($R){
		//打开一个目录句柄
		$handle = opendir($R);
		//读取目录,直到没有目录为止
		while(($item = readdir($handle)) !== false){
			//跳过. ..两个特殊目录
			if($item != '.' and $item != '..'){
				//如果遍历到的是目录
				if(is_dir($R.'/'.$item)){
					//继续向目录里面遍历
					$this->_deleteDir($R.'/'.$item);
				}else{
					//如果不是目录，删除该文件
					if(!unlink($R.'/'.$item))
						die('error!');
				}
			}
		}
		//关闭目录
		closedir( $handle );
		//删除空的目录
		return rmdir($R);
	}
}
