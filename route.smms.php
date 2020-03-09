<?php


add_action('rest_api_init', 'smms_forward_route');
add_action('rest_api_init', 'smms_getlist_route');

function smms_forward_route(){
    register_rest_route('smms/api/v2/', 'upload', [
        'methods' => 'POST',
        'callback' => 'smms_forward_callback',
    ]);
}

function smms_getlist_route(){
    register_rest_route('smms/api/v2/', 'list', [
        'methods' => 'GET',
        'callback' => 'smms_getlist_callback',
    ]);
}


function smms_forward_callback($request){
    //$paged = $request->get_param('paged');
    global $wpdb;

    $lastname = $_FILES['smfile']['tmp_name'];

    $wp_uploads = wp_upload_dir()['path'];

    //return $wp_uploads;

    create_folders($wp_uploads.'/smms_imglist/');
    $path = $wp_uploads.'/smms_imglist/'.$_FILES['smfile']['name'];

    //return $path;
    copy($lastname,$path);
    unlink($lastname);

    $option = get_option('SMMS_DATA');

    $auth = $option['Authorization'];

    $smapi = new SMApi($auth);

    $result = $smapi->Upload($path);
    
    if($result["success"]){

        $data['width']  = $result['data']['width'];
        $data['height'] = $result['data']['height'];
        $data['size']   = $result['data']['size'];
        $data['hash']   = $result['data']['hash'];
        $data['url']    = $result['data']['url'];

        $wpdb->insert(MY_NEW_TABLE, $data);

        if($option['Nolocal']){
            unlink($path);
        }
        
    }elseif($result["code"] == "image_repeated"){
        $result['data']['url'] = $result["images"];
    }

    return $result;
}

function smms_getlist_callback($request){

    global $wpdb;

    $pages = $request->get_param('pages');
    $pages = $pages? : 1;
    $limit = 10;
    $offset = ($pages - 1) * 10;
    $sql = $wpdb->prepare('SELECT `url` FROM `'. MY_NEW_TABLE .'` ORDER BY `id` DESC LIMIT %d OFFSET %d', $limit, $offset);
    $result = $wpdb->get_results($sql);

    return $result;
}

function create_folders($dir) {
    return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
}

?>
