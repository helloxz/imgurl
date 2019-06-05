<?php
    //读取版本号
    $content = file_get_contents(FCPATH."/data/version.txt");
    $content = explode("-",$content);
    $version = $content[0];
?>
<div class="layui-container" style = "margin-top:2em;">
    <div class="layui-row">
        <div class="layui-col-lg12">
            <div>
                <ol>
                    <li>1. 您当前使用的版本为<code style = "color:red;"><?php echo $version; ?></code></li>
                    <li>2. 升级之前请备份数据，升级之前请备份数据，升级之前请备份数据</li>
                    <li>3. 不要跨版本升级</li>
                    <li>4. 上述准备完成后，点击下方对应的版本进行升级</li>
                    <li>4. 没事不要乱点，否则后果自负</li>
                </ol>
            </div>
            <div style = "margin-top:1em;"><a href="/upgrade/v22_to_v23" class="layui-btn" target = "_blank">v2.2 > v2.3</a></div>
        </div>
    </div>
</div>