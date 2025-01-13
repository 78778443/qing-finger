<!DOCTYPE html>
<html lang="zh">
<head>
    <title>指纹中心</title
            {include file="common/head" /}
    <script type="text/javascript">
        function toggleDetails(rowId) {
            var details = document.getElementById('details-' + rowId);
            if (details.style.display === 'none') {
                details.style.display = 'table-row';
            } else {
                details.style.display = 'none';
            }
        }

        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#64748b'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '2px',
                        DEFAULT: '4px',
                        'md': '8px',
                        'lg': '12px',
                        'xl': '16px',
                        '2xl': '20px',
                        '3xl': '24px',
                        'full': '9999px',
                        'button': '4px'
                    }
                }
            }
        }
    </script>
    <style>

        .hidden {
            display: none;
        }

        .pagination {
            display: flex;
            gap: 0.5rem; /* 调整分页链接之间的间距 */
            padding: 0.5rem;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        .table-header {
            background-color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
    </style>

</head>
<body>
<div class="min-h-screen bg-gray-50">
    {include file="common/nav" /}
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">
            <div class="w-64 bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-medium mb-4">请求过滤</h3>
                <form action="/index/finger_list" method="get">
                    <div class="space-y-4">
                        <!--                        <div>-->
                        <!--                            <label class="block text-sm font-medium text-gray-700 mb-1">时间范围</label>-->
                        <!--                            <input type="datetime-local" class="w-full border-gray-300 rounded-md text-sm"/>-->
                        <!--                        </div>-->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">域名</label>
                            <input type="text" name="domain" class="w-full border-gray-300 rounded-md text-sm"
                                   placeholder="请输入域名"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">指纹名称</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md text-sm"
                                   placeholder="请输入指纹名称"/>
                        </div>
                        <button class="w-full bg-custom text-white py-2 text-sm !rounded-button mt-4">
                            应用筛选
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex-1 space-y-6">

                <!--四个数据展示框-->
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900">总指纹数</h3>
                        <p class="mt-2 text-3xl font-semibold text-custom"><?= number_format($totalCount) ?></p>
                        <p class="text-sm text-gray-500 mt-1">
                            较昨日 <?= $totalDifference >= 0 ? '+' : '' ?><?= number_format($totalDifference) ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900">今日新增</h3>
                        <p class="mt-2 text-3xl font-semibold text-green-500">{$count}</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 {if $difference >= 0}+{/if}{$difference}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900">总域名数</h3>
                        <p class="mt-2 text-3xl font-semibold text-blue-500">98.5%</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 +0.5%</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900">重复指纹</h3>
                        <p class="mt-2 text-3xl font-semibold text-red-500">45</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 -12</p>
                    </div>
                </div>
                <!--列表框-->
                <!--                <div class="bg-white rounded-lg shadow">-->
                <!--                    <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center"><h3-->
                <!--                                class="text-lg font-medium">指纹列表</h3>-->
                <!--                    </div>-->
                <!--                    <div class="p-4">-->
                <!---->
                <!--                        <table class="min-w-full divide-y divide-gray-200">-->
                <!--                            <thead class="bg-gray-50">-->
                <!--                            <tr>-->
                <!--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">指纹ID</th>-->
                <!--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">域名</th>-->
                <!--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">指纹名称-->
                <!--                                </th>-->
                <!--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">描述</th>-->
                <!--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">操作</th>-->
                <!--                            </tr>-->
                <!--                            </thead>-->
                <!--                            <tbody class="divide-y divide-gray-200">-->
                <!--                            {volist name="fingers" id="finger"}-->
                <!--                            <tr>-->
                <!--                                <td class="px-6 py-4 text-sm text-gray-900">{$finger.id}</td>-->
                <!--                                <td class="px-6 py-4 text-sm text-gray-900">{$finger.domain}</td>-->
                <!--                                <td class="px-6 py-4 text-sm text-gray-900">-->
                <!--                                    {volist name="finger" id="v2"}-->
                <!--                                    {volist name="v2" id="v3"}-->
                <!--                                    <div id="{$v3.domain}">-->
                <!--                                        <pre class="scrollable-pre"><code> <span>指纹名称：{$v3.name}</span></code></pre>-->
                <!--                                        <h6>版本：{$v3.version} 服务器：{$v3.servicer} 编程语言：{$v3.language}-->
                <!--                                            创建时间：{$v3.created_at}</h6>-->
                <!--                                        <a href="{:URL('finger_detail', ['id' => $v3.finger_id])}"-->
                <!--                                           class="text-custom hover:text-custom-dark">-->
                <!--                                            查看详情-->
                <!--                                        </a>-->
                <!--                                    </div>-->
                <!--                                    {/volist}-->
                <!--                                    {/volist}-->
                <!--                                </td>-->
                <!--                            </tr>-->
                <!--                            {/volist}-->
                <!--                            </tbody>-->
                <!--                        </table>-->
                <!--                        <div class="flex justify-between items-center mt-4">-->
                <!--                            <p class="text-sm text-gray-700">显示 1 到 10 条，共 {$tiaoshu} 条域名</p>-->
                <!--                            <div class="pagination">{//$fingers|raw}</div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="table-header">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">指纹 ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">域名</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">指纹名称</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">描述</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">操作</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        {volist name="fingers" id="finger"}
                        <!--域名-->
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 text-sm text-gray-900" rowspan="3">{$finger.id}</td>
                            <td class="px-6 py-4 text-sm text-gray-900" rowspan="3">{$finger.domain}</td>
                        </tr>
                        {volist name="finger" id="v2"}
                        {volist name="v2" id="v3"}
                        <tr class="table-row-hover">
                            <!--指纹名称-->
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <div class="text-sm text-gray-900">{$v3.name}</div>
                                    <div class="text-sm text-gray-900">{$v3.version}</div>
                                </div>
                            </td>
                            <!--描述-->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{$v3.servicer}</div>
                                <div class="text-sm text-gray-500">{$v3.language}</div>
                                <div class="text-sm text-gray-500">{$v3.created_at}</div>
                            </td>
                            <td class="px-6 py-4">
                                <button class="text-primary hover:text-primary/80 text-sm">查看详情</button>
                            </td>
                        </tr>
                        {/volist}{/volist}

                        {/volist}
                        </tbody>
                    </table>
                </div>

                <!--                结尾-->
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
