<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Luodi extends controller {
	public function __construct() {
		action ( 'Common/checkSession' );
	}
	
	public function  luodi_list(){
		$post = input ( 'post.' );
		$n = input('get.n')?input('get.n'):input('post.n');
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`domain` like '%$keywords%' )";
		}
		$list = db ( 'luodi' )->where ( $where )->order('id','desc')->select ();
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
		return $view->fetch ( 'luodi/luodi_list' );
	}
	
	public function  luodi_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'luodi' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'domain' => '',
					'remark' => '',
					'ip' => '',
					'status' => 1,
			];
			$view->info = $info;
		}
		return $view->fetch ( 'luodi/luodi_add' );
	}
	
	public function luodi_submit() {
		$post = input ( 'post.' );
		$data = [
				"domain" => $post ['domain'],
				"remark" => $post ['remark'],
				"ip" => $post ['ip'],
				"status" => $post ['status'],
				"update_time" => time ()
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'luodi' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'luodi' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function luodi_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'luodi' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}