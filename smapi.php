<?php
/**
 * SMAPI by MrJun
 */
class SMApi
{

	private $auth;

	function __construct($auth){
		$this->auth = $auth;
	}

	function Upload($path){

		$smfile = new \CURLFile(realpath($path));
	    $post_data = [
	        "smfile" => $smfile,
	        "format" => 'json'
	    ];

	    $result = $this->Send('upload', $post_data, 1);

	    return $result;

	}

	function Delete($hash){

		$result = $this->Send('delete/'.$hash);

	    return $result;

	}

	function Send( $type ,$data = [], $is_post = 0){

		$url = 'https://sm.ms/api/v2/'.$type;
		$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
	    $headers = array(
	        "Content-type: multipart/form-data",
	        "Authorization: ".$this->auth
	    );

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    if($is_post){
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }
	    curl_setopt($ch, CURLOPT_URL , "https://sm.ms/api/v2/".$type);
	    curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    
	    $output = curl_exec($ch);
	    curl_close($ch);
	    $output = json_decode($output,true);

	    return $output;
	}

}
