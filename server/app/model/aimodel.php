<?php
declare (strict_types=1);

namespace app\model;

use think\facade\Db;
use think\Model;

/**
 * @mixin \think\Model
 */
class aimodel extends Model
{
    //
    public static function aimodel()
    {
//        $list = Db::name('http_logs')->whereNull('ai_result')->limit(100)->select()->toArray();
        $list = Db::name('http_logs')->where('id', 246)->limit(1)->select()->toArray();
//        var_dump($list);
//        exit;
        foreach ($list as $k => $v) {
//            $arr = json_decode($v['request'], true);
//            $arr = json_encode($v['response']);
            $arr = $v['response'];
            var_dump($arr);
//            exit;
            $messages = [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => '帮我识别这个网站用到了那些应用,例如(Jquery),并返回每一个应用指纹的规则' . $arr . '返回格式参考:<<<

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

            //调用大模型接口
//            $result_string = sendMessage($messages);
//            //将$result的内容保存到result.txt文件里
//            $txt = file_put_contents('result.txt', $result_string);

            //从result.txt里读取数据
            $result = file_get_contents('result.txt');
            $result_arr = json_decode($result, true);
//            var_dump($result_arr);exit;
            //过滤字符串
            $result_str = aimodel::extractJsonData($result_arr['choices'][0]['message']['content']);

            $result_arr = json_decode($result_str, true);
            $error = json_last_error_msg();
            var_dump($error);
//
            //判断$result是否为空，如果为空则跳过当前循环
            if (empty($result_arr)) {
                continue;
            }

            //将$result二维数组 的结果插入到fingers数据表中
            foreach ($result_arr as $kk => $vv) {
                var_dump($v['target_domain']);
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