<div class="layui-container" style = "margin-top:2em;margin-bottom:6em;">
    <div class="layui-row layui-col-space10 showimgs" id = "showimgs">
        <?php 
                foreach ($imgs as $img)
                {
                    //一些简单的逻辑处理 
                    //获取缩略图地址
                    $thumbpath = thumbnail($img);
                    $thumburl = $domain.$thumbpath;
                    //源图像地址
                    $img_url = $domain.$img['path'];
                    //判断是否压缩设置不同样式的CSS
                    if($img['compression'] == 1){
                        $css = 'layui-btn-normal';
                    }
                    else{
                        $css = 'layui-btn-primary';
                    }
                    //如果是可疑图片
                    if($img['level'] == 'adult'){
                        $thumburl = $domain.'/static/images/dubious_290.png';

                    }
            ?>
            <div class="layui-col-lg3" id = "img<?php echo $img['id']; ?>">
                <div class = "operate">
                    <!-- 选择按钮 -->
                    <div class = "choose"><input type="checkbox" name="chk" value = "<?php echo $img['id']; ?>"></div>
                    <!-- 压缩图标 -->
                    <div>
                        <button class="layui-btn  layui-btn-xs <?php echo $css; ?>" title = "压缩图片" onclick = "compress(<?php echo $img['id']; ?>)">
                        <i class="fa fa-compress"></i>
                        </button>  
                    </div>
                    <!-- 链接图标 -->
                    <div>
                        <button class="layui-btn  layui-btn-xs layui-btn-normal" title = "获取图片链接" onclick = "showlink('<?php echo $img_url; ?>','<?php echo $thumburl; ?>')">
                        <i class="fa fa-link"></i>
                        </button>  
                    </div>
                    <!-- 信息图标 -->
                    <div>
                        <button class="layui-btn  layui-btn-xs layui-btn-normal" title = "查看图片信息" onclick = "imginfo('<?php echo $img['imgid']; ?>','<?php echo $img['client_name']; ?>')">
                            <i class="fa fa-info-circle"></i>
                        </button>  
                    </div>
                    <!-- 直达链接 -->
                    <div>
                        <a href="/img/<?php echo $img['imgid']; ?>" target = "_blank" class="layui-btn layui-btn-xs layui-btn-normal"><i class="fa fa-globe"></i></a>
                    </div>
                    <!-- 删除按钮 -->
                    <div>
                        <button class="layui-btn  layui-btn-xs layui-btn-danger" title = "删除这张图片" onclick = "del_img('<?php echo $img['id']; ?>','<?php echo $img['imgid'] ?>','<?php echo $img['path']; ?>','<?php echo $thumbpath; ?>')">
                            <i class="fa fa-trash-o"></i>
                        </button>  
                    </div>
                    <!-- 取消可疑状态 -->
                    <?php if($img['level'] == 'adult'){ ?>
                    <div>
                        <button class="layui-btn  layui-btn-xs" title = "取消可疑状态" onclick = "cancel(<?php echo $img['id']; ?>)">
                            <i class="fa fa-check"></i>
                        </button>  
                    </div>
                    <?php } ?>
                </div>
                <div class = "img_thumb">
                    <img src="<?php echo $thumburl; ?>" alt="<?php echo $img['client_name']; ?>" layer-src= "<?php echo $img_url; ?>" lay-src = "<?php echo $thumburl; ?>">
                </div>
            </div>
            <?php
            } 
        ?>
	</div>
	<!-- 分页按钮 -->
	<div class="layui-row" style = "margin-top:2em;">
		<div class="layui-col-lg6" id = "paging">
            <?php echo $page; ?>
        </div>
        <div class="layui-col-lg6">
            <!-- <button class="layui-btn layui-btn-xs" id = "checkAll">全选</button>--> <label>选中项：</label><button class="layui-btn layui-btn-xs layui-btn-danger" onclick = "del_more()">删除</button> 
        </div>
	</div>
	<!-- 分页按钮 -->
</div>

