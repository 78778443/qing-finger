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
                        <label class="block text-sm font-medium text-gray-700 mb-1">IP地址</label>
                        <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                               placeholder="请输入IP地址"/>
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
                    <button class="w-full bg-custom text-white py-2 text-sm !rounded-button">
                        应用筛选
                    </button>
                </div>
            </div>
            <div class="flex-1 space-y-6">
                <div class="bg-white rounded-lg shadow p-4 h-48">
                    <div id="trafficChart" class="w-full h-full"></div>
                </div>
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="mb-4">
                        <button><a href="{:URL('index')}"
                                   class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-md flex items-center gap-2 !rounded-button">
                                <i class="fas fa-arrow-left"></i>返回列表
                            </a></button>

                    </div>
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-medium">原始请求内容</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    请求方法
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    请求路径
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    协议
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    发送时间
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">GET</td>
                                <td class="px-6 py-4 text-sm text-gray-900 break-all">
                                    <pre class="whitespace-pre-wrap font-normal">/api/users?page=1&amp;size=10&amp;sort=createTime,desc&amp;filter=active&amp;search=test</pre>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">HTTP/1.1</td>
                                <td class="px-6 py-4 text-sm text-gray-900">2024-02-28 10:23:45</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="details-panel" class="border-t border-gray-200 p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><p class="text-sm text-gray-500">请求时间</p>
                                <p class="text-sm font-medium">2024-02-28 10:23:45</p></div>
                            <div><p class="text-sm text-gray-500">源IP地址</p>
                                <p class="text-sm font-medium">192.168.1.100</p></div>
                            <div><p class="text-sm text-gray-500">目标域名</p>
                                <p class="text-sm font-medium">example.com</p></div>
                            <div><p class="text-sm text-gray-500">请求类型</p>
                                <p class="text-sm font-medium">GET</p></div>
                            <div><p class="text-sm text-gray-500">状态码</p>
                                <p class="text-sm font-medium">200</p></div>
                            <div><p class="text-sm text-gray-500">响应大小</p>
                                <p class="text-sm font-medium">1.2 MB</p></div>
                            <div class="col-span-2 mt-4"><p class="text-sm text-gray-500">请求头</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded language-json">{
  &#34;User-Agent&#34;: &#34;Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36&#34;,
  &#34;Accept&#34;: &#34;text/html,application/json&#34;,
  &#34;Accept-Language&#34;: &#34;zh-CN,zh;q=0.9,en;q=0.8&#34;,
  &#34;Accept-Encoding&#34;: &#34;gzip, deflate, br&#34;,
  &#34;Connection&#34;: &#34;keep-alive&#34;,
  &#34;Cookie&#34;: &#34;sessionid=abc123; user_id=12345&#34;,
  &#34;Authorization&#34;: &#34;Bearer eyJhbGciOiJIUzI1NiIs...&#34;
}</pre>
                            </div>
                            <div class="col-span-2 mt-4"><p class="text-sm text-gray-500">响应头</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded language-json">{
  &#34;Content-Type&#34;: &#34;application/json; charset=utf-8&#34;,
  &#34;Server&#34;: &#34;nginx/1.18.0&#34;,
  &#34;Date&#34;: &#34;Wed, 28 Feb 2024 02:23:46 GMT&#34;,
  &#34;Content-Length&#34;: &#34;1240&#34;,
  &#34;Connection&#34;: &#34;keep-alive&#34;,
  &#34;X-Request-ID&#34;: &#34;f28b5e11-9cc5-4c25-b68c-8a89d82b3c05&#34;,
  &#34;Access-Control-Allow-Origin&#34;: &#34;*&#34;,
  &#34;Cache-Control&#34;: &#34;no-cache&#34;,
  &#34;ETag&#34;: &#34;W/\&#34;4d8-Kgd2LHlk3trimIoGePBpYYuuQy8\&#34;&#34;
}</pre>
                            </div>
                            <div class="col-span-2 mt-4"><p class="text-sm text-gray-500">请求Body</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded language-json">{
  &#34;Content-Type&#34;: &#34;application/json; charset=utf-8&#34;,
  &#34;Server&#34;: &#34;nginx/1.18.0&#34;,
  &#34;Date&#34;: &#34;Wed, 28 Feb 2024 02:23:46 GMT&#34;,
  &#34;Content-Length&#34;: &#34;1240&#34;,
  &#34;Connection&#34;: &#34;keep-alive&#34;,
  &#34;X-Request-ID&#34;: &#34;f28b5e11-9cc5-4c25-b68c-8a89d82b3c05&#34;,
  &#34;Access-Control-Allow-Origin&#34;: &#34;*&#34;,
  &#34;Cache-Control&#34;: &#34;no-cache&#34;,
  &#34;ETag&#34;: &#34;W/\&#34;4d8-Kgd2LHlk3trimIoGePBpYYuuQy8\&#34;&#34;
}</pre>
                            </div>
                            <div class="col-span-2 mt-4"><p class="text-sm text-gray-500">响应Body</p>
                                <pre class="mt-1 text-sm bg-gray-50 p-2 rounded language-json">{
  &#34;Content-Type&#34;: &#34;application/json; charset=utf-8&#34;,
  &#34;Server&#34;: &#34;nginx/1.18.0&#34;,
  &#34;Date&#34;: &#34;Wed, 28 Feb 2024 02:23:46 GMT&#34;,
  &#34;Content-Length&#34;: &#34;1240&#34;,
  &#34;Connection&#34;: &#34;keep-alive&#34;,
  &#34;X-Request-ID&#34;: &#34;f28b5e11-9cc5-4c25-b68c-8a89d82b3c05&#34;,
  &#34;Access-Control-Allow-Origin&#34;: &#34;*&#34;,
  &#34;Cache-Control&#34;: &#34;no-cache&#34;,
  &#34;ETag&#34;: &#34;W/\&#34;4d8-Kgd2LHlk3trimIoGePBpYYuuQy8\&#34;&#34;
}</pre></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 py-3 border-b border-gray-200"><h3 class="text-lg font-medium">响应内容</h3></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    状态码
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Content-Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Content-Length
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    响应时间
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">200 OK</td>
                                <td class="px-6 py-4 text-sm text-gray-900"><pre
                                            class="whitespace-pre-wrap font-normal">application/json; charset=utf-8
Cache-Control: no-cache
Access-Control-Allow-Origin: *</pre>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">1240 bytes</td>
                                <td class="px-6 py-4 text-sm text-gray-900">2024-02-28 10:23:46</td>
                            </tr>
                            </tbody>
                        </table>
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
