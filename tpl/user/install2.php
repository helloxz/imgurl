<div class="layui-container">
    <div class="layui-row" style = "margin-top:2em;">
        <div class="layui-col-lg8 layui-col-md-offset2">
        <center style = "margin-bottom:2em;"><h1>ImgURL安装向导（2/3）</h1></center>
            <!-- 表单 -->
            <form class="layui-form" action="./install.php?setup=3" method = "post">
            <div class="layui-form-item">
                <label class="layui-form-label">站点路径</label>
                <div class="layui-input-block">
                <input type="text" name="homedir" required  lay-verify="required" placeholder="一般保持默认" autocomplete="off" class="layui-input" value = <?php echo $info['homedir']; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">站点域名</label>
                <div class="layui-input-block">
                <input type="text" name="domain" required  lay-verify="required" placeholder="一般保持默认" autocomplete="off" class="layui-input" value = <?php echo $info['domain']; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                <input type="text" name="user" required  lay-verify="required" placeholder="字母或数字组合" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                <input type="password" name="pass1" required  lay-verify="required" placeholder="设置密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-block">
                <input type="password" name="pass2" required  lay-verify="required" placeholder="再次确认密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                <a href="./install.php?setup=1" class="layui-btn">上一步</a>
                <button class="layui-btn" lay-submit lay-filter="formDemo">开始安装</button>
                </div>
            </div>
            </form>
            <!-- 表单EDN -->
            <!-- 下一步按钮 -->
            
            <!-- 下一步按钮END -->
        </div>
    </div>
</div>