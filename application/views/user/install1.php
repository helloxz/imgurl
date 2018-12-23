<div class="layui-container">
    <div class="layui-row" style = "margin-top:2em;">
        <div class="layui-col-lg8 layui-col-md-offset2">
            <center style = "margin-bottom:2em;"><h1>ImgURL安装向导（1/3）</h1></center>
            <!-- 检测结果表格 -->
            <table class="layui-table">
            <colgroup>
                <col width="220">
                <col width="220">
                <col>
            </colgroup>
            <thead>
                <tr>
                <th>名称</th>
                <th>要求</th>
                <th>当前信息</th>
                <th>检测结果</th>
                </tr> 
            </thead>
            <tbody>
                <?php foreach($env as $value) { ?>
                <tr>
                    <?php foreach($value as $info) { ?>
                    <td>
                        <?php
                            if($info == FALSE){
                                echo '<span style = "color:red;">不支持！</span>';
                            }
                            else{
                                echo $info;
                            }
                        ?>
                    </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
            </table>
            <!-- 检测结果表格EDN -->
            <!-- 下一步按钮 -->
            <div>
                <!-- 对检测结果进行判断 -->
                <?php
                    if($sum === NULL){
                        echo '<a href="/install/?setup=2" class="layui-btn" id = "next">下一步</a>';
                    }
                    elseif($sum === FALSE){
                        echo '<span style = "color:red;">您必须先解决上述问题才能进一步安装！</span>';
                    }
                ?>
            </div>
            <!-- 下一步按钮END -->
        </div>
    </div>
</div>