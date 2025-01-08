<?php

namespace app\controller;

use app\BaseController;
use app\Request;
use think\facade\Db;
use think\facade\View;

class Index extends BaseController
{
    public function index(Request $request)
    {
        //应用筛选
        $domain = $request->param('domain');
        $source_ip = $request->param('source_ip');
        $start_time = $request->param('start_time');
        $end_time = $request->param('end_time');
        $methond = $request->param('methond');
        $where = [];
        if (!empty($domain)) {
            $where['domain'] = $domain;
        }
        if (!empty($source_ip)) {
            $where['source_ip'] = $source_ip;
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where[] = ['request_time', '>=', $start_time];
            $where[] = ['request_time', '<=', $end_time];
        }
        if (!empty($methond)) {
            $where['methond'] = $methond;
        }
        $logs = Db::table('http_logs')->where($where)->order('id', 'desc')->paginate(4);
        $count = $logs->total();
//var_dump($logs);exit;

        // 查询用于图表的数据
        $chartData = Db::table('http_logs')
            ->field("DATE_FORMAT(request_time, '%H:%i') as time, COUNT(*) as count")
            ->group("time")
            ->order("time")
            ->select();


        // 根据 methond 字段去重
        $result = Db::name('http_logs')->distinct(true)->column('methond');
//        var_dump($result);exit;
        // 将数据传递给视图
        View::assign('logs', $logs);
        View::assign('chartData', $chartData);
        View::assign('results', $result);
        View::assign('count', $count);

        return View::fetch();
    }


    public function detail($id)
    {
        // 根据ID查询详细数据
        $log = Db::table('http_logs')->where('id', $id)->find();

        // 返回JSON格式的数据
        return json($log);
    }

    public function finger_list(Request $request)
    {


        // 总指纹数
        $totalCountSql = Db::table('fingers')->distinct(true)->field('COUNT(DISTINCT finger_id) as count')->buildSql();
        $totalCountResult = Db::query($totalCountSql);
        $totalCount = $totalCountResult[0]['count'];
        // 昨日去重查询总指纹数（去重 finger_id）
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $yesterdayCountQuery = Db::table('fingers')
            ->whereTime('created_at', '<=', $yesterday . ' 23:59:59')
            ->distinct(true)
            ->count('finger_id');
        $yesterdayCountSql = Db::table('fingers')
            ->whereTime('created_at', '<=', $yesterday . ' 23:59:59')
            ->distinct(true)
            ->field('COUNT(DISTINCT finger_id) as count')->buildSql();
        $yesterdayCountResult = Db::query($yesterdayCountSql);
        $yesterdayCount = $yesterdayCountResult[0]['count'];
        // 计算总指纹数较昨日新增的数量
        $totalDifference = $totalCount - $yesterdayCount;

        // 今日新增
        $today = date('Y-m-d');
        $count = Db::table('fingers')->whereTime('created_at', 'today')->count();
        // 获取昨日新增的数据条数
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $yesterdayCount = Db::table('fingers')
            ->whereTime('created_at', 'yesterday')
            ->count();
        // 计算今日新增与昨日新增的差值
        $difference = $count - $yesterdayCount;
        $total = Db::name('fingers');


        $domain = $request->param('domain');
        $finger_type = $request->param('finger_type');
        $status = $request->param('status');
        $where = [];
        if (!empty($domain)) {
            $where['domain'] = $domain;
        }
        if (!empty($finger_type)) {
            $where['finger_type'] = $finger_type;
        }
        if (!empty($status)) {
            $where['status'] = $status;
        }
        // 输出指纹列表
        $fingers = Db::table('fingers')->where($where)->order('id', 'desc')->paginate(10);
        $tiaoshu = $fingers->total();

        // 将结果传递给视图
        return View::fetch('index/finger_list', [
            'totalCount' => $totalCount,
            'totalDifference' => $totalDifference,
            'fingers' => $fingers,
            "count" => $count,
            'difference' => $difference,
            'total' => $total,
            'tiaoshu' => $tiaoshu,
        ]);
    }


    public function finger_detail($id)
    {
        $finger = Db::table('fingers')->where('id', $id)->find();
        return view('finger_detail', ['finger' => $finger]);
    }


    public function index_detail()
    {
        // 使用视图输出过滤
        return View::fetch();
    }

    public function system_setting()
    {
        // 使用视图输出过滤
        return View::fetch();
    }

    public function test()
    {
        // 使用视图输出过滤
        return View::fetch();
    }


    public function datasafe_list(Request $request)
    {
        $domain = $request->param();
        //查询对应域名下的所有数据
        $detail = Db::table('datasafe_alerts')
            ->where($domain)
            ->select()
            ->toArray();
//        var_dump($detail);


        $alertsObj = Db::table('datasafe_alerts')
            ->field('domain, GROUP_CONCAT(id) as ids') // 获取域名和关联ID
            ->group('domain') // 按照域名分组
            ->paginate(5); // 执行查询

        //将对象转换为数组
        $alerts = $alertsObj->items();
        // 查询总数据条数
        $count = $alertsObj->total();

//        var_dump($alertsObj);
        $alertDetails = [];
        foreach ($alerts as &$alert) {
            $domain = $alert['domain'];
            $alert['erji'] = Db::table('datasafe_alerts')->where('domain', $domain)->select()->toArray();
            foreach ($alert['erji'] as &$erji) {
//                var_dump($erji['http_id']);
                $http_id = Db::table('http_logs')->where('id', $erji['http_id'])->select()->toArray();
                $erji['http_id'] = $http_id;
            }
        }
//        var_dump($alerts);

        // 将数据传递给视图
        return View::fetch('datasafe_list', [
            'alert_type' => $alerts,
            'alert_details' => $alertDetails,
            'alerts' => $alertsObj,
            'detail' => $detail,
            'count' => $count
        ]);
    }

    public function datasafe_detail($id)
    {
        // 根据ID查询详细数据
        $log = Db::table('http_logs')->where('id', $id)->find();

        // 返回JSON格式的数据
        return json($log);
    }



}
