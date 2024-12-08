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
            <div class="w-64 bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-medium mb-4">请求过滤</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">时间范围</label>
                        <input type="datetime-local" class="w-full border-gray-300 rounded-md text-sm"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">域名</label>
                        <input type="text" class="w-full border-gray-300 rounded-md text-sm" placeholder="请输入域名"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">请求类型</label>
                        <div class="relative">
                            <button class="w-full text-left border border-gray-300 rounded-md px-3 py-2 text-sm bg-white !rounded-button">
                                <span>全部</span>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2"></i>
                            </button>
                        </div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">指纹类型</label>
                        <div class="relative">
                            <button class="w-full text-left border border-gray-300 rounded-md px-3 py-2 text-sm bg-white !rounded-button">
                                <span>全部类型</span><i
                                        class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2"></i>
                            </button>
                        </div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">域名筛选</label>
                        <input type="text"
                               class="w-full border-gray-300 rounded-md text-sm"
                               placeholder="请输入域名关键词"/>
                    </div>
                    <button class="w-full bg-custom text-white py-2 text-sm !rounded-button mt-4">
                        应用筛选
                    </button>
                </div>
            </div>
            <div class="flex-1 space-y-6">
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-lg font-medium text-gray-900">
                            总指纹数</h3>
                        <p class="mt-2 text-3xl font-semibold text-custom">12,456</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 +123</p></div>
                    <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-lg font-medium text-gray-900">
                            今日新增</h3>
                        <p class="mt-2 text-3xl font-semibold text-green-500">234</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 +45</p></div>
                    <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-lg font-medium text-gray-900">
                            识别准确率</h3>
                        <p class="mt-2 text-3xl font-semibold text-blue-500">98.5%</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 +0.5%</p></div>
                    <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-lg font-medium text-gray-900">
                            重复指纹</h3>
                        <p class="mt-2 text-3xl font-semibold text-red-500">45</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 -12</p></div>
                </div>
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center"><h3
                                class="text-lg font-medium">指纹列表</h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 text-sm bg-custom text-white rounded-md">新建指纹</button>
                            <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-md">批量导入</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex gap-4 mb-4"><input type="text" placeholder="搜索指纹ID、名称、特征值..."
                                                            class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm"/><select
                                    class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                                <option>全部类型</option>
                                <option>ThinkPHP</option>
                                <option>Nginx</option>
                                <option>Apache</option>
                            </select><select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                                <option>全部状态</option>
                                <option>正常</option>
                                <option>异常</option>
                                <option>待验证</option>
                            </select></div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">指纹ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">域名</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">指纹类型
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">状态</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">创建时间
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">操作</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">FP24022801</td>
                                <td class="px-6 py-4 text-sm text-gray-900">example1.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">ThinkPHP</td>
                                <td class="px-6 py-4 text-sm"><span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">正常</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">2024-02-28</td>
                                <td class="px-6 py-4 text-sm"><a  href="{:URL('finger_detail')}" class="text-custom hover:underline">查看</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">FP24022802</td>
                                <td class="px-6 py-4 text-sm text-gray-900">example2.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Nginx</td>
                                <td class="px-6 py-4 text-sm"><span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">待验证</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">2024-02-28</td>
                                <td class="px-6 py-4 text-sm"><a  href="{:URL('finger_detail')}" class="text-custom hover:underline">查看</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">FP24022803</td>
                                <td class="px-6 py-4 text-sm text-gray-900">example3.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Apache</td>
                                <td class="px-6 py-4 text-sm"><span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">异常</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">2024-02-28</td>
                                <td class="px-6 py-4 text-sm"><a  href="{:URL('finger_detail')}" class="text-custom hover:underline">查看</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center mt-4"><p class="text-sm text-gray-700">显示 1 到
                                10 条，共 53 条</p>
                            <div class="flex gap-2">
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded-md disabled:opacity-50">
                                    上一页
                                </button>
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded-md">下一页</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

</body>
</html>