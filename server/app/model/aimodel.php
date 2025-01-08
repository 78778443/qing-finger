<?php
declare (strict_types=1);

namespace app\model;

use think\facade\Db;
use think\Model;
use think\tests\ValidateTest;

/**
 * @mixin \think\Model
 */
class aimodel extends Model
{
    //
    public static function ai()
    {
        // 子查询：找到每个domain中符合条件的最小id
        $subQuery = Db::name('http_logs')
            ->where('response_body', 'like', '%<html%')
            ->where('ai_scan', 'like', '%no_scan%')
            ->field('domain, MIN(id) as id') // 选择每组中id最小的记录
            ->group('domain')
            ->buildSql();

        // 主查询：根据子查询的结果获取完整记录
        $list = Db::name('http_logs')
            ->field('http_logs.*')
            ->join("({$subQuery}) AS temp", 'http_logs.id = temp.id')
            ->limit(3)->select()->toArray();

//        //搜索response_body中包含html的,同时搜索ai_scan字段中包含no_scan的数据
//        $list = Db::name('http_logs')
//            ->whereLike('response_body', '%<html%')
//            ->whereLike('ai_scan', '%no_scan%')
//            ->limit(3)->select()->toArray();
//        var_dump($list);
//        exit;

        //遍历http_logs表中的response_headers和response_body
        foreach ($list as $k => $v) {
            $arr_headers = $v['response_headers'];
            $arr_body = $v['response_body'];

            //将response_headers头信息转换成数组，键与值对应 method：POST
            $headers_str = '';
            $arr_headers = json_decode($arr_headers, true);
            foreach ($arr_headers as $item) {
                $key = ltrim($item['name'], ':');
                //使用.= 将键值的内容保存到headers_str中，并且换行
                $headers_str .= $key . "：" . $item['value'] . "\n";
            }

            //将字符串$headers_str和$arr_body放到一个数组中，作用是提前设置好ai提示词
            $messages = [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => '帮我识别这个网站用到了那些应用,例如(Jquery),并返回每一个应用指纹的规则,响应头信息：' . $headers_str . '\n' . '响应体信息：' . $arr_body . '返回格式必须按照json格式返回,例如:<<<
[

{
    "name": "xxx",
    "authors": [
        "xxx",
        "xxx <xxx@xxx.xx>"
    ],
    "version": "xx.xx",
    "description": "中文描述xx",
    "OS": "xx操作系统",
    "servicer": "服务器软件",
    "language": "xx编程语言",
    "DBA": "xx数据库",
    "website": "http://xxx.xx/xx",
    "matches": [
        {
            "version": {
                "regex": "xxx",
                "extraction": "xxx"
            }
        }
    ]
}
]
>>>']
            ];
            var_dump($v['id']);
            //调用大模型接口
            $result_string = sendMessage($messages);
            var_dump($result_string);

//            // 调试时打开，将每行文件用,结尾，并且换行
//            $txt = $result_string . ",\n";
//            //将$result的内容保存到result.txt文件里
//            file_put_contents('result.json', $txt, FILE_APPEND);
//            //从result.txt里读取数据
//            $result = file_get_contents('result.json');
//            var_dump($result);
//            exit;
//            $result_arr = json_decode($result, true);

            //将JSON格式的字符串转换为数组
            $result_arr = json_decode($result_string, true);
            //调用aimodel::extractJsonData过滤字符串
            $result_str = aimodel::extractJsonData($result_arr['choices'][0]['message']['content']);
            //将过滤好的JSON格式的字符串转换为数组
            $result_arr = json_decode($result_str, true);
            $error = json_last_error_msg();
            var_dump($error);

            //判断$result_arr是否为空，如果为空则跳过当前循环
            if (empty($result_arr)) {
                continue;
            }

            //将$result_arr二维数组 的结果插入到fingers数据表中
            foreach ($result_arr as $kk => $vv) {
                //为了确保数组中的每个键在变量没有值时不会报错，可以使用 PHP 的 ?? 操作符（空合并操作符）来提供默认值。
                $data = [
                    'finger_id' => $v['id'] ?? null,
                    'domain' => $v['domain'] ?? '',
                    'name' => $vv['name'] ?? '',
                    'authors' => json_encode($vv['authors'] ?? []),
                    'version' => $vv['version'] ?? '',
                    'description' => $vv['description'] ?? '',
                    'matches' => json_encode($vv['matches'] ?? []),
                    'servicer' => $vv['servicer'] ?? '',
                    'language' => $vv['language'] ?? '',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                Db::name('fingers')->insert($data);
            }
            //更新ai_scan字段的值为扫描已完成
            DB::name('http_logs')->where('id', $v['id'])->update(['ai_scan' => '扫描已完成']);
        }
    }

    public static function mingan_data()
    {
        //判断http_logs表中的mingandata_scan字段是否为no_scan，如果是则进行扫描
        $http = Db::name('http_logs')->where('mingandata_scan', 'no_scan')->select()->toArray();

        foreach ($http as $v) {
            //使用正则表达式匹配response_body中的敏感信息，例如手机号、身份证、邮箱等
            preg_match_all('/\b1[3-9]\d{9}\b/', $v['response_body'], $phone);
            preg_match_all('/\b[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]\b/', $v['response_body'], $idcard);
            preg_match_all('/[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+/', $v['response_body'], $email);

            if (!empty($phone[0]) || !empty($idcard[0]) || !empty($email[0])) {
                foreach ($phone[0] as $v1) {
//                    var_dump($v1);
                }
                foreach ($idcard[0] as $v2) {
//                    var_dump($v2);
                }
                foreach ($email[0] as $v3) {
//                    var_dump($v3);
                }

                $info = [
                    'phone:' => $phone[0],
                    'idcard:' => $idcard[0],
                    'email:' => $email[0],
                ];
//            json_encode($info);
//
                $data_str = json_encode($info, JSON_UNESCAPED_UNICODE);
                $data = [
                    'http_id' => $v['id'],
                    'domain' => $v['domain'],
                    'data' => $data_str,
                    'alert_time' => $v['request_time'],
                ];

                //将http_logs表中的mingandata_scan字段的值为扫描已完成

                $update = DB::name('http_logs')->where('id', $v['id'])->update(['mingandata_scan' => '扫描已完成']);
//                var_dump($update);
                Db::name('datasafe_alerts')->insert($data);
            }
        }
    }

    public static function extractJsonData(string $input): string
    {
        //我需要提取字符串里面的数据，匹配规则是```和```之间的内容
        $pattern = '/```(.*?)```/s';
        preg_match_all($pattern, $input, $matches);

        $ret_str = $matches[1][0];
        //如果$ret_str前面以json开头，则删除json,用一行代码实现
        $ret_str = preg_replace('/^json/', '', $ret_str);

        return $ret_str;
    }
}