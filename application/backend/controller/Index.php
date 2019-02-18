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
	
	//群分享、圈分享、总量、分享率统计
	public function statistics(){
		action('Common/checkSession');		
		$servers = Db::name('line')->where('status', 1)->order('id', 'desc')->limit(5)->select();		
		
		$lines = [];
		if ($servers) {
			// 超时限定
			$opts = stream_context_create(array(
					'http' => array(
							'timeout' => 1   // Timeout in seconds
					)
			));		
			
			// 时间下标
			$now = date('H');
			$today = range(0, $now);
			$lastDay = $now > 0 ? range($now-1, 23) : range($now, 23);
			$hour = array_merge($lastDay, $today);
			
			foreach ($servers as $server) {
				//群分享
				$friend = [];
				// 圈分享
				$timeline = [];
				// total
				$total = [];
				// 比例
				$ratio = [];
				
				// 分析数据
				@$json = !empty($server['state_ip']) ? file_get_contents("http://{$server['state_ip']}/r.txt", false, $opts) : '';
				if ($json != '') {
					$arr = json_decode($json, true);
				} else {
					$arr = array();
				}
				// 访问数据
				@$visite = !empty($server['state_ip']) ? file_get_contents("http://{$server['state_ip']}/r_view.txt", false, $opts) : '';
				if ($visite != '') {
					$visiteArr = json_decode($visite, true);
				} else {
					$visiteArr = array();
				}
				$count = 1;
				foreach ($hour as $key => $item) {
					if ($count <= count($lastDay)) {
						$index = strtotime(date('Y-m-d ',strtotime('-1 day')) . $item . ':0:0');
					}  else {
						$index = strtotime(date('Y-m-d ') . $item . ':0:0');
					}
					$count++;
					$friend[$key]['value'] = isset($arr['friend'][$index]) ? $arr['friend'][$index] : 0;
					$friend[$key]['label'] = ['show' => true];
					$timeline[$key]['value'] = isset($arr['timeline'][$index]) ? $arr['timeline'][$index] : 0;
					$timeline[$key]['label'] = ['show' => true];
					$total[$key]['value'] = $friend[$key]['value'] + $timeline[$key]['value'];
					$total[$key]['label'] = ['show' => true];
					
					$ratio[$key]['value'] = (empty($visiteArr) || !isset($visiteArr['baba'][$index]) || empty($visiteArr['baba']) || empty($visiteArr['baba'][$index])) ? 0 : (sprintf('%.2f', (($friend[$key]['value'] + $timeline[$key]['value']) * 100) / $visiteArr['baba'][$index]));
					$ratio[$key]['label'] = ['show' => false];
					if (100 <= $ratio[$key]['value']) {
						$ratio[$key]['value'] = 100;
					}
					
				}
				$lines[$server['name']] = [
						'friend' => $friend,
						'timeline' => $timeline,
						'total' => $total,
						'ratio' => $ratio
				];
			}
			return json(['data' => $lines, 'key' => array_keys($lines), 'hour' => $hour]);
		} else {
			return json([]);
		}
		
	}
}