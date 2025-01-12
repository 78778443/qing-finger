public function datasafe_list(Request $request)
{
    // 1、接收前端传过来的搜索参数
    $domain = $request->param('domain');
    $where = [];
    //不为空的话，将搜索参数添加到where数组中
    if (!empty($domain)) {
        $where[] = ['domain', 'like', '%' . $domain . '%'];
    }
    //模糊查询domain
    
    //2、查询domains数据库，获取对应域名数据
    $logs = Db::table('domains')->where($where)->order('id', 'desc')->paginate(['query' => $request->param(), 'list_rows' => 5]);
    $count = $logs->total();
    //3、以域名为主键，查询datasafe_alerts数据库，获取对应详情数据

    //4、将2 3返回的数据组合为数组，返回给前端
}