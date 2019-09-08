<?php

class TelegramBot{
    const API_URL='https://api.telegram.org/bot';
    public $token;
    public $chatId;


        public function setToken($token){
            $this->token=$token;
        }

        public function request($method,$posts=[]){
            
                $ch = curl_init();

                $url=self::API_URL.$this->token.'/'.$method;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
                curl_setopt($ch, CURLOPT_POST, 1);
                $headers = array();
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                return $result;

        }
        public function setWebhook($url){
            return $this->request('setWebhook',[
                'url'=>$url
            ]);

        }
        public function getWebhook(){
            return $this->request('getWebhookInfo');
        }
        public function getData(){
             file_put_contents('mesaj.json',file_get_contents('php://input'));
            $data=json_decode(file_get_contents('php://input'),true);

            if(isset($data['message'])){
                $this->chatId=$data['message']['chat']['id'];
                return $data['message'];
            }
            return [];
        }
		
        public function sendMessage($message){
            $this->request('sendMessage',[
                'chat_id'=>$this->chatId,
                'text'=>$message
            ]);
        }
		public function saveMessageData($message){
			$jsonfile='./message/'.$message['chat']['id'].'.json';
			if(!file_exists($jsonfile)){
				file_put_contents($jsonfile,json_encode([]));
			}
			$data=json_decode(file_get_contents($jsonfile),true);
			array_push($data,$message);
			file_put_contents($jsonfile,json_encode($data));
			return true;
		}
		public function saveCommandData($add){
			
				$data=json_decode(file_get_contents('./list.json'),true);
				array_push($data,$add);
				file_put_contents('list.json',json_encode($data));
				return true;
			
			return false;
		}
		
        public function sendPhoto($url,$message){
            $this->request('sendPhoto',[
                'chat_id'=>$this->chatId,
                'photo'=>$url,
                'caption'=>$message
            ]);
        }
}


?>