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
		$line_id = input('line_id');
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`domain` like '%$keywords%' )";
		}
		if($line_id){
			$where .= "and (`line_id` =$line_id)";
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
		$view->line_id = $line_id;
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
					'line_id'=>input ( 'get.line_id' ),
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
				"line_id" => $post ['line_id'],
				"remark" => $post ['remark'],
				"ip" => $post ['ip'],
				"status" => $post ['status'],
				"update_time" => time ()
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'luodi' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'luodi' )->where ( "domain", '=', trim($post ['domain']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
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