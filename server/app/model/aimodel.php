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
    public static function aimodel()
    {
        //搜索response_body中包含html的内容
        $list = Db::name('http_logs')->whereLike('response_body', '%<html%')->limit(3)->select()->toArray();
//        var_dump($list);exit;

        foreach ($list as $k => $v) {
            $arr_headers = $v['response_headers'];
            $arr_body = $v['response_body'];

            //将响应头信息转换成数组，键与值对应 method：POST
            $headers_str = '';
            $arr_headers = json_decode($arr_headers, true);
            foreach ($arr_headers as $item) {
                $key = ltrim($item['name'], ':');
                //使用.= 将键值的内容保存到headers_str中，并且换行
                $headers_str .= $key . "：" . $item['value'] . "\n";

            }
//            var_dump($headers_str);
//            exit;

            $messages = [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => '帮我识别这个网站用到了那些应用,例如(Jquery),并返回每一个应用指纹的规则,响应头信息：' . $headers_str . '\n' . '响应体信息：' . $arr_body . '返回格式参考:<<<
[

{
    "name": "xxx",
    "authors": [
        "xxx",
        "xxx <xxx@xxx.xx>"
    ],
    "version": "xx.xx",
    "description": "中文描述xx",
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
            var_dump($messages);
            //调用大模型接口
            $result_string = sendMessage($messages);
//            var_dump($result_string);exit;

//            // 将每行文件用,结尾，并且换行
//            $txt = $result_string . ",\n";
//            //将$result的内容保存到result.txt文件里
//            file_put_contents('result.json', $txt, FILE_APPEND);
//            //从result.txt里读取数据
//            $result = file_get_contents('result.json');
//            var_dump($result);
//            exit;
//            $result_arr = json_decode($result, true);

            $result_arr = json_decode($result_string, true);
//            $result_arr = json_decode($result_string['choices']['message']['content'], true);
            var_dump($result_arr['choices'][0]['message']['content']);
//            exit;
//
            //过滤字符串
            $result_str = aimodel::extractJsonData($result_arr['choices'][0]['message']['content']);

            $result_arr = json_decode($result_str, true);
            $error = json_last_error_msg();
            var_dump($error);

            //判断$result是否为空，如果为空则跳过当前循环
            if (empty($result_arr)) {
                continue;
            }

            //将$result二维数组 的结果插入到fingers数据表中
            foreach ($result_arr as $kk => $vv) {
//                var_dump($v['target_domain']);
//                var_dump($vv);exit;
                $data = [
                    'finger_id' => $v['id'],
                    'name' => $vv['name'],
                    'version' => $vv['version'],
                    'description' => $vv['description'],
                    'domain' => $v['target_domain'],
                    'matches' => json_encode($vv['matches']),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                Db::name('fingers')->insert($data);
//                exit;
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