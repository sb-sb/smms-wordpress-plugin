<?php
function smms_forward_route(){
    register_rest_route('smms/api/v2/', 'upload', [
        'methods' => 'POST',
        'callback' => 'smms_forward_callback',
    ]);
}

add_action('rest_api_init', 'smms_forward_route');

function smms_forward_callback($request){
    //$paged = $request->get_param('paged');

    $lastname = $_FILES['smfile']['tmp_name'];
    $newname = $lastname.$_FILES['smfile']['name'];

    rename($lastname,$newname);

    
    return smms_curl( $newname );
}

function smms_curl( $newname ){

    $smfile = new \CURLFile(realpath($newname));
    $post_data = [
        "smfile" => $smfile,
        "format" => 'json'
    ];

    $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
    $authorization = get_option('SMMS_DATA')['Authorization'];
    $headers = array(
        "Content-type: multipart/form-data",
        "Authorization: ".$authorization
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL , "https://sm.ms/api/v2/upload");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);

    unlink($newname);
    
    $output = json_decode($output,true);

    if($output['code'] == 'image_repeated'){
       $output['data']['url'] = $output['images'];
    }
    return $output;

}

?>