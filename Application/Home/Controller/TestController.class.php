<?php
namespace Home\Controller;

use Think\Controller;
class TestController extends BaseController {
	
    public function test() {
        echo 123;
    }

    public function insert_test() {
        
        //实例化数据表
        $Message = M('message');

        //组装数组
        $data = array();
        $data['user_id'] = 1;
        $data['username'] = 'chsan';
        $data['face_url'] = 'xxx.jpg';
        $data['content'] = 'bushuai!';
        $data['total_likes'] = 0;
        $data['send_timestamp'] = time();

        //插入数据
        $result = $Message->add($data);

        var_dump($result);

        var_dump($Message->getLastSql());
    }




    public function select_test() {

        //实例化数据表
        $Message = M('message');

        $where = array();
        $where['user_id'] = 1;

        $all_message = $Message->where($where)->select();

        dump($all_message);

        $all_message = $Message->where($where)
                ->field('id,username')->select();

        dump($all_message);

    }

    public function find_test() {

        $Message = M('message');

        $where = array();
        $where['user_id'] = 1;

        $all_message = $Message->where($where)->find();

        var_dump($all_message);

        var_dump($Message->getLastSql());
    }

    public function save_test() {

        $Message = M('message');

        $where = array();
        $where['id'] = 1;

        $data = array();
        $data['totallike'] = 1;

        $result = $Message->where($where)->save($data);

        dump($result);


    }

    public function delete_test() {

        $Message = M('message');

        $where = array();
        $where['id'] = 1;

        $result = $Message->where($where)->delete();

        dump($result);
    }

}