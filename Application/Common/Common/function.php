<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getIp(){
    return ip2long($_SERVER["REMOTE_ADDR"]);
}

//图片上传类
function uploadImage($file, $path='goods', $exts=[]){
	$result = [
			'errorInfo' => '',
			'filePath' => '',
		];
	$config = [
			'exts' => ['jpg', 'gif', 'png', 'jpeg'],	//允许上传的文件后缀
			'autoSub' => true,							//自动子目录保存文件
			'subName' => ['date', 'Y-m-d'],				//子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
			'rootPath' => './Uploads/',					//保存根路径
			'savePath' => $path . '/',					//保存路径
			'saveName' => ['uniqid', '']				//上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		];
	if($exts){
	//	array_push($config['exts'], $exts);
	}

	$upload = new \Think\Upload($config);
	$result = $upload->uploadOne($file);
	if($result !== false){
		$result['filePath'] = substr($config['rootPath'], 1) . $result['savepath'] . $result['savename'];
	}else{
		$result['errorInfo'] = $upload->getError();
	}
	return $result;
}

function uploadSoftPack($file, $path='download'){
	return uploadImage($file, $path, ['exe', 'apk', 'ipk']);
}

//图片缩略图
function thumbImage($filePath, $w=50, $h=50){
	$pathinfo = pathinfo($filePath);
	$goods_small_img = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '_small.' . $pathinfo['extension'];
	$image = new \Think\Image();
	$image->open(ROOT_PATH . $filePath);
	$image->thumb($w, $h);
	$image->save(ROOT_PATH.$goods_small_img);
	return $goods_small_img;
}

function subscriptArray($arr, $index){
	$newArr = [];
	if(count($arr) > 0){
		foreach($arr as $value){
			if(isset($value[$index])){
				$newArr[$value[$index]] = $value;
			}
		}
	}
	return $newArr;
}



