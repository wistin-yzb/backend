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
		//获取所有案例的统计信息
		$where = 'id>0 and status=1';
		$list = db ( 'line' )->where ( $where )->field('name,state_ip')->order('id','desc')->select ();		
		//$jsonreturn = '{"data":{"抽签26":{"friends":[{"value":1,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":2,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":6,"label":{"show":true}},{"value":3,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":3,"label":{"show":true}},{"value":5,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":3,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":1,"label":{"show":true}},{"value":2,"label":{"show":true}},{"value":2,"label":{"show":true}},{"value":3,"label":{"show":true}},{"value":0,"label":{"show":true}}],"timeline":[{"value":122,"label":{"show":true}},{"value":113,"label":{"show":true}},{"value":118,"label":{"show":true}},{"value":155,"label":{"show":true}},{"value":220,"label":{"show":true}},{"value":245,"label":{"show":true}},{"value":242,"label":{"show":true}},{"value":265,"label":{"show":true}},{"value":151,"label":{"show":true}},{"value":49,"label":{"show":true}},{"value":27,"label":{"show":true}},{"value":36,"label":{"show":true}},{"value":24,"label":{"show":true}},{"value":29,"label":{"show":true}},{"value":59,"label":{"show":true}},{"value":137,"label":{"show":true}},{"value":225,"label":{"show":true}},{"value":221,"label":{"show":true}},{"value":197,"label":{"show":true}},{"value":135,"label":{"show":true}},{"value":109,"label":{"show":true}},{"value":114,"label":{"show":true}},{"value":118,"label":{"show":true}},{"value":121,"label":{"show":true}},{"value":126,"label":{"show":true}},{"value":7,"label":{"show":true}}],"total":[{"value":123,"label":{"show":true}},{"value":113,"label":{"show":true}},{"value":118,"label":{"show":true}},{"value":155,"label":{"show":true}},{"value":222,"label":{"show":true}},{"value":245,"label":{"show":true}},{"value":248,"label":{"show":true}},{"value":268,"label":{"show":true}},{"value":152,"label":{"show":true}},{"value":49,"label":{"show":true}},{"value":28,"label":{"show":true}},{"value":36,"label":{"show":true}},{"value":24,"label":{"show":true}},{"value":30,"label":{"show":true}},{"value":59,"label":{"show":true}},{"value":138,"label":{"show":true}},{"value":228,"label":{"show":true}},{"value":226,"label":{"show":true}},{"value":198,"label":{"show":true}},{"value":138,"label":{"show":true}},{"value":109,"label":{"show":true}},{"value":115,"label":{"show":true}},{"value":120,"label":{"show":true}},{"value":123,"label":{"show":true}},{"value":129,"label":{"show":true}},{"value":7,"label":{"show":true}}],"ratio":[{"value":"34.17","label":{"show":false}},{"value":"40.07","label":{"show":false}},{"value":"34.20","label":{"show":false}},{"value":"35.47","label":{"show":false}},{"value":"36.94","label":{"show":false}},{"value":"37.07","label":{"show":false}},{"value":"35.48","label":{"show":false}},{"value":"43.72","label":{"show":false}},{"value":"33.78","label":{"show":false}},{"value":"32.67","label":{"show":false}},{"value":"34.57","label":{"show":false}},{"value":"60.00","label":{"show":false}},{"value":"48.98","label":{"show":false}},{"value":"18.75","label":{"show":false}},{"value":"31.72","label":{"show":false}},{"value":"33.33","label":{"show":false}},{"value":"35.24","label":{"show":false}},{"value":"34.45","label":{"show":false}},{"value":"33.73","label":{"show":false}},{"value":"23.15","label":{"show":false}},{"value":"32.44","label":{"show":false}},{"value":"34.74","label":{"show":false}},{"value":"31.09","label":{"show":false}},{"value":"33.24","label":{"show":false}},{"value":"28.54","label":{"show":false}},{"value":"41.18","label":{"show":false}}]},"视频25":{"friends":[{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}}],"timeline":[{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}}],"total":[{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}},{"value":0,"label":{"show":true}}],"ratio":[{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":0,"label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}},{"value":0,"label":{"show":false}},{"value":0,"label":{"show":false}},{"value":"0.00","label":{"show":false}},{"value":0,"label":{"show":false}}]}},"key":["抽签26","视频25"],"hour":[15,16,17,18,19,20,21,22,23,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]}';
		
		$data = array();
		$key = array();
		$hour = array();
		
		if($list){
			foreach ($list as $k=>$v){
				$key[] = $v['name'];
// 				$rurl = "http://{$v['state_ip']}/r.txt";
// 				$data[$k][$v['name']]= $this->getall($rurl);
			}
		}
