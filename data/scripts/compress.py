#!/usr/bin/python
# -*- coding: utf-8 -*-
#####	name: 图片批量压缩		#####
#####	author: xiaoz.me		#####
##### 	update: 2018-03-13		#####

import sqlite3
import os


#图片根目录
global imgpath
#设置图片绝对路径
imgpath = '/data/wwwroot/test.imgurl.org'
conn = sqlite3.connect(imgpath + "/data/imgurl.db3")


c = conn.cursor()
#查询10张没有压缩的图片
imgs = c.execute("SELECT a.path,a.compression,b.mime,b.ext,a.id FROM img_images AS a INNER JOIN img_imginfo b ON a.imgid = b.imgid AND a.compression = 0 ORDER BY a.id DESC LIMIT 10")

#更新图片状态，compression标记为1，标识已经压缩
def upimg(imgid):
	u = conn.cursor()
	#更新数据库
	upimg = u.execute("UPDATE img_images SET compression = 1 WHERE `id` = " + str(imgid))
	conn.commit()

#压缩图片的函数
def compress(mime,path,imgid):
	#图片完整路径
	fullpath = imgpath + path
	#图片大小
	imgsize = os.path.getsize(fullpath)
	#如果图片大于100K就进行压缩
	if imgsize >= 102400:
		if mime == 'image/jpeg':
			#优化图片
			os.system('jpegoptim -m 80 ' + fullpath)
			#更新数据库
			upimg(imgid)
			print(path + "已优化！\n")
		elif mime == 'image/png' or mime == 'image/bmp':
			#优化图片
			os.system('optipng ' + fullpath)
			#更新数据库
			upimg(imgid)
			print(path + "已优化！\n")
		else:
			skip = c.execute("UPDATE img_images SET compression = -1 WHERE `id` = " + str(imgid))
			print("当前没有需要处理的图片！\n")
			conn.commit()
	else:
		print("图片不足100k，跳过！\n")
		skip = conn.execute("UPDATE img_images SET compression = -1 WHERE `id` = " + str(imgid))
		conn.commit()

#遍历输出
for row in imgs:
	compress(row[2],row[0],row[4])

#关闭数据库连接	
conn.close()
