<?php
//require_once("alipay.config.php");
class AlipayController extends Controller
{
	public $companyId = 0;
	public $layout = '/layouts/mallmain';
	public $alipay_config = array();
    public function init(){
		$companyId = Yii::app()->request->getParam('companyId');
		$this->companyId = $companyId;
		
		//合作身份者id，以2088开头的16位纯数字
		$this->alipay_config['partner'] = '2088811584894868';
		//收款支付宝账号，一般情况下收款账号就是签约账号
		$this->alipay_config['seller_id']	= $this->alipay_config['partner'];
		//商户的私钥（后缀是.pen）文件相对路径
		$this->alipay_config['private_key_path'] = 'admin/rsa_private_key.pem';
		//支付宝公钥（后缀是.pen）文件相对路径
		$this->alipay_config['ali_public_key_path'] = 'admin/ali_public_key.pem';
		//签名方式 不需修改 
		$this->alipay_config['sign_type']    = strtoupper('RSA');
		//字符编码格式 目前支持 gbk 或 utf-8
		$this->alipay_config['input_charset'] = strtolower('utf-8');
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$this->alipay_config['cacert']    = 'admin/cacert.pem';
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$this->alipay_config['transport']    = 'http';
    }
    /*
     * 一个支付宝支付按钮，
     * 其他参数都作为隐藏参数放在form里面，
     * 点击后提交到pay
     */
	public function actionIndex()
	{
		$this->render('index');
	}
	/**
	 * 
	 * 支付宝手机网站支付接口快速通道
	 * 
	 */
    public function actionMobileWeb(){
		//支付类型
        $payment_type = "1";
        //服务器异步通知页面路径
        $notify_url = Yii::app()->request->hostInfo."/wymenuv2/alipay/notify?companyId=".$this->companyId;
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = Yii::app()->request->hostInfo."/wymenuv2/alipay/return?companyId=".$this->companyId;
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        $out_trade_no = $_GET['out_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $_GET['subject'];
        //付款金额
        $total_fee = $_GET['total_fee'];
        //必填
        //商品展示地址
        $show_url = $_GET['show_url'];
        //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //订单描述 
        $body = isset($_GET['body'])?$_GET['body']:'';
        //超时时间
        $it_b_pay = isset($_GET['it_b_pay'])?$_GET['it_b_pay']:'';
        //钱包token
        $extern_token = isset($_GET['extern_token'])?$_GET['extern_token']:'';
        //构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "alipay.wap.create.direct.pay.by.user",
				"partner" => trim($this->alipay_config['partner']),
				"seller_id" => trim($this->alipay_config['seller_id']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"show_url"	=> $show_url,
				"body"	=> $body,
				"it_b_pay"	=> $it_b_pay,
				"extern_token"	=> $extern_token,
				"_input_charset"=> trim(strtolower($this->alipay_config['input_charset']))
		);
		
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->alipay_config);
		$htmlText = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		
		$this->render('mobileweb',array('htmlText'=>$htmlText));
    }
    /**
     * 
     * 支付宝即时到账交易接口接口
     * 
     */
    public function actionInstantArriva(){
        //支付类型
        $payment_type = "1";
        //服务器异步通知页面路径
        $notify_url = Yii::app()->request->hostInfo."/wymenuv2/alipay/notify?companyId=".$this->companyId;
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = Yii::app()->request->hostInfo."/wymenuv2/alipay/return?companyId=".$this->companyId;
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        $out_trade_no = $_GET['out_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $_GET['subject'];
        //付款金额
        $total_fee = $_GET['total_fee'];
        //必填
        //商品展示地址
        $show_url = $_GET['show_url'];
        //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //订单描述 
        $body = isset($_GET['body'])?$_GET['body']:'';
        //超时时间
        $it_b_pay = isset($_GET['it_b_pay'])?$_GET['it_b_pay']:'';
        //钱包token
        $extern_token = isset($_GET['extern_token'])?$_GET['extern_token']:'';
        //构造要请求的参数数组，无需改动
        $parameter = array(
                "service" => "create_direct_pay_by_user",
                "partner" => trim($this->alipay_config['partner']),
                "seller_id" => trim($this->alipay_config['seller_id']),
                "payment_type"  => $payment_type,
                "notify_url"    => $notify_url,
                "return_url"    => $return_url,
                "out_trade_no"  => $out_trade_no,
                "subject"   => $subject,
                "total_fee" => $total_fee,
                "show_url"  => $show_url,
                "body"  => $body,
                "it_b_pay"  => $it_b_pay,
                "extern_token"  => $extern_token,
                'qr_pay_mode'=>4,
                "_input_charset"=> trim(strtolower($this->alipay_config['input_charset']))
        );
        
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $htmlText = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        
        $this->render('mobileweb',array('htmlText'=>$htmlText));
    }
   
    public function actionReturn()
	{
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        $orderIdArr = explode('-',$_GET["out_trade_no"]);
        if($verify_result) {//验证成功
                //商户订单号
                $out_trade_no = $_GET['out_trade_no'];
                //支付宝交易号
                $trade_no = $_GET['trade_no'];
                //交易状态
                $trade_status = $_GET['trade_status'];
                //交易目前所处的状态。成功状态的值只有两个：
                //TRADE_FINISHED（普通即时到账的交易成功状态）
                //TRADE_SUCCESS（开通了高级即时到账或机票分销产品后的交易成功状态）
            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                //下单，返回页面，单元清单。。。
                $alipayNotify->checkNotify($_GET);
            } else {
                //echo "trade_status=".$_GET['trade_status'];
                $ret_status= "非正常返回，验证成功。";
            }

        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            $ret_status="验证失败";
        }
        //跳转订单详情
        $this->redirect(array('/user/orderInfo','companyId'=>$orderIdArr[1],'orderId'=>$orderIdArr[0]));
	}
        
    public function actionNotify()
	{
        $alipayNotify = new AlipayNotify($this->alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {//验证成功 
                $out_trade_no = $_POST['out_trade_no'];
                //支付宝交易号
                $trade_no = $_POST['trade_no'];
                //交易状态
                $trade_status = $_POST['trade_status'];
                //WAIT_BUYER_PAY交易创建，等待买家付款。
                //TRADE_CLOSED 在指定时间段内未支付时关闭的交易；在交易完成全额退款成功时关闭的交易。
                //TRADE_SUCCESS 交易成功，且可对该交易做操作，如：多级分润、退款等。
                //TRADE_PENDING 等待卖家收款（买家付款后，如果卖家账号被冻结）。
                //TRADE_FINISHED 交易成功且结束，即不可再做任何操作
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                //调试用，写文本函数记录程序运行情况是否正常
                //厨打、收款/退款、结单
//                $this->notifyTrade($out_trade_no,$trade_no,$trade_no);
            }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
               //注意：
               //付款完成后，支付宝系统发送该交易状态通知
                //厨打、收款/退款、结单
                $alipayNotify->checkNotify($_POST);
            }
            echo "success";		//请不要修改或删除
        }else{
            //验证失败
            echo "fail";
        }
        exit;
	}  
}