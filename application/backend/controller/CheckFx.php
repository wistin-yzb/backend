<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class CheckFx extends controller {
	public function __construct() {
	}
	// 监听分享域名的自动切换
	public function index() {
		$linelist = db ( 'line' )->where ( "status", 1 )->field ( 'id,name' )->select ();
		if($linelist){
			$lineids = []; 
			foreach ($linelist as $key=>$val){
				$lineids[] = $val['id'];
			}
		}
		$lineidsstr = implode(',', $lineids);
		$where = "s.is_active=1 and s.line_id in ($lineidsstr)"; //对已启用的落地模式为手动的服务器进行监听
		$serverlist = db ( 'server' )->alias('s')->where ($where)->field('s.id,s.name,l.name as line_name,s.d1,s.d2,s.d3,s.d4,s.public_ip,s.line_id')->join('line l','s.line_id = l.id')->select ();
		if($serverlist){						
			foreach ($serverlist as $key_s=>$val_s){				
				if(!empty($val_s['d2'])){										
					//判断当前服务器的分享域名是否被封
					self::check_domain($val_s);
				}
			}
		}
	}
	
	//http_post
	public function http_post($url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,5);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		}else {
			$error = curl_errno($ch);
			curl_close($ch);
			return false;
		}
	}
	
	//curl post请求
	public function curl_post($url,$post_data){
		//初始化
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, $url);
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, 1);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//设置post方式提交
		curl_setopt($curl, CURLOPT_POST, 1);
		//设置post数据
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
		//执行命令
		$data = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		//显示获得的数据
		var_dump($data);
	}
	
	//微信域名检测宝盒接口
	public function check_domain($info){
		if(!$info){return;}
		$user = "293047b";
		$key = "4f187f5f2ce23ed2b7754d8d54b8f1f3";
		$forbbiden = array();
		$d3d4arr = array("d3"=>$info['d3'],"d4"=>$info['d4']);	
		$banArr = [];
		foreach ($d3d4arr as $k=>$v){				
			sleep(1);
			$api_url = "http://vip.weixin139.com/weixin/wx_domain.php?user=$user&key=$key&domain=".$v;
			$content = $this->http_post($api_url);
			$data = json_decode($content,true);
			if($data['status']==2){ //域名被封
				$banArr[] = $k;
			}
		}	
		if(count($banArr)>1){ //直接停用服务器,直接停用服务器，并且更换自动监控的落地域名，跳到另一台服务器上。
			$allarr = array(
					'd3'=>$info['d3'].'---封',
					'd4'=>$info['d4'].'---封',
					'is_active'=>2,
					'update_time'=>time(),
			);
			//获取当前案例自动模式的服务器
			$auto_server = db ( 'server' )->where ( "d1_model=2 and line_id={$info['line_id']}")->find ();		
			if($auto_server['d1']!=$info['d1']){				
				db ( 'server' )->where ( "id", '=', $info['id'] )->update ($allarr);		
			}else{ //更换落地域名跳到新服务器上				
				$randldarr = $this->randldym($info);		
				$otherdata =array(
						'd1'=>$randldarr,
						'update_time'=>time(),
				);
				db ( 'server' )->where ( "d1_model=2 and line_id={$info['line_id']}")->update($otherdata);	
				$allarr = array(
						'd3'=>$info['d3'].'---封',
						'd4'=>$info['d4'].'---封',
						'update_time'=>time(),
				);
				db ( 'server' )->where ( "id", '=', $info['id'] )->update ($allarr);		
			}
		}else{
			if($banArr){
			if($banArr[0]=='d3'){ //d3被封
				$d3NewArr = array(
						//'d2'=>'',
						'd3'=>$info['d2'],
						'update_time'=>time(),
				);
				db ( 'server' )->where ( "id", '=', $info['id'] )->update ($d3NewArr);
				//发送短信通知
				$filename = 'forbbiden/' . $info['d3']. '.txt';
				if(!file_exists($filename)){
					file_put_contents($filename,$info['d3']);
					$type = 'd3';
					$this->send_sms($type,$info);
				}
			}elseif ($banArr[0]=='d4'){//d4被封
				$d4NewArr = array(
						//'d2'=>'',
						'd4'=>$info['d2'],
						'update_time'=>time(),
				);
				db ( 'server' )->where ( "id", '=', $info['id'] )->update ($d4NewArr);
				//发送短信通知
				$filename = 'forbbiden/' . $info['d4']. '.txt';
				if(!file_exists($filename)){
					file_put_contents($filename,$info['d4']);
					$type = 'd4';
					$this->send_sms($type,$info);
				}
			}
			}
		}
		
	}
	
	//获取随机落地域名
	public function randldym($info){
		$where = "line_id = {$info['line_id']} and status=1";	//状态，1可用，2不可用
		$luodi_domain = db ( 'luodi' )->where ($where)->field('domain,line_id,status')->select ();
		$tmpArr = array();
		if($luodi_domain){
			foreach ($luodi_domain as $key=>$val){
				$tmpArr[] = $val['domain'];
			}
			$randkey = array_rand($tmpArr); //新的随机落地域名
			$randdomain = $tmpArr[$randkey];
			db ( 'luodi' )->where ( "domain", '=', $randdomain)->update ( array('status'=>2,'update_time'=>time()) );		
			return $randdomain;
	 }
	}
	
	//短信通知
	public function send_sms($type,$info){
		if($type&&!$info){
			return;
		}	
		#=====================远程同步数据
		$remote_url = "http://{$info['public_ip']}/sync.php";
		$server_data = db ( 'server' )->where ( 'id', $info ['id'] )->find ();
		if ($server_data) {
			if($server_data['update_time'])$server_data['update_time'] = date('Y-m-d H:i:s',time());
			$server_data['is_sync'] = 0;//是否同步,可去掉
		}
		$post_data = array("data"=>$server_data);
		$this->curl_post($remote_url,$post_data);
		#=====================发送短信通知
		$sharedomain1 = $info[$type];
		$sharedomain2 = $info['d2'];		
		$content = "【来自火星的运维】您的分享服务器<{$info['line_name']}-{$info['name']}>域名{$sharedomain1}被封，现切换到备用域名<{$sharedomain2}>成功！";
		require  './lib/SUBMAIL_PHP_SDK-master/app_config.php';
		require_once './lib/SUBMAIL_PHP_SDK-master/SUBMAILAutoload.php';
		#1条API请求发送多个号码,建议:单线程提交数量控制在50个联系人, 可以开多个线程同时发送
		$submail=new \MESSAGEMultiSend($message_configs);
		$mobile_list = db ( 'mobile' )->where ("id>0")->field('id,name')->limit(50)->select ();
		if($mobile_list){
			foreach ($mobile_list as $key=>$val){
				$contacts[] = $val['name'];
			}
			foreach($contacts as $contact){
				$multi=new \Multi();
				$multi->setTo($contact);
				$submail->addMulti($multi->build());
			}
			$submail->SetContent($content);
			$result = $submail->multisend();
			echo '<pre>';
			var_dump($result);
			echo '</pre>';
		}
	}
}