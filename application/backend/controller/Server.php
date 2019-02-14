<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Server extends controller {
	public function __construct() {
		action ( 'Common/checkSession' );
	}
	
	public function  server_list(){
		$post = input ( 'post.' );
		$n = input('get.n')?input('get.n'):input('post.n');
		$status = @$post ['status'] ? trim ( @$post ['status'] ) : 0;
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($status!=0) {
			$where .= "and (`status`=$status)";
		}
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'server' )->where ( $where )->order('id','desc')->select ();
		if ($list) {
			foreach ( $list as $key => $val ) {
				if ($val ['update_time'])
					$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
			}
		}
		$view->list = $list;
		$filter = [
				'keywords' => $keywords,
				'total' => count ( $list )
		];
		$view->filter = $filter;
		$view->n = $n;
		$view->status = $status;
		return $view->fetch ( 'server/server_list' );
	}
	
	public function server_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'server' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'name' => '',
					'sort' => '',
					'remark' => '',
					'appId' => '',
					'appSecret' => '',
					'public_ip' => '',
					'inner_ip' => '',
					'baidu_id'=>'',
					'back_url'=>'',
					'model'=>1,
					'domain1'=>'',
					'domain2'=>'',
					'domain3'=>'',
					'domain4'=>'',
					'domain5'=>'',
			];
			$view->info = $info;
		}
		return $view->fetch ( 'server/server_add' );
	}
	
	public function server_submit() {
		$post = input ( 'post.' );
		$data = [
				"name" => $post ['name'],
				"sort" => $post ['sort'],
				"remark" => $post ['remark'],
				"appId" => $post ['appId'],
				"appSecret" => $post ['appSecret'],
				"public_ip" => $post ['public_ip'],
				"inner_ip" => $post ['inner_ip'],
				"baidu_id" => $post ['baidu_id'],
				"back_url" => $post ['back_url'],
				"model" => $post ['model'],
				"domain1" => $post ['domain1'],
				"domain2" => $post ['domain2'],
				"domain3" => $post ['domain3'],
				"domain4" => $post ['domain4'],
				"domain5" => $post ['domain5'],
				"status" => 1,
				"update_time" => time ()
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'server' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'server' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'server' )->where ( 'id', $post ['id'] )->update ( [
				'status' => $post ['status']
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}