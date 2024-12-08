<!DOCTYPE html>
<html lang="zh">
<head>
    {include file="common/head" /}
</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
      <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">
          
          <div class="flex-1 space-y-6 w-full"><div class="bg-white rounded-lg shadow p-6"><h2 class="text-xl font-bold mb-6">数据安全告警</h2><div class="flex justify-between items-center mb-6"><div class="flex space-x-4"><select class="rounded-lg border-gray-300 text-sm"><option>全部类型</option><option>身份证信息泄露</option><option>API Key泄露</option><option>敏感数据导出</option><option>SQL注入攻击</option></select><select class="rounded-lg border-gray-300 text-sm"><option>全部风险等级</option><option>高危</option><option>中危</option><option>低危</option></select><select class="rounded-lg border-gray-300 text-sm"><option>全部状态</option><option>待处理</option><option>处理中</option><option>已处理</option></select><div class="relative"><input type="text" placeholder="搜索域名" class="rounded-lg border-gray-300 text-sm pl-8"/><i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i></div></div><div class="flex space-x-4"><button class="px-4 py-2 bg-custom text-white rounded-lg text-sm hover:bg-blue-600 transition-colors"><i class="fas fa-plus mr-2"></i>新增规则</button><button class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors"><i class="fas fa-download mr-2"></i>导出</button></div></div><div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">时间</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">告警类型</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">风险等级</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">域名</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">详情</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">状态</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th></tr></thead><tbody class="bg-white divide-y divide-gray-200"><tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-28 10:23:45</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">身份证信息泄露</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">高危</span></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">api.example.com</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">检测到未加密的身份证号码传输</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">待处理</span></td><td class="px-6 py-4 whitespace-nowrap text-sm"><button class="text-custom hover:text-blue-700 mr-3">处理</button><button class="text-gray-500 hover:text-gray-700">详情</button></td></tr><tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-28 10:20:15</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">API Key泄露</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">高危</span></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">admin.example.com</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">在日志中发现明文API密钥</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">已处理</span></td><td class="px-6 py-4 whitespace-nowrap text-sm"><button class="text-gray-500 hover:text-gray-700">详情</button></td></tr><tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-28 10:15:30</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">敏感数据导出</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">中危</span></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">data.example.com</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">大量用户数据导出操作</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">待处理</span></td><td class="px-6 py-4 whitespace-nowrap text-sm"><button class="text-custom hover:text-blue-700 mr-3">处理</button><button class="text-gray-500 hover:text-gray-700">详情</button></td></tr><tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-28 10:10:20</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">SQL注入攻击</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">高危</span></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">auth.example.com</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">检测到SQL注入攻击企图</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">已处理</span></td><td class="px-6 py-4 whitespace-nowrap text-sm"><button class="text-gray-500 hover:text-gray-700">详情</button></td></tr></tbody></table></div></div></div>
        </div>
      </div>
    </div>
    <script>
      const chartDom = document.getElementById('trafficChart');
      const myChart = echarts.init(chartDom);
      
      const option = {
        title: {
          text: '实时流量统计'
        },
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: ['10:00', '10:05', '10:10', '10:15', '10:20', '10:25', '10:30']
        },
        yAxis: {
          type: 'value',
          name: '请求数'
        },
        series: [
          {
            data: [150, 230, 224, 218, 135, 147, 260],
            type: 'line',
            smooth: true,
            color: '#000000'
          }
        ]
      };
      myChart.setOption(option);
    </script>
  
</body></html>
