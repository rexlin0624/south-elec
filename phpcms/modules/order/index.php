<?php
/**
 * 购物车，订单类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index  {
    private function _session_start() {

        $session_storage = 'session_'.pc_base::load_config('system','session_storage');

        pc_base::load_sys_class($session_storage);

    }

    /**
     * 查询是否登录y用户
     * @return null
     */
    private function return_memeberid(){
        $phpcms_auth = param::get_cookie('auth');
        if (!empty($phpcms_auth)) {
            $auth_key = $auth_key = get_auth_key('login');
            $memberid = explode("\t", sys_auth($phpcms_auth, 'DECODE', $auth_key))[0];
            return $memberid;
        } else {
            $member_model = pc_base::load_model('member_model');
            $newTel = isset($_POST['values']['newTel']) ? $_POST['values']['newTel'] : '';
            $user = $member_model->get_one(array('username' => $newTel));
            if (empty($user) && !empty($newTel)) {
                $encrypt = create_randomstr(6);
                $password = create_randomstr(8);

                $userinfo = array();
                $userinfo['encrypt'] = $encrypt;
                $userinfo['username'] = $newTel;
                $userinfo['nickname'] = '';
                $userinfo['email'] = '';
                $userinfo['password'] = md5($password);
                $userinfo['modelid'] = 10;
                $userinfo['regip'] = ip();
                $userinfo['point'] = 0;
                $userinfo['amount'] = 0;
                $userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
                $userinfo['siteid'] = 1;
                $userinfo['connectid'] = isset($_SESSION['connectid']) ? $_SESSION['connectid'] : '';
                $userinfo['from'] = isset($_SESSION['from']) ? $_SESSION['from'] : '';
                $userinfo['mobile'] = $newTel;
                $member_model->insert($userinfo);
                return $member_model->insert_id();
            } else {
                return $user['userid'];
            }
        }
    }

    //添加购物车
    public function join_cart(){
        $this->_session_start();
        $session_id = session_id();
        $cart_model = pc_base::load_model('cart_model');
      /*  $this->db = pc_base::load_model('member_model');*/
        $goodsid=(int)$_POST['goodsid'];
        $number=(int)$_POST['number'];
        $issale=$_POST['issale'];
        $province=$_POST['province'];
        $city=$_POST['city'];
        $district=$_POST['district'];
        $istrue = (int)$_GET['istrue'];
//        var_dump($province.'+'.$city.'+'.$district);
        $memberid=$this->return_memeberid();
         $where =array('member_id' => $memberid,'goods_issale' => $issale,'goods_id' => $goodsid);
         if ($istrue) {
             $where['session_id'] = $session_id;
         }
        $isrepeat=$cart_model->get_one($where);
        //等于null新增一条数据
        if ($isrepeat==null) {
            $cartval = array(
                'goods_issale'  => $issale,
                'member_id'     => $memberid,
                'goods_id'      => $goodsid,
                'goods_count'   => $number,
                'province'      => $province,
                'city'          => $city,
                'district'      => $district,
                'istrue'        => $istrue,
            );
            if ($istrue) {
                $cartval['session_id'] = $session_id;
            }
            $cart_model->insert($cartval);
        }else{
            if ($istrue) {
                $goods_count = 1;
            } else {
                $goods_count = $isrepeat['goods_count'] + $number;
            }

            //增加对应的数量
            $cart_model->update(array('goods_count' => $goods_count, 'istrue' => $istrue), $where);
        }
    }


    /**
     * 购物车页面数量加减和删除一个产品
     */
    public function  action_goods(){
        $this->_session_start();
        $cart_model = pc_base::load_model('cart_model');
        $memberid=$this->return_memeberid();
        $stuts=$_POST['stuts'];
        $goodsid=$_POST['goodsid'];
        $issale=$_POST['issale'];
        $goodscount=$_POST['goodscount'];
        if($memberid!=null){
            $where =array('member_id'=>$memberid,'goods_issale'=>$issale,'goods_id'=>$goodsid);
        }else{
            $where =array('session_id'=>session_id(),'goods_issale'=>$issale,'goods_id'=>$goodsid);
        }
        $cartval=$cart_model->get_one($where);
        if($cartval!=null) {
            if ($stuts == 'aod') {
                $cart_model->update(array('goods_count' => $goodscount), $where);
            } else {
                $cart_model->delete($where);
            }
        }
        $this->cart_detail();
    }

    /**
     * 查询购物车页面页面
     */
    public function cart_detail() {
        $this->_session_start();
        $cart_model = pc_base::load_model('cart_model');
        $memberid=$this->return_memeberid();
        if (empty($memberid)) {
            $forward= isset($_GET['forward']) ?  urlencode($_GET['forward']) : urlencode(get_url());
            showmessage(L('please_login', '', 'member'), 'index.php?m=member&c=index&a=login&forward='.$forward);
        }

        $cart_model->update(array('istrue' => 0), array('member_id' => $memberid));
        $cart= $cart_model->query("select c.session_id,c.member_id,c.goods_id,c.goods_count,g.title,g.thumb,gd.goods_type,gd.price,gd.is_sale from lldz_cart c
LEFT JOIN lldz_lldz_goods g ON g.id=c.goods_id
LEFT JOIN lldz_lldz_goods_data gd ON gd.id=g.id where  c.member_id ='$memberid'");
        $cart=$cart_model->fetch_array();
        include template('member', 'shopping_cart');
    }

    /**
     * 选中修改数据库选中状态
     */
    public  function  editistrue(){
        $this->_session_start();
        $cart_model = pc_base::load_model('cart_model');
        $memberid=$this->return_memeberid();
        $checkboxval=$_POST['checkboxval'];
        if ($memberid!=null||$memberid!='') {
            foreach($checkboxval as $value) {
                $cart_model->update(array('istrue' => 1), array('member_id' => $memberid, 'goods_id' =>$value));
            }
        }else{
            $session_id=session_id();
            foreach($checkboxval as $value) {
                $cart_model->update(array('istrue' => 1), array('session_id' => $session_id, 'goods_id' =>$value));
            }
        }
    }

    /**
     * 生成订单
     */
    public  function  order_detail(){
        $this->_session_start();
        $cart_model = pc_base::load_model('cart_model');
        $order_model = pc_base::load_model('order_model');
        $member_adress_model=pc_base::load_model("member_address_model");
        $memberid=$this->return_memeberid();
        if ($memberid!=null||$memberid!='') {
            $addressval=$member_adress_model->get_one("member_id = '$memberid'");
            $cart= $cart_model->query("select  g.id,c.goods_count,g.title,g.url,g.thumb,gd.price,gd.is_sale from lldz_cart c
LEFT JOIN lldz_lldz_goods g ON g.id=c.goods_id
LEFT JOIN lldz_lldz_goods_data gd ON gd.id=g.id where c.member_id ='$memberid' and c.istrue=1");
        }else{
            $session_id=session_id();
//            $addressval=$member_adress_model->get_one(Array('session_id'=>$session_id));
            $cart= $cart_model->query("select g.id,c.goods_count,g.title,g.url,g.thumb,gd.price,gd.is_sale from lldz_cart c
LEFT JOIN lldz_lldz_goods g ON g.id=c.goods_id
LEFT JOIN lldz_lldz_goods_data gd ON gd.id=g.id where c.session_id ='$session_id' and c.istrue=1");
        }
//        $addressval=$member_adress_model->fetch_array();
        $order=$order_model->fetch_array();
        include template('member', 'settlement');
    }



    /**
     * 收货地址
     */
    public function memberaddres(){
        $this->_session_start();
        $memberid=$this->return_memeberid();
        $member_adress_model=pc_base::load_model("member_address_model");
        //ajax提交过来的数据
        $values=$_POST['values'];
        $insertval=array(
            'member_id'=>$memberid,
            'name'=>$values['newConsignee'],
            'phone'=>$values['newTel'],
            'province'=>$values['newProvince'],
            'city'=>$values['newCity'],
            'district'=>$values['newCounty'],
            'street'=>$values['newStreet'],
            'address'=>$values['newTag'],
            'postcode'=>$values['newZipcode'],
            'session_id'=>session_id(),
            );
//        var_dump($insertval);
        if($memberid!=null||$memberid!='') {
            if($member_adress_model->get_one("member_id = '$memberid'")!=null){
                $member_adress_model->update($insertval,"member_id = '$memberid'");
            }else{
                $member_adress_model->insert($insertval);
            }
        }else{
            if($member_adress_model->get_one(Array('session_id'=>session_id()))!=null){
                $member_adress_model->update($insertval,Array('session_id'=>session_id()));
            }else{
                $member_adress_model->insert($insertval);
//                var_dump($insertval);
            }
        }
    }

    /**
     * 获取用户地址
     */
    public function address_list() {
        $this->_session_start();
        $memberid = $this->return_memeberid();
        $memberid = 9;
        if (empty($memberid)) {
            echo json_encode(array());
            exit;
        }
        $member_adress_model = pc_base::load_model("member_address_model");
        $address = $member_adress_model->select('member_id = ' . $memberid);
        echo json_encode($address);
        exit;
    }

    public function public_send_sms() {
        $sms_content_db = pc_base::load_model('sms_content_model');
        $telephone =$_POST['telephone'];

        // 判断1分钟内是否重复请求发短信
        $sms = $sms_content_db->get_one(array('telephone'=>$telephone),'created_at');
        if ($sms['created_at'] + 60 > time()) {
            echo json_encode(array('status' => 0, 'message' => '短信发送太过频繁'));
            exit;
        }

        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIQ2fGhGt5Ugrx";
        $accessKeySecret = "UUXAvJyom423KHFUf5C2uvxSRLMT3l";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $telephone;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "邓主平精品脐橙";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_101135009";

        $code = random(6);

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $code,
        );

        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"]);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
//        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $this->sms_sign->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        $sms_content = array(
            'type'          => 0,
            'telephone'     => $telephone,
            'code'          => $code,
            'created_at'    => time(),
        );
        $sms_content_db->insert($sms_content);

        var_export($content);
    }
}
?>