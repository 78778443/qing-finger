<!DOCTYPE html>
<html lang="zh">
<head>
    <系统设置>
    {include file="common/head" /}
</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">

            <div class="flex-1 space-y-6 w-full">
                <div class="bg-white rounded-lg shadow p-6"><h2 class="text-xl font-bold mb-6">流程配置</h2>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="space-y-4"><h3 class="text-lg font-medium">数据库配置</h3>
                                <div class="space-y-4">
                                    <div class="flex flex-col"><label class="text-sm font-medium text-gray-700 mb-1">数据库地址</label><input
                                                type="text" class="border rounded-md p-2"
                                                value="mongodb://localhost:27017/fingerprint"/></div>
                                    <div class="flex flex-col"><label class="text-sm font-medium text-gray-700 mb-1">数据库凭证</label><textarea
                                                class="border rounded-md p-2" rows="3">username:password</textarea>
                                    </div>
                                    <div class="flex items-center justify-between"><span
                                                class="text-sm font-medium text-gray-700">启用数据库连接</span><label
                                                class="switch"><input type="checkbox" checked=""/><span
                                                    class="slider round"></span></label></div>
                                </div>
                            </div>
                            <div class="space-y-4 mt-8"><h3 class="text-lg font-medium">API 配置</h3>
                                <div class="space-y-4">
                                    <div class="flex flex-col"><label class="text-sm font-medium text-gray-700 mb-1">GPT
                                            API Key</label><input type="text" class="border rounded-md p-2"
                                                                  value="sk-xxxxxxxxxxxxxxxxxxxxxxxx"/></div>
                                    <div class="flex items-center justify-between"><span
                                                class="text-sm font-medium text-gray-700">启用 GPT 服务</span><label
                                                class="switch"><input type="checkbox" checked=""/><span
                                                    class="slider round"></span></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-4"><h3 class="text-lg font-medium">服务配置</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between"><span
                                                class="text-sm font-medium text-gray-700">开启请求转发</span><label
                                                class="switch"><input type="checkbox" checked=""/><span
                                                    class="slider round"></span></label></div>
                                    <div class="flex flex-col"><label class="text-sm font-medium text-gray-700 mb-1">服务监听地址</label><input
                                                type="email" class="border rounded-md p-2"
                                                value="http://localhost:3000"/></div>
                                    <div class="flex items-center justify-between"><span
                                                class="text-sm font-medium text-gray-700">开启数据记录</span><label
                                                class="switch"><input type="checkbox"/><span
                                                    class="slider round"></span></label></div>
                                </div>
                            </div>
                            <div class="space-y-4 mt-8"><h3 class="text-lg font-medium">日志配置</h3>
                                <div class="space-y-4">
                                    <div class="flex flex-col"><label class="text-sm font-medium text-gray-700 mb-1">日志保留时间</label><select
                                                class="border rounded-md p-2">
                                            <option>30天</option>
                                            <option>60天</option>
                                            <option>90天</option>
                                            <option>180天</option>
                                        </select></div>
                                    <div class="flex items-center justify-between"><span
                                                class="text-sm font-medium text-gray-700">自动清理日志</span><label
                                                class="switch"><input type="checkbox" checked=""/><span
                                                    class="slider round"></span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 mt-6">
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            重置
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-custom rounded-md hover:bg-blue-600">
                            保存设置
                        </button>
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
