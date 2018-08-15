<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

use \Firebase\JWT\JWT;

// 解密user_token
function decoded_user_token($token = '')
{
    
    try {
        
        $decoded = JWT::decode($token, API_KEY . JWT_KEY, array('HS256'));

        return (array) $decoded;
        
    } catch (Exception $ex) {
        
        return $ex->getMessage();
    }
}

// 获取解密信息中的data
function get_member_by_token($token = '')
{
    
    $result = decoded_user_token($token);

    return $result['data'];
}

// 数据验签时数据字段过滤
function sign_field_filter($data = [])
{
    
    $data_sign_filter_field_array = config('data_sign_filter_field');
    
    foreach ($data_sign_filter_field_array as $v)
    {
        
        if (array_key_exists($v, $data)) {
            
            unset($data[$v]);
        }
    }
    
    return $data;
}

// 过滤后的数据生成数据签名
function create_sign_filter($data = [], $key = '')
{
    
    $filter_data = sign_field_filter($data);
    
    return empty($key) ? data_md5_key($filter_data, API_KEY) : data_md5_key($filter_data, $key);
}

//file_get_contents
function get($url, $data_type='text')
    {
        $cl = curl_init();
        if(stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1 );
        $content = curl_exec($cl);
        $status = curl_getinfo($cl);
        curl_close($cl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            if ($data_type == 'json') {
                $content = json_decode($content);
            }
            return $content;
        } else {
            return FALSE;
        }        
}