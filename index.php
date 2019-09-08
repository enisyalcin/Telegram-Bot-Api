<?php
require_once(__DIR__.'/telegram.php');
require_once(__DIR__.'/instagram.php');

$instagram=new InstagramPhoto();
$telegram=new TelegramBot();
$telegram->setToken('Bot Token');
// echo $telegram->setWebhook('https://8134c4e7.ngrok.io/botapi/');
//  echo $telegram->getWebhook();

$data=$telegram->getData();
if(isset($data['text'])){
	$telegram->saveMessageData($data);
	preg_match('@^\/(instagram|php|html) +((?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29})$@',$data['text'],$match);
	if(isset($match[1])){
		$instagram->setUserName($match[2]);
		$url=$instagram->profilePhoto();
		if($url!=false){
			$telegram->sendPhoto($url,$match[2].' adlı kullanıcının profil resmi.');
			$telegram->saveCommandData($data);
		}else{
			$telegram->sendMessage($match[2].' adlı kullanıcının resmi bulunamadı.');
		}
		
		
	}
}
/*
$jsonfile
*/
 ?>