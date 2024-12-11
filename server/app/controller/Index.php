<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        // 查询所有日志数据
        $logs = Db::table('http_logs')->select();

        // 查询用于图表的数据
        $chartData = Db::table('http_logs')
            ->field("DATE_FORMAT(request_time, '%H:%i') as time, COUNT(*) as count")
            ->group("time")
            ->order("time")
            ->select();

        // 将数据传递给视图
        View::assign('logs', $logs);
        View::assign('chartData', $chartData);

        return View::fetch();
    }

    public function detail($id)
    {
        // 根据ID查询详细数据
        $log = Db::table('http_logs')->where('id', $id)->find();

        // 返回JSON格式的数据
        return json($log);
    }

    public function finger_list()
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


        // 输出指纹列表
        $fingers = Db::table('fingers')->order('created_at', 'desc')->limit(10)->select();
        // 将结果传递给视图
        return View::fetch('index/finger_list', [
            'totalCount' => $totalCount,
            'totalDifference' => $totalDifference,
            'fingers' => $fingers,
            "count" => $count,
            'difference' => $difference
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


    public function datasafe_list()
    {
        // 使用Db类查询数据
        $alerts = Db::table('datasafe_alerts')->select();

        // 将数据传递给视图
        return View::fetch('datasafe_list', ['alerts' => $alerts]);
    }


}
