# tencentyun/image-php-sdk-v2.0
腾讯云 [万象优图（Cloud Image）](https://www.qcloud.com/product/ci) SDK for PHP

## 安装（直接下载源码集成）
### 直接下载源码集成
从github下载源码，并加载image-php-sdk-v2.0/index.php就可以了。
调用请参考sample.php

### 1. 在腾讯云申请业务的授权
授权包括：
		
	APP_ID 
	SECRET_ID
	SECRET_KEY
	BUCKET

### 2. 创建对应操作类的对象
如果要使用图片，需要创建图片操作类对象

	require_once __DIR__ . '/index.php';
	use QcloudImage\CIClient;

	$client = new CIClient('APP_ID', 'SECRET_ID', 'SECRET_KEY', 'BUCKET');
	$client->setTimeout(30);

### 3. 调用对应的方法
在创建完对象后，根据实际需求，调用对应的操作方法就可以了。sdk提供的方法包括：图片识别、人脸识别及人脸核身等。

#### 3.1 图片识别
图片识别包括：图片鉴黄、图片标签、OCR-身份证识别及OCR-名片识别。

##### 图片鉴黄

```php
	//单个或多个图片Url
	var_dump ($client->pornDetect(array('urls'=>array('YOUR URL A',
										'YOUR URL B'))));
	//单个或多个图片File
	var_dump ($client->pornDetect(array('files'=>array('F:\pic\你好.jpg','G:\pic\test2.jpg'))));
```

##### 图片标签

```php
	//单个图片url
	var_dump ($client->tagDetect(array('url'=>'YOUR URL')));
	//单个图片file
	var_dump ($client->tagDetect(array('file'=>'G:\pic\hot1.jpg')));
	//单个图片内容
	var_dump ($client->tagDetect(array('buffer'=>file_get_contents('G:\pic\hot1.jpg'))));
```

##### OCR-身份证识别

```php
	//单个或多个图片Url,识别身份证正面
	var_dump ($client->idcardDetect(array('urls'=>array('YOUR URL A', 
												'YOUR URL B')), 0));
	//单个或多个图片file,识别身份证正面
	var_dump ($client->idcardDetect(array('files'=>array('F:\pic\id6_zheng.jpg', 'F:\pic\id2_zheng.jpg')), 0));
	//单个或多个图片内容,识别身份证正面
	var_dump ($client->idcardDetect(array('buffers'=>array(file_get_contents('F:\pic\id6_zheng.jpg'), 
																		file_get_contents('F:\pic\id2_zheng.jpg'))), 0));
	
	//单个或多个图片Url,识别身份证反面
	var_dump ($client->idcardDetect(array('urls'=>array('YOUR URL C', 
													'YOUR URL D')), 1));
	//单个或多个图片file,识别身份证反面
	var_dump ($client->idcardDetect(array('files'=>array('F:\pic\id5_fan.jpg', 'F:\pic\id7_fan.png')), 1));
	//单个或多个图片内容,识别身份证反面
	var_dump ($client->idcardDetect(array('buffers'=>array(file_get_contents('F:\pic\id5_fan.jpg'), 
														file_get_contents('F:\pic\id7_fan.jpg'))), 1));
```

##### OCR-名片识别	
```php
	//单个或多个图片Url
	var_dump ($client->namecardDetect(array('urls'=>array('YOUR URL A',
														'YOUR URL B')), 0));
	//单个或多个图片file,
	var_dump ($client->namecardDetect(array('files'=>array('F:\pic\r.jpg', 'F:\pic\name2.jpg')), 1));
	//单个或多个图片内容
	var_dump ($client->namecardDetect(array('buffers'=>array(file_get_contents('F:\pic\name1.jpg'), 
																file_get_contents('F:\pic\name2.jpg'))), 0));
```

#### 3.2 人脸识别
人脸识别包括：人脸检测、五官定位、个体信息管理、人脸验证、人脸对比及人脸检索。

#### 人脸检测

```php
	//单个图片Url, mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceDetect(array('url'=>'YOUR URL'), 1));
	//单个图片file,mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceDetect(array('file'=>'F:\pic\face1.jpg'),0));
	//单个图片内容,mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceDetect(array('buffer'=>file_get_contents('F:\pic\face1.jpg')), 1));
```

##### 五官定位

```php
	//单个图片Url,mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceShape(array('url'=>'YOUR URL'),1));
	//单个图片file,mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceShape(array('file'=>'F:\pic\face1.jpg'),0));
	//单个图片内容,mode:1为检测最大的人脸 , 0为检测所有人脸
	var_dump ($client->faceShape(array('buffer'=>file_get_contents('F:\pic\face1.jpg')), 1));
```

##### 个体信息管理
```php
    //个体创建,创建一个Person，并将Person放置到group_ids指定的组当中，不存在的group_id会自动创建。
	//创建一个Person, 使用图片url
	var_dump ($client->faceNewPerson('person1111', array('group11',), array('url'=>'YOUR URL'), 'xiaoxin'));
	//创建一个Person, 使用图片file
	var_dump ($client->faceNewPerson('person2111', array('group11',), array('file'=>'F:\pic\hot1.jpg')));
	//创建一个Person, 使用图片内容
	var_dump ($client->faceNewPerson('person3111', array('group11',), array('buffer'=>file_get_contents('F:\pic\zhao1.jpg'))));

	//增加人脸,将一组Face加入到一个Person中。
	//将单个或者多个Face的url加入到一个Person中
	var_dump ($client->faceAddFace('person1111', array('urls'=>array('YOUR URL A',
																	'YOUR URL B'))));
	//将单个或者多个Face的file加入到一个Person中
	var_dump ($client->faceAddFace('person2111', array('files'=>array('F:\pic\yang.jpg','F:\pic\yang2.jpg'))));
	//将单个或者多个Face的文件内容加入到一个Person中
	var_dump ($client->faceAddFace('person3111', array('buffers'=>array(file_get_contents('F:\pic\yang.jpg'),file_get_contents('F:\pic\yang2.jpg')))));

	// 删除人脸,删除一个person下的face
	var_dump ($client->faceDelFace('person1', array('12346',)));
	
	//设置信息
	var_dump ($client->faceSetInfo('person1', 'fanbing'));

	//获取信息
	var_dump ($client->faceGetInfo('person1'));

	//获取组列表
	var_dump ($client->faceGetGroupIds());

	//获取人列表
	var_dump ($client->faceGetPersonIds('group1'));

	//获取人脸列表
	var_dump ($client->faceGetFaceIds('person1'));

	//获取人脸信息
	var_dump ($client->faceGetFaceInfo('1704147773393235686'));

	//删除个人
	var_dump ($client->faceDelPerson('person11'));
```

##### 人脸验证
给定一个Face和一个Person，返回是否是同一个人的判断以及置信度

```php
	//单个图片Url
	var_dump ($client->faceVerify('person1', array('url'=>'YOUR URL')));
	//单个图片file
	var_dump ($client->faceVerify('person3111', array('file'=>'F:\pic\yang3.jpg')));
	//单个图片内容
	var_dump ($client->faceVerify('person3111', array('buffer'=>file_get_contents('F:\pic\yang3.jpg'))));
```

##### 人脸检索
对于一个待识别的人脸图片，在一个Group中识别出最相似的Top5 Person作为其身份返回，返回的Top5中按照相似度从大到小排列。

```php
	//单个文件url
	var_dump ($client->faceIdentify('group1', array('url'=>'YOUR URL')));
	//单个文件file
	var_dump ($client->faceIdentify('group11', array('file'=>'F:\pic\yang3.jpg')));
	//单个文件内容
	var_dump ($client->faceIdentify('group11', array('buffer'=>file_get_contents('F:\pic\yang3.jpg'))));
```

##### 人脸对比

```php
	//两个对比图片的文件url
	var_dump ($client->faceCompare(array('url'=>"YOUR URL A"),
													array('url'=>'YOUR URL B')));
	//两个对比图片的文件file
	var_dump ($client->faceCompare(array('file'=>'F:\pic\yang.jpg'), array('file'=>'F:\pic\yang2.jpg')));
	//两个对比图片的文件内容
	var_dump ($client->faceCompare(array('file'=>'F:\pic\yang.jpg'), array('file'=>'F:\pic\yang2.jpg')));
```
	
		
#### 3.3 人脸核身

##### 身份证识别对比

```php
	//身份证url
	var_dump ($client->faceIdCardCompare('xxxxxxxxxxx', 'xxxxxxxxxxx', array('url'=>'YOUR URL')));
	//身份证文件file
	var_dump ($client->faceIdCardCompare('xxxxxxxxxxx', 'xxxxxxxxxxx', array('file'=>'F:\pic\idcard.jpg')));
	//身份证文件内容
	var_dump ($client->faceIdCardCompare('xxxxxxxxxxx', 'xxxxxxxxxxx', array('buffer'=>file_get_contents('F:\pic\idcard.jpg'))));
```

##### 活体检测—获取唇语验证码

```php
	$obj = $client->faceLiveGetFour();
	var_dump ($obj);
	$validate_data = $obj['data']['validate_data'];
```

##### 活体检测-视频与用户照片的比对

```php
	var_dump ($client->faceLiveDetectFour($validate_data, array('file'=>'F:\pic\ZOE_0171.mp4'), False, array('F:\pic\idcard.jpg')));
```

##### 活体检测-视频与身份证高清照片的比对

```php
	var_dump ($client->faceIdCardLiveDetectFour($validate_data, array('file'=>'F:\pic\ZOE_0171.mp4'), 'xxxxxxxxxxx', 'xxxxxxxxxxx'));
```
