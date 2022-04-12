<?php
namespace App\Service;

/**
 * 公用方法
 *
 */
class Common
{ 
    protected static $debug;

    /**
     * geo helper 地址转换为坐标
     *
     * 问题1：cacheKey 最好区分商户，把所有条件包含进去
     * 问题2：从Thrift中获取地址和从Merchant中获取地址方法混在一起，逻辑混乱，可读性很差，建议拆分
     *
     * @param $address
     * @param $merchant_id
     * @return false|int|string
     */
    public function geoHelperAddress($address, $merchant_id = '')
    {
        //问题1：这里最好区分商户，把所有条件都包含进去
//        $cacheKey = 'cache-address-'.$address;
        $cacheKey = "cache-address-{$merchant_id}-".$address;

        // 從獲取座標
        if (!($userLocation = redisx()->get($cacheKey))) {
            $userLocation = '';
            // getThriftService： 獲取 Thrift 服務
            try {
                $userLocation = $this->getAddressFromThrift($address);
            } catch (\Exception $e) {
                infoLog('geoHelper->hksf_addresses change failed === ' . $address);
            }

            if (empty($userLocation) && $merchant_id) {
                $userLocation = $this->getAddressFromMerchant($merchant_id);
            }

            // 改进1：这里如果定义坐标为空的话，建议给一个默认值, 比如：0,0，避免一直重试接口
            redisx()->set($cacheKey, $userLocation ? : '0,0');
        }

        //这里可以根据需求判断一下是不是默认值0,0
        return $userLocation;

//        try {
//            $cackeKey = 'cache-address-'.$address;
//
//            // 從獲取座標
//            $userLocation = redisx()->get($cackeKey);
//            if ($userLocation) {
//                return $userLocation;
//            }
//
//            $key = 'time=' . time();
//
//            // requestLog：寫日志
//            requestLog('Backend', 'Thrift', 'Http', 'phpgeohelper\\Geocoding->convert_addresses', 'https://geo-helper-hostr.ks-it.co',  [[$address, $key]]);
//
//            // getThriftService： 獲取 Thrift 服務
//            $geoHelper = ServiceContainer::getThriftService('phpgeohelper\\Geocoding');
//            $param = json_encode([[$address, $key]]);
//
//            // 調用接口，以地址獲取座標
//            $response = $geoHelper->convert_addresses($param);
//            $response = json_decode($response, true);
//
//            if ($response['error'] == 0) {
//                responseLog('Backend', 'phpgeohelper\\Geocoding->hksf_addresses', 'https://geo-helper-hostr.ks-it.co', '200', '0',  $response);
//                $data = $response['data'][0];
//                $coordinate = $data['coordinate'];
//
//                // 如果返回 '-999,-999'，表示調用接口失敗，那麼直接使用商家位置的座標
//                if ($coordinate == '-999,-999') {
//                    infoLog('geoHelper->hksf_addresses change failed === ' . $address);
//                    if ($merchant_id) {
//                        $sMerchant = new Merchant();
//                        $res = $sMerchant->get_merchant_address($merchant_id);
//                        $user_location = $res['latitude'] . ',' . $res['longitude'];
//                        return $user_location;
//                    }
//                    infoLog('geoHelper->hksf_addresses change failed === merchant_id is null' . $merchant_id);
//                    return false;
//                }
//                if (!isset($data['error']) && (strpos($coordinate,',') !== false)) {
//                    $arr = explode(',', $coordinate);
//                    $user_location = $arr[1] . ',' . $arr[0];
//
//                    // set cache
//                    redisx()->set($cackeKey, $user_location);
//                    return $user_location;
//                }
//            }
//            responseLog('Backend', 'phpgeohelper\\Geocoding->hksf_addresses', 'https://geo-helper-hostr.ks-it.co', '401', '401',  $response);
//            return false;
//        } catch (\Throwable $t) {
//            criticalLog('geoHelperAddress critical ==' . $t->getMessage());
//            return 0;
//        }
    }

