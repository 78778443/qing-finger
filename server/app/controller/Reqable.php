<?php

namespace app\controller;

use app\BaseController;
use DateTime;
use think\facade\Db;
use think\facade\View;
use app\Request;

class Reqable extends BaseController
{
    public function index(Request $request)
    {
        $data = $request->param();

//        //将变量data转成json格式，才能存储在txt文件里,调试时打开
//        $data_str = json_encode($data, JSON_UNESCAPED_UNICODE);
//        $data_str = $data_str . ",\n";
//        file_put_contents(trim(`pwd`) . '/data.json', $data_str);


        try {
            $data = $data['log']['entries'];
            //调用chuli_data函数，将数据插入数据库
            self::chuli_data($data);
        } catch (\Exception $e) {
            //将报错信息写入文件
            file_put_contents(trim(`pwd`) . '/err.json', var_export($data, true));
        }
//        // 返回成功响应
        return json(['status' => 'success', 'message' => 'Data saved to file']);
    }

    public static function test()
    {
        //获取data.json文件数据
        $data_json = file_get_contents(trim(`pwd`) . '/data.json', FILE_APPEND);
        //删除data.json文件中的最后2个字符，
        $data_json = substr($data_json, 0, -2);
        $data_json = '[' . $data_json . ']';
        //并将数据转换成数组
        $data_arr = json_decode($data_json, TRUE);

        foreach ($data_arr as $k0 => $v0) {
            //遍历下标['log']['entries']s下面的数组
            $data = $v0['log']['entries'];
            Reqable::chuli_data($data);
        }

        // 返回成功响应
        return json(['status' => 'success', 'message' => 'Data saved to file']);
    }

    public static function chuli_data($data)
    {
        foreach ($data as $key => $value) {
//            var_dump($value);
            $request_time = $value['startedDateTime'];
            $arr['source_ip'] = $value['serverIPAddress'];
            $arr['url'] = $value['request']['url'];
            // 提取url中host的部分，并将值保存到parse_url中。
            $parse_url = parse_url($arr['url']);
            $arr['domain'] = $parse_url['host'];

//            var_dump($arr['domain']);
//            var_dump($arr['url']);
            $arr['methond'] = $value['request']['method'];
            $arr['status_code'] = $value['response']['status'];
            $arr['bodySize'] = $value['response']['content']['size'];

            // 将请求和响应数据转换为JSON格式的字符串
            $arr['request'] = json_encode($value['request'], JSON_UNESCAPED_UNICODE);
            $arr['response'] = json_encode($value['response'], JSON_UNESCAPED_UNICODE);
            $arr['response_headers'] = json_encode($value['response']['headers'], JSON_UNESCAPED_UNICODE);
            $arr['response_body'] = json_encode($value['response']['content']['text'], JSON_UNESCAPED_UNICODE);
//            var_dump($arr['response'] );exit;
//            $arr['bodySize'] = $value['response']['bodySize'];
            $dateTime = new DateTime($request_time);
            //设置时区为当前时区（如果需要的话，你可以根据实际情况调整时区）
            $dateTime->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            $arr['request_time'] = $dateTime->format('Y-m-d H:i:s');
//                var_dump($arr);exit;
            try {
                DB::name('http_logs')->insert($arr);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }


        }
    }

    public static function test1()
    {
        $data_str = Db::name('http_logs')->select();
        foreach ($data_str as $k0 => $v0) {
//            var_dump($v0['response']['content']['text']);
            //将变量$v0的值（字符串）转换成数组
            $data_arr = json_decode($v0['response'], TRUE);
//            exit;
//            var_dump($size);

            //将数组转换成字符串,插入数据库
            $data_str['headers'] = json_encode($data_arr['headers']);
            $data_str['status'] = json_encode($data_arr['status']);
            //取数组的值，取出来的数据类型是字符串
            $size_str = $data_arr['content']['size'];
            $body_str = $data_arr['content']['text'];

            //插入响应头、响应体、状态码、bodySize
            DB::name('http_logs')->where('id', $v0['id'])->update([
                'response_headers' => $data_str['headers'],
                'response_body' => $body_str,
                'status_code' => $data_str['status'],
                'bodySize' => $size_str,
            ]);;
        }
    }
}