// 		echo '<pre>';
// 		var_dump($data);exit;
		
		$data = array(
			'案例1'=>array(
					'friend'=>array(
							array("value"=>1),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
					'timeline'=>array(
							array("value"=>2),
							array("value"=>3),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
					'total'=>array(
							array("value"=>3),
							array("value"=>3),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
			),
			'案例2'=>array(
					'friend'=>array(
							array("value"=>21),
							array("value"=>23),
							array("value"=>24),	
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
					'timeline'=>array(
							array("value"=>3),
							array("value"=>4),
							array("value"=>9),	
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
					'total'=>array(
							array("value"=>24),
							array("value"=>27),
							array("value"=>33),	
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
							array("value"=>0),
					),
			),
		);
		$hour =$this->get24hourArry();
		$jsonreturn = json_encode(array(
				"data"=>$data,
				"key"=>$key,
				"hour"=>$hour,
		));
		exit($jsonreturn);		
	}
	
	//获取全部记录数据
	public  function getall($fileurl){
		$json = file_get_contents($fileurl);		
		if($json != '')
		{
			$arr = json_decode($json,true);
		}else{
			$arr = array();
		}		
		$timeline = $arr['timeline'];
		$friend  = $arr['friend'];
		
		$sum1 = $timeline[0];
		$sum2 = $friend[0];
		
		unset($timeline[0]);
		unset($friend[0]);
		
		$max = strtotime(date('Y-m-d H:00:00')); //当前时间		
		
		$min1 = current(array_keys($timeline));
		$min2 = current(array_keys($friend));
		$min = $min1 >= $min2 ? $min1 : $min2;
		
		if($min1 != $min2)
		{
			foreach($timeline as $key => $value)
			{
				if($key < $min)
				{
					unset($timeline[$key]);
				}
			}
			foreach($friend as $key => $value)
			{
				if($key < $min)
				{
					unset($friend[$key]);
				}
			}
		}
		
		$long = 25;
		if($max > $min + $long * 60 * 60)
		{			
			$min = $max - $long * 60 * 60;
			foreach($timeline as $key => $value)
			{
				if($key < $min)
				{
					unset($timeline[$key]);
				}
			}
			foreach($friend as $key => $value)
			{
				if($key < $min)
				{
					unset($friend[$key]);
				}
			}
		}
		
		$keys = array();
		$all = array();
		$len = ($max - $min) / (60 * 60);
		for($i = 0; $i <= $len; $i ++)
		{
				$key = $min + $i * 60 * 60;
				$keys[$i] = $key;
				if(!isset($timeline[$key]))
				{
					$timeline[$key] = 0;
				}
				if(!isset($friend[$key]))
				{
					$friend[$key] = 0;
				}
				ksort($timeline);
				ksort($friend);
				$all[$key] = $timeline[$key] + $friend[$key];
		}
		return array(
				'friend'=>$friend,
				'timeline'=>$timeline,
				'total'=>$all,
				'keys'=>$keys				
		);
}

//获取当前时间的前24个小时
public function get24hourArry(){
	$sysh = date('H');
	$sysh1 = $sysh-1>=0?$sysh-1:24-1;
	$sysh2 = $sysh-2>=0?$sysh-2:24-2;
	$sysh3 = $sysh-3>=0?$sysh-3:24-3;
	$sysh4 = $sysh-4>=0?$sysh-4:24-4;
	$sysh5 = $sysh-5>=0?$sysh-5:24-5;
	$sysh6 = $sysh-6>=0?$sysh-6:24-6;
	$sysh7 = $sysh-7>=0?$sysh-7:24-7;
	$sysh8 = $sysh-8>=0?$sysh-8:24-8;
	$sysh9 = $sysh-9>=0?$sysh-9:24-9;
	$sysh10 = $sysh-10>=0?$sysh-10:24-10;
	return array($sysh10,$sysh9,$sysh8,$sysh7,$sysh6,$sysh5,$sysh4,$sysh3,$sysh2,$sysh1,$sysh);
}
}