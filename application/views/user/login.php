<!-- 内容部分 -->
<div id="container">
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-lg4 layui-col-md-offset4">
                <!-- 登录表单 -->
                <div class="login">
                    <div class="layui-form-item">
                        <input id = "user" type="text" name="title" required  lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                         <input id = "password" type="password" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" lay-submit lay-filter="formDemo" onclick = "login()">登录</button>
                    </div>
                </div>
                <!-- 登录表单END -->
            </div>
        </div>
    </div>
</div>
<!-- 内容部分end -->