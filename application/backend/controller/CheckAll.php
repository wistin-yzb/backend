<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class CheckAll extends controller {
	public function __construct() {
	}
	
	//监听所有域名列表是否被封，被封则短信通知相关人员
	public function index() {
		//获取所有未被封的域名
		$domainlist = db ( 'domain' )->where ("is_ban",2)->field('*')->select ();		
		//查询在线域名列表是否存在被封
		if($domainlist){
			foreach ($domainlist as $key_d=>$val_d){
				sleep(1); //挂起1s
				self::check_domain($val_d['name']);
			}
		}
	}
	
	//微信域名检测宝盒接口
	public function check_domain($domain){
		if(!$domain){return;}
		$user = "293047b";
		$key = "4f187f5f2ce23ed2b7754d8d54b8f1f3";
		$forbbiden = array();		
		$api_url = "http://vip.weixin139.com/weixin/wx_domain.php?user=$user&key=$key&domain=".$domain;
		$content = $this->http_post($api_url);
		$data = json_decode($content,true);
		if($data['status']==2){ //域名被封
			$filename = "forbbiden/{$domain}.txt";
			if(!file_exists($filename)){
				file_put_contents($filename,$domain);
				$this->send_sms($domain);
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
		
	//短信通知
	public function send_sms($domain){
		if(!$domain){
			return;
		}
		#======================更新该域名已经被封
		db ( 'domain' )->where ( "name", '=', $domain)->update ( array('is_ban'=>1,'update_time'=>time()) );
		#======================发送短信通知
		$content = "【来自火星的运维】您好，您的服务器{$domain}(域名)已经被封禁！";
		require  './lib/SUBMAIL_PHP_SDK-master/app_config.php';
		require_once './lib/SUBMAIL_PHP_SDK-master/SUBMAILAutoload.php';				
		#1条API请求发送单个号码
		/* $submessage  =new \MESSAGEsend($message_configs);
		 $submessage->setTo('15812454795');
		 $submessage->SetContent($content);
		 $result =$submessage->send(); */		
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
	    #======================End
	}
	
}