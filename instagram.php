<?php

class InstagramPhoto{
    public $userName;
    public $userId;

    public function setUserName($username){
        $this->userName=$username;
    }
        public function request($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {}
            curl_close($ch);
            return $result;

        }
        public function search(){
            $url='https://www.instagram.com/web/search/topsearch/?context=user&count=5&query='.$this->username;
            $data=json_decode($this->request($url),true);
            if(isset($data['users'][0])){
                $this->userId=$data['users'][0]['user']['pk'];
                return true;
            }
            return false;
        }
        public function profilePhoto(){
            $url='https://www.instadp.com/profile/'.$this->userName.'&h';
            
            $data=$this->request($url);
            preg_match('/<img class="picture" src="(.*?)">/i',$data,$match);
            if(isset($match[1])){
                return $match[1];
            }
             return false;
        }




}



?>