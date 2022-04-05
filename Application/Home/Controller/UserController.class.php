<?php
namespace Home\Controller;

use Think\Controller;
class UserController extends BaseController {
	
    /**
     * 用户注册
     * @return [type] [description]
     */
    public function sign() {
        
        //校验参数
        if(!$_POST['username']) {

            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：username';

            $this->ajaxReturn($return_data);
        }

        if(!$_POST['phone']) {
            
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：phone';

            $this->ajaxReturn($return_data);
        }

        if(!$_POST['password']) {
            
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password';

            $this->ajaxReturn($return_data);
        }

        if(!$_POST['password_again']) {
            
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password_again';

            $this->ajaxReturn($return_data);
        }

        //检验两次密码是否一致
        if($_POST['password'] != $_POST['password_again']){
            
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致';

            $this->ajaxReturn($return_data);
        }

        //检验手机号是否已经注册
        $User = M('user');
        //构造查询条件
        $where = array();
        $where['phone'] = $_POST['phone'];

        $user = $User->where($where)->find();

        if($user){

            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '手机号已被注册';

            $this->ajaxReturn($return_data);
        }else{

            $data = array();
            $data['username'] = $_POST['username'];
            $data['phone'] = $_POST['phone'];
            $data['password'] = md5($_POST['password']);
            $data['face_url'] = $_POST['face_url'];

            dump($data);

            //插入数据
            $result = $User->add($data);

            if($result) {

                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '注册成功';
                $return_data['data']['user_id'] = $result;
                $return_data['data']['username'] = $_POST['username'];
                $return_data['data']['phone'] = $_POST['phone'];
                $return_data['data']['face_url'] = $_POST['face_url'];

                $this->ajaxReturn($return_data);
                
            }else {

                $return_data = array();
                $return_data['error_code'] = 4;
                $return_data['msg'] = '注册失败';

                $this->ajaxReturn($return_data);
            }
        }

        //dump($_POST);
    }

    /**
     * 用户登录
     * @return [type] [description]
     */
    public function login() {
        
        //校验参数是否存在
        if(!$_POST['phone']) {

            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：phone';

            $this->ajaxReturn($return_data);
        }

        if(!$_POST['password']) {

            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password';

            $this->ajaxReturn($return_data);
        }

        $User = M('user');

        $where = array();
        $where['phone'] = $_POST['phone'];

        $user = $User->where($where)->find();

        if($user) {

            //如果存在
            // dump($user);
            if(md5($_POST['password']) != $user['password']) {

                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '密码错误';

                $this->ajaxReturn($return_data);
            }else {

                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';

                $return_data['data']['user_id'] = $user['id'];
                $return_data['data']['username'] = $user['username'];
                $return_data['data']['phone'] = $user['phone'];
                $return_data['data']['face_url'] = $user['face_url'];

                $this->ajaxReturn($return_data);
            }
        }else {
            
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '不存在该手机号用户';

            $this->ajaxReturn($return_data);
        }

        dump($_POST);
    }
}