<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-[&#39;Pacifico&#39;] text-custom">Qing Finger</span>
                </div>
                <div class="ml-10 flex space-x-8">
                    <a href="{:URL('index')}"
                       class="text-gray-500 px-1 inline-flex items-center h-16 hover:text-custom">流量监控</a>
                    <a href="{:URL('finger_list')}" class="text-gray-500 px-1 inline-flex items-center h-16 hover:text-custom">指纹中心</a>
                    <a href="{:URL('datasafe_list')}" class="text-gray-500 px-1 inline-flex items-center h-16 hover:text-custom">数据安全</a>
<!--                    <a href="#"  class="border-b-2 border-custom text-custom px-1 inline-flex items-center h-16">数据安全</a>-->

                    <a href="{:URL('system_setting')}"
                       class="text-gray-500 px-1 inline-flex items-center h-16 hover:text-custom">系统设置</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full"
                         src="/static/images/logo.jpg"
                         alt="用户头像"/>
                    <span class="ml-2 text-sm text-gray-700">Daxia</span>
                </div>
                <button class="ml-4 px-3 py-1 text-sm text-gray-700 hover:text-custom !rounded-button">
                    退出
                </button>
            </div>
        </div>
    </div>
</nav>