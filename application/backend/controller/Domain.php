<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Domain extends controller {
	public function __construct() {
		action ( 'Common/checkSession' );
	}
	
	/**
	 * 域名分组列表
	 */
	public  function  group_list(){
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'domain_group' )->where ( $where )->order('id','desc')->select ();
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
		return $view->fetch ( 'domain/group_list' );
	}
	
	public function  group_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'domain_group' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'name'=>'',
					'desc' => '',
					'sort' => '',
					'mobile_group_id' => '',
					'mobile_group_name' => '',
			];
			$view->info = $info;
		}
		$group_list = db ( 'mobile_group' )->field('id as group_id,name as group_name')->order ( 'id desc' )->select ();		
		$view->group_list = $group_list; 
		return $view->fetch ( 'domain/group_add' );
	}
	
	public function group_submit() {
		$post = input ( 'post.' );				
		$mobile_group_arr = explode('-', $post['mobile_group_info']);
		$data = [
				"name" => $post ['name'],
				"desc" => $post ['desc'],
				"sort" => $post ['sort'],
				"mobile_group_id" => $mobile_group_arr[0],
				"mobile_group_name" => $mobile_group_arr[1],
				"update_time"=>time(),
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'domain_group' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'domain_group' )->where ( "name", '=', trim($post ['name']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
			$ret = db ( 'domain_group' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function group_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'domain_group' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	/**
	 * 域名列表
	 */
	public function domain_list(){
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'domain' )->where ( $where )->order('id','desc')->select ();
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
		return $view->fetch ( 'domain/domain_list' );
	}
	
	public function  domain_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		$group_list = db ( 'domain_group' )->field('id as group_id,name as group_name')->order ( 'id desc' )->select ();
		
		if ($id > 0) {
			$info = db ( 'domain' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'name'=>'',
					'desc' => '',
					'relate_ip' => '',
					'group_id' => '',
					'group_name' => '',
					'is_ban' => 2, //是否被封，1是，2否
			];
			$view->info = $info;
		}
		
		$view->group_list= $group_list;
		return $view->fetch ( 'domain/domain_add' );
	}
	
	public function domain_submit() {
		$post = input ( 'post.' );		
		$group_info_arr =explode('-', $post['group_info']);		
		$data = [
				"name" => $post ['name'],
				"desc" => $post ['desc'],
				"relate_ip" => $post ['relate_ip'],
				"is_ban" => $post ['is_ban'],
				"group_id" => $group_info_arr[0],
				"group_name" => $group_info_arr[1],
				"update_time"=>time(),
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'domain' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			//核查该域名是否已经存在
			$is_exists = db ( 'domain' )->where ( "name", '=', trim($post ['name']))->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
			$ret = db ( 'domain' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function domain_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'domain' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
}