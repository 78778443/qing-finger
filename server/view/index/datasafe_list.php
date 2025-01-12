<!DOCTYPE html>
<html lang="zh">
<head>
    <title>数据安全</title>
    {include file="common/head" /}
    <style>
        .pagination {
            display: flex;
            gap: 0.5rem; /* 调整分页链接之间的间距 */
            padding: 0.5rem;
        }

        .scrollable-pre {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 700px; /* 根据需要调整宽度 */
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">
            <div class="flex-1 space-y-6 w-full">
                <div class="bg-white rounded-lg shadow p-6"><h2 class="text-xl font-bold mb-6">数据安全告警</h2>
                    <div class="flex justify-between items-center mb-6">
                        <form action="/index/datasafe_list" method="get">
                            <div class="flex space-x-4">
                                <select class="rounded-lg border-gray-300 text-sm">
                                    <option>全部类型</option>
                                    <option></option>
                                </select>
                                <select name="" class="rounded-lg border-gray-300 text-sm">
                                    <option value="">全部状态</option>
                                    <option>待处理</option>
                                    <option>处理中</option>
                                    <option>已处理</option>
                                </select>
                                <div class="relative">
                                    <input type="text" name="domain" placeholder="搜索域名"
                                           class="rounded-lg border-gray-300 text-sm pl-8"/>
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <div class="relative">
                                    <input type="text" name="data" placeholder="搜索详情"
                                           class="rounded-lg border-gray-300 text-sm pl-8"/>
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <div>
                                    <button type="submit"
                                            class="px-4 py-2 text-sm text-white text-gray-700 bg-custom rounded-md hover:bg-blue-600">
                                        搜索
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    域名
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    详情
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    时间
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    操作
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            {volist name="detail" id="alert"}
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{$alert.domain}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {volist name="alert" id="erji"}
                                    {volist name="erji" id="data"}
                                    <div id="{$alert.domain}">
                                        <pre class="scrollable-pre"><code> <span>{$data.data}</span></code></pre>
                                        <a href="{:URL('datasafe_detail', ['id' => $data.http_id])}"
                                           class="text-custom hover:text-custom-dark">
                                            查看详情
                                        </a>
                                    </div>
                                    {/volist}
                                    {/volist}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{//$erji.alert_time}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button class="text-custom hover:text-blue-700 mr-3">处理</button>
                                    <button class="text-gray-500 hover:text-gray-700">详情</button>
                                </td>
                            </tr>
                            {/volist}
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center mt-4">
                            <p class="text-sm text-gray-700">显示 1 到 5 条，共 {$total} 条</p>
                            <div class="pagination">{$detailObj|raw}</div>
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