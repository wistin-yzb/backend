<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Mobile extends controller {
	public function __construct() {
		action ( 'Common/checkSession' );
	}
	
	/**
	 * 手机号分组列表
	 */
	public  function  group_list(){
		$post = input ( 'post.' );		
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'mobile_group' )->where ( $where )->order('id','desc')->select ();
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
		return $view->fetch ( 'mobile/group_list' );
	}
	
	public function  group_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'mobile_group' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'name'=>'',
					'sort' => '',
					'desc' => '',
			];
			$view->info = $info;
		}
		return $view->fetch ( 'mobile/group_add' );
	}
	
	public function group_submit() {
		$post = input ( 'post.' );		
		$data = [
				"name" => $post ['name'],
				"desc" => $post ['desc'],
				"sort" => $post ['sort'],
				"update_time"=>time(),
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'mobile_group' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'mobile_group' )->where ( "name", '=', trim($post ['name']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
			$ret = db ( 'mobile_group' )->insert ( $data );
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
		$ret = db ( 'mobile_group' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	/**
	 * 手机号列表
	 */
	public function mobile_list(){
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'mobile' )->where ( $where )->order('id','desc')->select ();
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
		return $view->fetch ( 'mobile/mobile_list' );
	}
	
	public function  mobile_add(){
		$id = input ( 'get.id' );
		$view = new View ();
		$group_list = db ( 'mobile_group' )->field('id as group_id,name as group_name')->order ( 'id desc' )->select ();		
		if ($id > 0) {
			$info = db ( 'mobile' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					'name'=>'',					
					'desc' => '',
					'group_id' => '',
					'group_name' => '',
			];
			$view->info = $info;
		}
		if($group_list){
			foreach ($group_list as $key=>$val){
				if(in_array($val['group_id'], explode(',', $info['group_id']))){
					$group_list[$key]['is_checked'] = true;
				}else{
					$group_list[$key]['is_checked'] = false;
				}
			}
		}
		
		$view->group_list= $group_list;
		return $view->fetch ( 'mobile/mobile_add' );
	}
	
	public function mobile_submit() {
		$post = input ( 'post.' );		
		$group_info =$post['group_info'];
		if($group_info){
			$group_id = [];
			$group_name = [];
			foreach ($group_info as $key=>$val){
				$tmp = explode('-', $val);
				$group_id[] = $tmp[0];
				$group_name[] = $tmp[1];
			}
		}
		$data = [
				"name" => $post ['name'],
				"desc" => $post ['desc'],
				"group_id" => implode(',', $group_id),
				"group_name" => implode(',',$group_name),
				"update_time"=>time(),
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'mobile' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'mobile' )->where ( "name", '=', trim($post ['name']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
			$ret = db ( 'mobile' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function mobile_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'mobile' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}