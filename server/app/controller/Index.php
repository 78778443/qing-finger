<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;
use app\Request;
use think\facade\View;

class Index extends BaseController
{
    public function index(Request $request)
    {
        //应用筛选
        $target_domain = $request->param('target_domain');
        $source_ip = $request->param('source_ip');
        $start_time = $request->param('start_time');
        $end_time = $request->param('end_time');
        $request_type = $request->param('request_type');
        $where = [];
        if (!empty($target_domain)) {
            $where['target_domain'] = $target_domain;
        }
        if (!empty($source_ip)) {
            $where['source_ip'] = $source_ip;
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where[] = ['request_time', '>=', $start_time];
            $where[] = ['request_time', '<=', $end_time];
        }
        if (!empty($request_type)) {
            $where['request_type'] = $request_type;
        }
        $logs = Db::table('http_logs')->where($where)->order('id', 'desc')->paginate(4);
        $count = Db::table('http_logs')->count();
//var_dump($logs);exit;

        // 查询用于图表的数据
        $chartData = Db::table('http_logs')
            ->field("DATE_FORMAT(request_time, '%H:%i') as time, COUNT(*) as count")
            ->group("time")
            ->order("time")
            ->select();


        // 根据 request_type 字段去重
        $result = Db::name('http_logs')->distinct(true)->column('request_type');
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
        $total = Db::name('fingers')->count();

        // 输出指纹列表
        $fingers = Db::table('fingers')->where($where)->order('id', 'desc')->paginate(10);
//        var_dump($fingers);exit;
        // 将结果传递给视图
        return View::fetch('index/finger_list', [
            'totalCount' => $totalCount,
            'totalDifference' => $totalDifference,
            'fingers' => $fingers,
            "count" => $count,
            'difference' => $difference,
            'total' => $total
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


    public function datasafe_list(Request $request)
    {
        $alert_type = $request->param('alert_type');
        $risk_level = $request->param('risk_level');
        $status = $request->param('status');
        $domain = $request->param('domain');
        $where = [];
        if (!empty($alert_type)) {
            $where['alert_type'] = $alert_type;
        }
        if (!empty($risk_level)) {
            $where['risk_level'] = $risk_level;
        }
        if (!empty($status)) {
            $where['status'] = $status;
        }
        if (!empty($domain)) {
            $where['domain'] = $domain;
        }
        // 使用Db类查询数据
        $alerts = Db::table('datasafe_alerts')->where($where)->order('id', 'desc')->paginate(4);
        $count = Db::table('datasafe_alerts')->count();

        // 将数据传递给视图
        return View::fetch('datasafe_list', [
            'alerts' => $alerts,
            'count' => $count]);
    }


}
