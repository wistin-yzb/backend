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
		$line_id = input('get.line_id');
		$is_active = @$post ['is_active'] ? trim ( @$post ['is_active'] ) : 0;
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($is_active!=0) {
			$where .= "and (`is_active`=$is_active)";
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
		$view->line_id = $line_id;
		$view->is_active = $is_active;
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
					'line_id'=>input ( 'get.line_id' ),
					'sort' => '',
					'desc' => '',
					'app_id' => '',
					'app_secret' => '',
					'public_ip' => '',
					'private_ip' => '',
					'baidu_id'=>'',
					'back_url'=>'',
					'd1_model'=>1,
					'd1'=>'',
					'd2'=>'',
					'd3'=>'',
					'd4'=>'',
					'd5'=>'',
			];
			$view->info = $info;
		}
		return $view->fetch ( 'server/server_add' );
	}
	
	public function server_submit() {
		$post = input ( 'post.' );
		$data = [
				"name" => $post ['name'],
				"line_id" => $post ['line_id'],
				"sort" => $post ['sort'],
				"desc" => $post ['desc'],
				"app_id" => $post ['app_id'],
				"app_secret" => $post ['app_secret'],
				"public_ip" => $post ['public_ip'],
				"private_ip" => $post ['private_ip'],
				"baidu_id" => $post ['baidu_id'],
				"back_url" => $post ['back_url'],
				"d1_model" => $post ['d1_model'],
				"d1" => $post ['d1'],
				"d2" => $post ['d2'],
				"d3" => $post ['d3'],
				"d4" => $post ['d4'],
				"d5" => $post ['d5'],
				"is_active" => 1,
				"update_time" => time ()
		];		
		//控制落地模式只能有一个为自动模式
		if($post ['d1_model']==2){
			 db ( 'server' )->where ( "d1_model", '=', 2)->update ( array('d1_model'=>1) );
		}
		if ($post ['id'] > 0) {
			$ret = db ( 'server' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'server' )->where ( "name", '=', trim($post ['name']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
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
				'is_active' => $post ['is_active']
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function  server_info(){
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'server' )->where ( 'id', $post ['id'] )->find ();
		if ($ret) {
			if($ret['update_time'])$ret['update_time'] = date('Y-m-d H:i:s',time());
			$ret['is_sync'] = 0;//是否同步,可去掉
			exit ( json_encode ( $ret) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
}