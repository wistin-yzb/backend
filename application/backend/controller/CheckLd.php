<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class CheckLd extends controller {
	public function __construct() {
	}
	
	//监听落地域名的自动切换
	public function index() {
		/*
		 * 解析:从数据库获取要监听的落地落地模式为自动的落地域名
		 * 如果当前被监听的落地域名被封，则从备用落地域名列表随机获取可使用的一个域名作为替换
		 */
		$linelist = db ( 'line' )->where ("status",1)->field('id,name')->select ();		
		if($linelist){	
			$lineids = []; 
			foreach ($linelist as $key=>$val){
				$lineids[] = $val['id'];
			}		
			$lineidsstr = implode(',', $lineids);
			$where = "s.is_active=1 and s.d1_model=2 and s.line_id in ($lineidsstr)"; //对已启用的落地模式为自动的服务器进行监听
			$serverlist = db ( 'server' )->alias('s')->where ($where)->field('s.id,s.name,l.name as line_name,s.d1,s.public_ip,s.line_id')->join('line l','s.line_id = l.id')->select ();						
			
			if($serverlist){
				foreach ($serverlist as $key_s=>$val_s){				 	
				 	//查询指定域名列表是否被封
					self::check_domain($val_s);
				 }
			}
		}
	}
	
	//微信域名检测宝盒接口
	public function check_domain($info){
		if(!$info){return;}
		$user = "293047b";
		$key = "4f187f5f2ce23ed2b7754d8d54b8f1f3";
		$forbbiden = array();
		
		$api_url = "http://vip.weixin139.com/weixin/wx_domain.php?user=$user&key=$key&domain=".$info['d1'];
		$content = $this->http_post($api_url);
		$data = json_decode($content,true);
		if($data['status']==2){ //域名被封
			$filename = "forbbiden/{$info['d1']}.txt";
			if(!file_exists($filename)){
				file_put_contents($filename,$info['d1']);
				$this->send_sms($info);
			}
		}else{
			var_dump ( 'luodi domain is ok!' );
			exit ();
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
	public function send_sms($info){
		if(!$info){
			return;
		}
		$where = "line_id = {$info['line_id']} and status=1";	//状态，1可用，2不可用
		$luodi_domain = db ( 'luodi' )->where ($where)->field('domain,line_id,status')->select ();
		$tmpArr = array();
		if($luodi_domain){
			foreach ($luodi_domain as $key=>$val){
				$tmpArr[] = $val['domain'];
			}
			$randkey = array_rand($tmpArr); //新的随机落地域名
			$randdomain = $tmpArr[$randkey];
			$remainnum = count($tmpArr)-1;//剩余备用落地域名个数
						
			//更新当前服务器落地域名,并且更新落地域名状态
			db ( 'luodi' )->where ($where)->field('domain,line_id,status')->select ();
			db ( 'server' )->where ( "id", '=', $info['id'] )->update ( array('d1'=>$randdomain) );
			db ( 'luodi' )->where ( "domain", '=', $randdomain)->update ( array('status'=>2,'update_time'=>time()) );
			
			$content = "【来自火星的运维】您好，您的服务器<<{$info['line_name']}-{$info['name']}>>落地域名<<{$info['d1']}>>被封禁，现自动切换到<<$randdomain>>成功！剩余备用域名{$remainnum}个.";			
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
			//$contacts=array("15812454795");
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
	
}