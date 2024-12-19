<?php

namespace app\controller;

use app\BaseController;
use DateTime;
use think\facade\Db;
use app\Request;
use think\facade\View;

class Reqable extends BaseController
{
    public function index(Request $request)
    {
        $data = $request->param();

        $data = $data['log']['entries'];
        foreach ($data as $key => $value) {
            $request_time = $value['startedDateTime'];
            $arr['source_ip'] = $value['serverIPAddress'];
            $arr['target_domain'] = $value['request']['url'];
            $arr['request_type'] = $value['request']['method'];
            $arr['status_code'] = $value['response']['status'];

            // 将请求和响应数据转换为JSON格式
            $arr['request'] = json_encode($value['request'], JSON_UNESCAPED_UNICODE);
            $arr['response'] = json_encode($value['response'], JSON_UNESCAPED_UNICODE);

            $arr['bodySize'] = $value['response']['bodySize'];

            $dateTime = new DateTime($request_time);
            //设置时区为当前时区（如果需要的话，你可以根据实际情况调整时区）
            $dateTime->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            $arr['request_time'] = $dateTime->format('Y-m-d H:i:s');

            DB::name('http_logs')->insert($arr);

        }
        // 返回成功响应
        return json(['status' => 'success', 'message' => 'Data saved to file']);
    }

    public
    function test()
    {
        $data = file_get_contents('../data.json');
        $data = json_decode($data, true);


//        var_dump($data);
//        $data = $data['log']['entries'];
//        var_dump($data);
        foreach ($data as $key => $value) {
            $request_time = $value['startedDateTime'];
            $arr['source_ip'] = $value['serverIPAddress'];
            $arr['target_domain'] = $value['request']['url'];
            $arr['request_type'] = $value['request']['method'];
            $arr['status_code'] = $value['response']['status'];

            // 将请求和响应数据转换为JSON格式
            $arr['request'] = json_encode($value['request'], JSON_UNESCAPED_UNICODE);
            $arr['response'] = json_encode($value['response'], JSON_UNESCAPED_UNICODE);

            $arr['bodySize'] = $value['response']['bodySize'];

            $dateTime = new DateTime($request_time);
            //设置时区为当前时区（如果需要的话，你可以根据实际情况调整时区）
            $dateTime->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            $arr['request_time'] = $dateTime->format('Y-m-d H:i:s');

            DB::name('http_logs')->insert($arr);

        }
    }

}