    /**
     * 回调状态过滤
     *
     * 问题1：这里主要就是回调状态不一致，一个功能里面出现了多个返回结果在里面
     * 解决1：如果非要一个方法完成，可以考虑返回格式为【 订单号-是否回调-转换码 】，如果文中，0，1也是属于转换码的话，建议直接统一【订单号-转换码】，避免二义性
     *
     * @param $order_id
     * @param $status
     * @return int|string
     * @throws \Exception
     */
    public static function checkStatusCallback($order_id, $status)
    {
        //改成Switch更清晰
        // 是900 可以回调
//        if ($status == 900) {
//            return 1;
//        }
//        // backend状态为 909 915 916 时 解锁工作单 但不回调
//        $code_arr = ['909', '915', '916'];
//        if (in_array($status, $code_arr)) {
//            infoLog('checkStatusCallback backend code is 909 915 916');
//            return 0;
//        }

//        $open_status_arr = ['901' => 1, '902' => 2, '903' => 3];
//        return $order_id.'-'.$open_status_arr[$status];

        //改进1：现有代码优化
        switch ($status) {
            // 是900 可以回调
            case 900 :
                return 1;
                break;
            // backend状态为 909 915 916 时 解锁工作单 但不回调
            case 909 :
            case 915 :
            case 916 :
                infoLog('checkStatusCallback backend code is 909 915 916');
                return 0;
                break;
            default :
                $statusMap  = [
                    901 => 1,
                    902 => 2,
                    903 => 3
                ];

                if (!isset($statusMap[$status])) {
                    throw new \Exception("unknown status code [{$status}]");
                }

                return $order_id.'-'.$statusMap[$status];
        }


        //改进2；如果统一状态码的话，例如：【订单号-转换码】可优化成
        $statusMap  = [
            900 => 1,
            901 => 1,
            902 => 2,
            903 => 3,
            909 => 0,
            915 => 0,
            916 => 0,
        ];

        if (!isset($statusMap[$status])) {
            throw new \Exception("unknown status code [{$status}]");
        }

        return $order_id.'-'.$statusMap[$status];
    }

    /**
     * 从Thrift接口中获取地址
     *
     * @param $address
     * @return string
     * @throws \Exception
     */
    private function getAddressFromThrift($address)
    {
        $key = 'time=' . time();
        // requestLog：寫日志
        requestLog('Backend', 'Thrift', 'Http', 'phpgeohelper\\Geocoding->convert_addresses', 'https://geo-helper-hostr.ks-it.co',  [[$address, $key]]);

        // getThriftService： 獲取 Thrift 服務
        $geoHelper = ServiceContainer::getThriftService('phpgeohelper\\Geocoding');
        $param = json_encode([[$address, $key]]);

        // 調用接口，以地址獲取座標
        $response = $geoHelper->convert_addresses($param);
        $response = json_decode($response, true);

        //这里的判断如果在接口调用失败的时候，会有问题
        if ($response['error'] == 0) {
            responseLog('Backend', 'phpgeohelper\\Geocoding->hksf_addresses', 'https://geo-helper-hostr.ks-it.co', '200', '0',  $response);
            $data       = $response['data'][0];
            $coordinate = $data['coordinate'];

            if (!isset($data['error']) && (strpos($coordinate,',') !== false)) {
                $arr = explode(',', $coordinate);
                return $arr[1] . ',' . $arr[0];
            }
        }

        throw new \Exception("接口获取地址失败");
    }

    /**
     * 从Merchant中获取地址
     *
     * @param $merchant_id
     * @return string
     */
    private function getAddressFromMerchant($merchant_id)
    {
        $sMerchant = new Merchant();
        $res = $sMerchant->get_merchant_address($merchant_id);
        return $res['latitude'] . ',' . $res['longitude'];
    }
}
