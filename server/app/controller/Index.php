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
        // 应用筛选
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
        $logs = Db::table('http_logs')->where($where)->order('id', 'desc')->paginate(['query' => $request->param(), 'list_rows' => 10]);

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
//        var_dump($logs);
//exit;
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
//        $totalCountSql = Db::table('fingers')->distinct(true)->field('COUNT(DISTINCT finger_id) as count')->buildSql();
        $totalCountSql = Db::table('fingers')->distinct(true)->field('COUNT(DISTINCT id) as count')->buildSql();
//        var_dump($totalCountSql);
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
        // 查询fingers表中重复的name字段有多少条
        $duplicateCount = $total->group('name')->having('COUNT(name) > 1')->count();
//        var_dump($duplicateCount);

        //获取请求参数
        $domain = $request->param('domain');
        $name = $request->param('name');
//        // 请求参数不为空时，将查询条件添加到 $where 数组中
//        $where = [];
//        if (!empty($domain)) {
//            $where['domain'] = $domain;
//        }
//        if (!empty($name)) {
//            $where['name'] = $name;
//        }
        //给$domain的值为空时，给它一个默认值防止报错
        $domain = $domain ?? '';
        $name = $name ?? '';
//        var_dump($domain);

        //对domian参数和name参数进行模糊查询
        $fingersObj = Db::table('fingers')
            ->where('domain', 'like', '%' . $domain . '%')
            ->where('name', 'like', '%' . $name . '%')
            ->order('id', 'desc')
            ->select()->toArray();
        //把$detailObj里面的domain字段转换为一维数组
        $detailArr = array_column($fingersObj, 'domain');
//        var_dump($detailArr);

        // 没有搜索参数，查询全部数据
        $domainObj = Db::table('domains')->whereIn('domain', $detailArr)->order('id', 'desc')->paginate(['query' => $request->param(), 'list_rows' => 5]);

//        var_dump($domainObj);
        // 获取domains表中一共有多少条，需要随着搜索条件进行过滤
        $total = $domainObj->total();
        $detailArr = $domainObj->items();

        foreach ($detailArr as &$item) {
            // 使用domain 查询对应的域名
            $item['finger'] = Db::table('fingers')->where('domain', $item['domain'])->select()->toArray();
        }

        // 将结果传递给视图
        return View::fetch('index/finger_list', [
            'totalCount' => $totalCount,
            'totalDifference' => $totalDifference,
            'fingers' => $detailArr,
            "count" => $count,
            'difference' => $difference,
            'total' => $total,
            'domainObj' => $domainObj,
        ]);
    }


    public function finger_detail($id)
    {
        $finger = Db::table('http_logs')->where('id', $id)->find();
//        return view('finger_detail', ['finger' => $finger]);

        // 返回JSON格式的数据
        return json($finger);
    }


    public function datasafe_list(Request $request)
    {
        // 获取请求参数
        $params = $request->param();
        //给$params['domain']一个默认值
        $params['domain'] = $params['domain'] ?? '';
        $params['data'] = $params['data'] ?? '';

        //对domian参数进行模糊查询
        $detailObj = Db::table('datasafe_alerts')
            ->where('domain', 'like', '%' . $params['domain'] . '%')
            ->where('data', 'like', '%' . $params['data'] . '%')
            ->order('id', 'desc')
            ->select()->toArray();
        //把$detailObj里面的domain字段转换为一维数组
        $detailArr = array_column($detailObj, 'domain');
        // 没有搜索参数，查询全部数据
        $detailObj = Db::table('domains')->whereIn('domain', $detailArr)->order('id', 'desc')->paginate(['query' => $params, 'list_rows' => 5]);

        // 获取domains表中一共有多少条，需要随着搜索条件进行过滤
        $total = $detailObj->total();
        $detailArr = $detailObj->items();
        foreach ($detailArr as &$item) {
            // 使用domain 查询对应的域名
            $item['alert'] = Db::table('datasafe_alerts')->where('domain', $item['domain'])->select()->toArray();
        }

        return view('datasafe_list', [
            'detail' => $detailArr,
            'detailObj' => $detailObj,
            'total' => $total
        ]);
    }


    public function datasafe_detail($id)
    {
        // 根据ID查询详细数据
        $log = Db::table('http_logs')->where('id', $id)->find();

        // 返回JSON格式的数据
        return json($log);
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


}
