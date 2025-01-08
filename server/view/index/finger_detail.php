<!DOCTYPE html>
<html lang="zh">
<head>
    <title>指纹详情</title
    {include file="common/head" /}
</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">

            <div class="flex-1 space-y-6 w-full">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between items-center">
                            <div class="mb-4"><a  href="{:URL('finger_list')}"
                                                 class="inline-flex items-center text-custom hover:text-blue-700"><i
                                            class="fas fa-arrow-left mr-2"></i>返回列表</a></div>
                            <div><h1 class="text-2xl font-bold text-gray-900">指纹详情 - FP24022801</h1>
                                <p class="mt-1 text-sm text-gray-500">创建时间：2024-02-28 10:30:15</p></div>
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">正常</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-8 mt-6">
                        <div class="space-y-6">
                            <div>
                                <div class="mb-6"><h3 class="text-lg font-medium text-gray-900 mb-2">指纹介绍</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg"><p class="text-gray-700">
                                            ThinkPHP是一个免费开源的，快速、简单的面向对象的轻量级PHP开发框架，是为了敏捷WEB应用开发和简化企业应用开发而诞生的。ThinkPHP从诞生以来一直秉承简洁实用的设计原则，在保持出色的性能和至简的代码的同时，也注重易用性。</p>
                                        <p class="text-gray-700 mt-2">
                                            该指纹用于识别运行ThinkPHP框架的Web应用，通过特定的HTTP响应头和页面特征进行匹配。当前指纹版本主要针对ThinkPHP
                                            5.1.39版本进行优化识别。</p></div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">基本信息</h3>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                                    <div class="flex justify-between"><span class="text-gray-600">指纹ID</span><span
                                                class="text-gray-900">FP24022801</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">指纹类型</span><span
                                                class="text-gray-900">ThinkPHP</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">应用版本</span><span
                                                class="text-gray-900">5.1.39</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">最后更新</span><span
                                                class="text-gray-900">2024-02-28 15:45:30</span></div>
                                </div>
                            </div>
                            <div><h3 class="text-lg font-medium text-gray-900 mb-2">匹配规则</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <pre class="text-sm text-gray-700">{<br/>  &#34;headers&#34;: {<br/>    &#34;Server&#34;: &#34;ThinkPHP&#34;,<br/>    &#34;X-Powered-By&#34;: &#34;PHP/7.4.0&#34;<br/>  },<br/>  &#34;body&#34;: &#34;ThinkPHP.*?5\.1\.39&#34;<br/>}</pre>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div><h3 class="text-lg font-medium text-gray-900 mb-2">历史漏洞</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-4">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <div><p class="text-sm font-medium text-gray-900">SQL 注入漏洞</p>
                                                    <p class="text-xs text-gray-500">CVE-2024-0001</p>
                                                    <p class="text-xs text-gray-500 mt-1">发现时间: 2024-01-15</p></div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">高危</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div><p class="text-sm font-medium text-gray-900">远程代码执行漏洞</p>
                                                    <p class="text-xs text-gray-500">CVE-2023-0458</p>
                                                    <p class="text-xs text-gray-500 mt-1">发现时间: 2023-11-20</p></div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">高危</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div><p class="text-sm font-medium text-gray-900">XSS 跨站脚本漏洞</p>
                                                    <p class="text-xs text-gray-500">CVE-2023-0234</p>
                                                    <p class="text-xs text-gray-500 mt-1">发现时间: 2023-08-05</p></div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">中危</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><h3 class="text-lg font-medium text-gray-900 mb-2">相关域名</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between"><span
                                                    class="text-sm text-gray-900">example1.com</span><span
                                                    class="text-xs text-gray-500">最后检测: 1小时前</span></div>
                                        <div class="flex items-center justify-between"><span
                                                    class="text-sm text-gray-900">example2.com</span><span
                                                    class="text-xs text-gray-500">最后检测: 2小时前</span></div>
                                        <div class="flex items-center justify-between"><span
                                                    class="text-sm text-gray-900">example3.com</span><span
                                                    class="text-xs text-gray-500">最后检测: 3小时前</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 mt-6">
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            编辑指纹
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-custom rounded-md hover:bg-blue-600">
                            更新检测
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
