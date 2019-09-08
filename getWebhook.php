<?php 
require_once(__DIR__.'/telegram.php');
$telegram=new TelegramBot();
$telegram->setToken('Bot Token');
echo $telegram->getWebhook();

?>