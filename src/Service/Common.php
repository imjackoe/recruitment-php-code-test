<?php
namespace App\Service;

/**
 * 公用方法
 *
 *
 *
 */
class Common
{ 
    protected static $debug;

    /**
     * geo helper 地址转换为坐标
     * @param $address
     * @return bool|string
     */
    public function geoHelperAddress($address, $merchant_id = '')
    {

        try {
            $cackeKey = 'cache-address-'.$address;

            // 從獲取座標
            $userLocation = redisx()->get($cackeKey);
            if ($userLocation) {
                return $userLocation;
            }

            $key = 'time=' . time();

            // requestLog：寫日志
            requestLog('Backend', 'Thrift', 'Http', 'phpgeohelper\\Geocoding->convert_addresses', 'https://geo-helper-hostr.ks-it.co',  [[$address, $key]]);

            // getThriftService： 獲取 Thrift 服務
            $geoHelper = ServiceContainer::getThriftService('phpgeohelper\\Geocoding');
            $param = json_encode([[$address, $key]]);

            // 調用接口，以地址獲取座標
            $response = $geoHelper->convert_addresses($param);
            $response = json_decode($response, true);

            if ($response['error'] == 0) {
                responseLog('Backend', 'phpgeohelper\\Geocoding->hksf_addresses', 'https://geo-helper-hostr.ks-it.co', '200', '0',  $response);
                $data = $response['data'][0];
                $coordinate = $data['coordinate'];

                // 如果返回 '-999,-999'，表示調用接口失敗，那麼直接使用商家位置的座標
                if ($coordinate == '-999,-999') {
                    infoLog('geoHelper->hksf_addresses change failed === ' . $address);
                    if ($merchant_id) {
                        $sMerchant = new Merchant();
                        $res = $sMerchant->get_merchant_address($merchant_id);
                        $user_location = $res['latitude'] . ',' . $res['longitude'];
                        return $user_location;
                    }
                    infoLog('geoHelper->hksf_addresses change failed === merchant_id is null' . $merchant_id);
                    return false;
                }
                if (!isset($data['error']) && (strpos($coordinate,',') !== false)) {
                    $arr = explode(',', $coordinate);
                    $user_location = $arr[1] . ',' . $arr[0];

                    // set cache
                    redisx()->set($cackeKey, $user_location);
                    return $user_location;
                }
            }
            responseLog('Backend', 'phpgeohelper\\Geocoding->hksf_addresses', 'https://geo-helper-hostr.ks-it.co', '401', '401',  $response);
            return false;
        } catch (\Throwable $t) {
            criticalLog('geoHelperAddress critical ==' . $t->getMessage());
            return 0;
        }
    }

    // 回调状态过滤
    public static function checkStatusCallback($order_id, $status)
    {
        // 是900 可以回调
        if ($status == 900) {
            return 1;
        }
        // backend状态为 909 915 916 时 解锁工作单 但不回调
        $code_arr = ['909', '915', '916'];
        if (in_array($status, $code_arr)) {
            infoLog('checkStatusCallback backend code is 909 915 916');
            return 0;
        }

        $open_status_arr = ['901' => 1, '902' => 2, '903' => 3];
        return $order_id.'-'.$open_status_arr[$status];
    }
}
 /**
  * 代码评审
  */
 /*
  1. geoHelperAddress(),地址转坐标方法
     a.如果地址数据数量不多，redis缓存可以用地址+商家id作为key，当地址查不到情况下根据商家id去查也可以直接读取缓存，另外redis的key应该设置缓存时间，
       提前制定合理的内存优化策略，防止造成内存泄漏和性能下降问题。
     b.如果地址数据数量过多，地址不应该缓存，商家id可以作为redis的key。
     c.日志不规范，没有统一的关键字
     d. response响应数据应该增加状态码

 2.checkStatusCallback(),回调状态过滤
   a. 应该定义相对应的响应状态码code，如可以回调不解锁，回调解锁，不可以回调。
   b. 定义一个状态码常量数组，整合状态码。
   c. status有可能除了以上的其他值，直接用$open_status_arr[$status]可能会报错，可以用switch case枚举。
 */
