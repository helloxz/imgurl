<!-- 内容部分 -->
<div id="container">
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-lg4 layui-col-md-offset4">
                <!-- 登录表单 -->
                <div class="login">
                    <h2 style = "padding-bottom:0.6em;color:#FFFFFF;">当前用户名为: <code style = "color:#FF5722;"><?php echo $username; ?></code>，请设置新密码。</h2>
                    <div class="layui-form-item">
                        <input id = "password1" type="password" required  lay-verify="required" placeholder="设置新密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                         <input id = "password2" type="password" name="password" required lay-verify="required" placeholder="确认新密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" lay-submit lay-filter="formDemo" onclick = "resetpass()">设置密码</button>
                    </div>
                </div>
                <!-- 登录表单END -->
            </div>
        </div>
    </div>
</div>
<!-- 内容部分end -->