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
                <th>目录/说明</th>
                <th>要求</th>
                <th>检测结果</th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                <td>/</td>
                <td>读/写</td>
                <td><?php echo $statusarr['home']; ?></td>
                </tr>
                <tr>
                <td>/db</td>
                <td>读/写</td>
                <td><?php echo $statusarr['db']; ?></td>
                </tr>
                <tr>
                <td>组件</td>
                <td>pdo_sqlite </td>
                <td><?php echo $statusarr['pdo']; ?></td>
                </tr>
            </tbody>
            </table>
            <!-- 检测结果表格EDN -->
            <!-- 下一步按钮 -->
            <div>
                <a href="./install.php?setup=2" class="layui-btn">下一步</a>
            </div>
            <!-- 下一步按钮END -->
        </div>
    </div>
</div>