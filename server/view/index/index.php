<!DOCTYPE html>
<html lang="zh">
<head>
    {include file="common/head" /}
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">
            <div class="w-64 bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-medium mb-4">流量过滤</h3>
                <form action="/index/index" method="get">
                    <div class="space-y-4">
                        <div>
                            <!--                            <label class="block text-sm font-medium text-gray-700 mb-1">时间范围</label>-->
                            <!--                            <input type="datetime-local" name="request_time" class="w-full border-gray-300 rounded-md text-sm"/>-->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">开始时间</label>
                                <input type="datetime-local" name="request_time"
                                       class="w-full border-gray-300 rounded-md text-sm"/>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">结束时间</label>
                                <input type="datetime-local" name="request_time"
                                       class="w-full border-gray-300 rounded-md text-sm"/>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">域名</label>
                            <input type="text" name="target_domain" class="w-full border-gray-300 rounded-md text-sm"
                                   placeholder="请输入域名"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IP地址</label>
                            <input type="text" name="source_ip" class="w-full border-gray-300 rounded-md text-sm"
                                   placeholder="请输入IP地址"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">请求类型</label>
                            <select name="request_type"
                                    class="w-full text-left border border-gray-300 rounded-md px-3 py-2 text-sm bg-white !rounded-button">
                                <option value="">全部</option>
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-custom text-white py-2 text-sm !rounded-button">
                            应用筛选
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex-1 space-y-6">
                <div class="bg-white rounded-lg shadow p-4 h-64">
                    <div id="trafficChart" class="w-full h-full"></div>
                </div>
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-medium">流量日志</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="logTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    时间
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    源IP
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    目标域名
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    请求类型
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    状态码
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    操作
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            {volist name="logs" id="log"}
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="showDetails({$log.id})">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$log.request_time}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$log.source_ip}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$log.target_domain}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$log.request_type}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$log.status_code}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{:URL('detail', ['id' => $log.id])}"
                                       class="text-custom hover:text-custom-dark">
                                        查看详情
                                    </a>
                                </td>
                            </tr>
                            {/volist}
                            </tbody>
                        </table>


                    </div>

                    <div id="details-panel" class="border-t border-gray-200 p-4">
                        <h4 class="text-lg font-medium mb-4">记录详情</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">请求时间</p>
                                <p class="text-sm font-medium" id="detail-request-time"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">源IP地址</p>
                                <p class="text-sm font-medium" id="detail-source-ip"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">目标域名</p>
                                <p class="text-sm font-medium" id="detail-target-domain"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">请求类型</p>
                                <p class="text-sm font-medium" id="detail-request-type"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">状态码</p>
                                <p class="text-sm font-medium" id="detail-status-code"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">响应大小</p>
                                <p class="text-sm font-medium" id="detail-response-size"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">请求头</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded" id="detail-request-header"></pre>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">响应头</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded" id="response"></pre>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class="text-sm text-gray-700">显示 1 到 5 条，共 {$count} 条</p>
                        {$logs|raw}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const chartDom = document.getElementById('trafficChart');
    const myChart = echarts.init(chartDom);

    const chartData = <?php echo json_encode($chartData); ?>;
    const times = chartData.map(item => item.time);
    const counts = chartData.map(item => item.count);

    const option = {
        title: {
            text: '实时流量统计'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: times
        },
        yAxis: {
            type: 'value',
            name: '请求数'
        },
        series: [
            {
                data: counts,
                type: 'line',
                smooth: true,
                color: '#000000'
            }
        ]
    };
    myChart.setOption(option);

    function showDetails(id) {
        fetch("{:URL('detail', ['id' => '__ID__'])}".replace('__ID__', id))
            .then(response => response.json())
            .then(data => {
                document.getElementById('detail-request-time').innerText = data.request_time;
                document.getElementById('detail-source-ip').innerText = data.source_ip;
                document.getElementById('detail-target-domain').innerText = data.target_domain;
                document.getElementById('detail-request-type').innerText = data.request_type;
                document.getElementById('detail-status-code').innerText = data.status_code;
                document.getElementById('detail-response-size').innerText = '1.2 MB'; // 假设固定值
                document.getElementById('detail-request-header').innerText = JSON.stringify({
                    "User-Agent": "Mozilla/5.0",
                    "Accept": "text/html"
                }, null, 2);
                document.getElementById('detail-response-header').innerText = JSON.stringify({
                    "Content-Type": "text/html",
                    "Server": "nginx/1.18.0"
                }, null, 2);
            });
    }
</script>
</body>
</html>
