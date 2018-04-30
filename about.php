<?php
    $title = "ImgURL - 简单、纯粹的图床程序。";
    include_once("./tpl/user/header.php");
?>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-lg10 layui-col-md-offset1" id = "about">
            <h1>ImgURL</h1>
			<p>ImgURL是一款简洁、纯粹的图床程序，使用PHP + Sqlite开发，开箱即用。</p>
			<h3>功能与特色</h3>
			<ul>
				<li>拽拖上传图片、实时预览</li>
				<li>一键生成链接，一键复制</li>
				<li>基本图片管理</li>
				<li>TinyPNG图片压缩</li>
				<li>图片智能鉴黄</li>
			</ul>
			<h3>使用说明</h3>
            <ul>
                <li>图片最大上传限制为2M</li>
                <li>游客每天限制上传5张图片</li>
                <li>图片定期清理，重要图片建议自行下载ImgURL部署</li>
                <li>勿上传暴力、色情、反动图片，否则后果自负</li>
                <li>如果您使用ImgURL代表同意以上协议</li>
            </ul>
			<h3>联系我</h3>
			<ul>
				<li>Blog:<a href = "https://www.xiaoz.me/" target = "_blank">https://www.xiaoz.me/</a></li>
				<li>QQ:337003006</li>
			</ul>
        </div>
    </div>
</div>

<?php
    include_once("./tpl/user/footer.php");
?>