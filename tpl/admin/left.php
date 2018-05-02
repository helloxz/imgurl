 <!-- 左边导航栏 -->
 <div class="layui-col-lg3">
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">图片管理<span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                    <dd><a href="picadmin.php?type=user&page=1">游客上传</a></dd>
                    <dd><a href="picadmin.php?type=admin&page=1">管理员上传</a></dd>
                    <dd><a href="picadmin.php?type=dubious&page=1">可疑图片</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">高级管理<span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                    <dd><a href="senioradmin.php?type=user&page=1">游客上传</a></dd>
                    <dd><a href="senioradmin.php?type=admin&page=1">管理员上传</a></dd>
                    <dd><a href="senioradmin.php?type=dubious&page=1">可疑图片</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">系统设置<span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                    <dd><a href="javascript:;" onclick = "about()">关于</a></dd>
                    </dl>
                </li>
                <span class="layui-nav-bar" style="top: 157.5px; height: 0px; opacity: 0;"></span></ul>
            </div>
            <!-- 左边导航栏END -->