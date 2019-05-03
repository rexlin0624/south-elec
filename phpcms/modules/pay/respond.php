<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
class respond {
	
	private $pay_db, $account_db,$member_db;
    private $sms_sign;
	
	function __construct() {
		pc_base::load_app_func('global');
        $this->sms_sign = pc_base::load_sys_class('ali_sms_sign');
	}
	
	/**
	 * return_url get形式响应
	 */
	public function respond_get() {
		if ($_GET['code']){
			$payment = $this->get_by_code($_GET['code']);
			if(!$payment) showmessage(L('payment_failed'));
			$cfg = unserialize_config($payment['config']);
			$pay_name = ucwords($payment['pay_code']);
			pc_base::load_app_class('pay_factory','',0);
			$payment_handler = new pay_factory($pay_name, $cfg);
			$return_data = $payment_handler->receive();
			if($return_data) {
				if($return_data['order_status'] == 0) {				
					$this->update_member_amount_by_sn($return_data['order_id']);
				}
				$this->update_recode_status_by_sn($return_data['order_id'],$return_data['order_status']);
//				showmessage(L('pay_success'),APP_PATH.'index.php?m=pay&c=deposit');
				showmessage(L('pay_success'),APP_PATH);
			} else {
//				showmessage(L('pay_failed'),APP_PATH.'index.php?m=pay&c=deposit');
                showmessage(L('pay_success'),APP_PATH);
			}
		} else {
			showmessage(L('pay_success'));
		}
	}

    /**
     * 发送手机短信
     */
    private function _send_sms($telephone, $message) {
        $sms_content_db = pc_base::load_model('sms_content_model');

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
        $params["SignName"] = "威旗360全景";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_120120030";

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
            'message'       => $message,
            'created_at'    => time(),
        );
        $sms_content_db->insert($sms_content);
    }

	/**
	 * 服务器端 POST形式响应
	 */
	public function respond_post() {
        file_put_contents(PHPCMS_PATH . 'phpcms/modules/pay/debug.log', var_export($_REQUEST, true) . "\r\n\r\n", FILE_APPEND);
		$_POST['code'] = $_POST['code'] ? $_POST['code'] : $_GET['code'];
		if ($_POST['code']){
		    if ($_POST['code'] == 'wechat') {
		        $out_trade_no = $_POST['out_trade_no'];
                $this->update_order_status_by_sn($out_trade_no, 1);
            } else {
                $payment = $this->get_by_code($_POST['code']);
                if (!$payment) {
                    error_log(date('m-d H:i:s', SYS_TIME) . '| POST: payment is null |' . "\r\n", 3,
                        CACHE_PATH . 'pay_error_log.php');
                };
                $cfg = unserialize_config($payment['config']);
                $pay_name = ucwords($payment['pay_code']);
                pc_base::load_app_class('pay_factory', '', 0);
                $payment_handler = new pay_factory($pay_name, $cfg);
                $return_data = $payment_handler->notify();
                file_put_contents(PHPCMS_PATH . 'alipay_debug.log', '$_REQUEST => ' . var_export($_REQUEST, true) . "\r\n", FILE_APPEND);
                file_put_contents(PHPCMS_PATH . 'alipay_debug.log', '$return_data => ' . var_export($return_data, true) . "\r\n\r\n\r\n", FILE_APPEND);
                if ($return_data) {
                    if ($return_data['order_status'] == 0) {
//                        $this->update_member_amount_by_sn($return_data['order_id']);
                        $this->update_order_status_by_sn($return_data['order_id'], 1);
                    }
//                    $this->update_recode_status_by_sn($return_data['order_id'], $return_data['order_status']);

                    $result = true;
                } else {
                    $result = false;
                }
                $payment_handler->response($result);
            }
		}
	}

	/**
	 * 更新订单状态
	 * @param unknown_type $trade_sn 订单ID
	 * @param unknown_type $status 订单状态
	 */
	private function update_recode_status_by_sn($trade_sn,$status) {
		$trade_sn = trim($trade_sn);
		$status = trim(intval($status));
		$data = array();
		$this->account_db = pc_base::load_model('pay_account_model');
		$status = return_status($status);
		$data = array('status'=>$status);
		return $this->account_db->update($data,array('trade_sn'=>$trade_sn));
	}

    /**
     * 更新订单状态
     * @param $trade_sn
     * @param $status
     * @return mixed
     */
	private function update_order_status_by_sn($trade_sn, $status) {
        $this->order_db = pc_base::load_model('order_model');
        $order = $this->order_db->get_one('order_no="' . $trade_sn . '"');
        if ($order['status'] == 1) {
            return true;
        }

        $data = array('order_status'=>$status);

        $result = $this->order_db->update($data,array('order_no'=>$trade_sn));

        if ($result) {
            $message = '已下单';
            $this->_send_sms($order['phone'], $message);
            $this->_send_sms('13922127384', $message);
        }
        return $result;
    }

	/**
	 * 更新用户账户余额
	 * @param unknown_type $trade_sn
	 */
	private function update_member_amount_by_sn($trade_sn) {
		$data = $userinfo = array();
		$this->member_db = pc_base::load_model('member_model');
		$orderinfo = $this->get_userinfo_by_sn($trade_sn);
		$userinfo = $this->member_db->get_one(array('userid'=>$orderinfo['userid']));
		if($orderinfo){
			$money = floatval($orderinfo['money']);
			$amount = $userinfo['amount'] + $money;
			$data = array('amount'=>$amount);
			return $this->member_db->update($data,array('userid'=>$orderinfo['userid']));
		} else {
			error_log(date('m-d H:i:s',SYS_TIME).'|  POST: rechange failed! trade_sn:'.$$trade_sn.' |'."\r\n", 3, CACHE_PATH.'pay_error_log.php');
			return false;
		}
	}
	
	/**
	 * 通过订单ID抓取用户信息
	 * @param unknown_type $trade_sn
	 */
	private function get_userinfo_by_sn($trade_sn) {
		$trade_sn = trim($trade_sn);
		$this->account_db = pc_base::load_model('pay_account_model');
		$result = $this->account_db->get_one(array('trade_sn'=>$trade_sn));
		$status_arr = array('succ','failed','error','timeout','cancel');
		return ($result && !in_array($result['status'],$status_arr)) ? $result : false;
	}
	
	/**
	 * 通过支付代码获取支付信息
	 * @param unknown_type $code
	 */
	private function get_by_code($code) {
		$result = array();
		$code = trim($code);
		$this->pay_db = pc_base::load_model('pay_payment_model');
		$result = $this->pay_db->get_one(array('pay_code'=>$code));
		return $result;
	}
}
?>