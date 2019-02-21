<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class All extends controller {
	public function __construct() {
	}
	
	//统计合集
	public function index(){
		$where = "id>0 and status=1";
		$list = db ( 'line' )->where ( $where )->field('id,name,state_ip')->order('id','desc')->select ();
		$jsondata = [];
		if($list){			
			foreach ($list as $key=>$val){				
				$json = @file_get_contents("http://{$val['state_ip']}/r.txt");
				if ($json != '') {
					$arr = json_decode($json, true);
				} else {
					$arr = array();
				}
				if (!isset($arr['timeline']) || !isset($arr['friend'])) {
					$sum1 = $sum2 = 0;
				} else {
					$sum1 = $arr['timeline'][0];
					$sum2 = $arr['friend'][0];
				}
				$arr2 = array(
						"name"=>$val['name'],
						"state_ip"=>$val['state_ip'],
						"timeline"=>$sum1,
						"friend"=>$sum2
				);
				$jsondata[] = $arr2;
			}
		}		
		$view = new View ();				
		$view->jsonlist = $jsondata;
		return $view->fetch ( 'all/index' );
	}
}