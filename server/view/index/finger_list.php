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
                        <p class="mt-2 text-3xl font-semibold text-blue-500">{$total}</p>
<!--                        <p class="text-sm text-gray-500 mt-1">较昨日 +0.5%</p>-->
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900">重复指纹</h3>
                        <p class="mt-2 text-3xl font-semibold text-red-500">45</p>
                        <p class="text-sm text-gray-500 mt-1">较昨日 -12</p>
                    </div>
                </div>

                <!--列表展示框-->
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
                        {volist name="fingers" id="finger"}
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$finger.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{$finger.domain}</td>


                            <td class="px-6 py-4 text-sm text-gray-900">
                                {volist name="finger.finger" id="v3"}
                                <div class="space-y-2">
                                                                        <div>
                                    <span class="font-medium">{$v3.name}</span>
                                    <p class="text-gray-500 text-xs">版本：{$v3.version} 服务器：{$v3.servicer}
                                        编程语言：{$v3.language}</p>
<!--                                    <p class="text-gray-500 text-xs">创建时间：{//$v3.created_at}</p>-->
                                                                        </div>
                                </div>
                                {/volist}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{//$v3.description}</td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="#" class="detail-link">查看详情</a>
                            </td>
                        </tr>
                        </tbody>
                        {/volist}
                    </table>
                    <div class="flex justify-between items-center mt-4">
                        <p class="text-sm text-gray-700"> 显示 1 到 5 条，共 {$total} 条</p>
                        <div class="pagination">{$domainObj|raw}</div>
                    </div>
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
