<?php
/**
 *
 * 微信统一支付
 *
 * @package   NiPHPCMS
 * @category  net\pay\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WxJsPay.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\pay;

use net\pay\library\WxPay;

class WxJsPay
{

    function payCode($config=[], $param=[])
    {
        $param['trade_type']  = 'JSAPI';
        $param['device_info'] = 'WEB';

        $pay = new WxPay($config, $param);
        $data = $pay->getJsApi();

        $return = $data['js'];
        $return .= '<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>';

        return $return;
    }
}




/*include('Pay.class.php');
include('WxPay.class.php');

$config = array(
    'appid' => '',
    'appsecret' => '',
    'mch_id' => '',
    'key' => '');
$param = array(
    'body' => 'test',                    // 商品描述 128位
    'detail' => '',                        // 商品详情
    'attach' => '',                        // 附加数据 127位
    'out_trade_no' => date('YmdHis'),    // 商户订单号 32位
    'total_fee' => 1,
    'goods_tag' => '',                    // 商品标记 32位
    'notify_url' => 'http://www.youtuiyou.com/m/test/notify.php',                    // 异步通知回调地址,不能携带参数
    'trade_type' => 'JSAPI',            // 交易类型
    'product_id' => '',                    // 商品ID 32位
    'device_info' => 'WEB',
    );

$pay = new WxPay($config, $param);
$data = $pay->getJsApi();
echo $data['js'];*/
