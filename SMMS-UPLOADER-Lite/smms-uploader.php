<?php
/*
Plugin Name: SM.MS图床外链
Plugin URI: https://sm.ms
Description: SM.MS图床外链wordpress插件。
Author: sm.ms
Author URI: https://sm.ms/
Version: 1.0
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
自定义小工具CSS样式部分
*/
define( 'SMMS_URL', plugin_dir_url( __FILE__ ) ); 
define( 'SMMS_VERSION', "4.3");
include("SMMS-UPLOADER-COMMENTS.php");
include("SMMS-FORWARD.php");
function add_scripts_css() {  
wp_deregister_script('jquery');
wp_register_script('jquery', SMMS_URL . 'js/jquery.min.js', SMMS_VERSION);
wp_enqueue_script( 'jquery' );

if(is_single() || is_page())wp_enqueue_script( 'smms-comment-js', SMMS_URL . 'js/comment.js', array(), SMMS_VERSION, true); 
if(is_single() || is_page() || is_home())wp_enqueue_style( 'smms-widget-css', SMMS_URL . 'css/smms.diy.css', array(),SMMS_VERSION); 
if(is_single() || is_page() || is_home())wp_enqueue_style( 'bootstrap', SMMS_URL . 'css/bootstrap.min.css', array(), SMMS_VERSION); 
}
function admin_scripts_css() {  
wp_enqueue_script( 'admin-content-js', SMMS_URL . 'js/content.min.js', array(), SMMS_VERSION, true); 
wp_enqueue_style( 'admin-content-css', SMMS_URL . 'css/input.min.css', array(),SMMS_VERSION); 
}
add_action('wp_enqueue_scripts', 'add_scripts_css');
//功能启用
$Uploader = get_option('SMMS_DATA'); 
if($Uploader['Content'])
{
	add_action('admin_head', 'admin_scripts_css');
	add_action('media_buttons', 'admin_upload_img');  
}
if($Uploader['Comment'])
{
	add_filter('comment_form', 'comment_upload_img'); 
}

//END

//添加链接
function SMMS_UPLOADER_LINKS( $actions, $plugin_file )
{
    static $plugin;
	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file) {
			$settings	= array('settings' => '<a href="options-general.php?page=SMMS-UPLOADER-OPTIONS">插件设置</a>');
			$actions 	= array_merge($settings, $actions);
	}
	return $actions;
}
add_filter( 'plugin_action_links', 'SMMS_UPLOADER_LINKS', 10, 2 );
//默认数据
add_action('admin_init', 'SMMS_options_default_options');
function SMMS_options_default_options(){
	$Uploader = get_option('SMMS_DATA');//获取选项
	if( $Uploader == '' ){   
		$Uploader = array(//设置默认数据
			'Content' => '',
			'Comment' => '',
			'Authorization' => ''
		);
		update_option('SMMS_DATA', $Uploader);//更新选项   
	}
}

//设置菜单
function my_plugin_menu() {
     add_options_page( 'SMMS-UPLOADER设置页面', 'SM图床设置', 'manage_options', 'SMMS-UPLOADER-OPTIONS', 'my_plugin_options' );
}
add_action( 'admin_menu', 'my_plugin_menu' );
function my_plugin_options() {
	if(isset($_POST['DataSubmit']))
	{
		$Uploader = array( 
			'Content' => trim(@$_POST['content']),
			'Comment' => trim(@$_POST['comment']),
			'Authorization' => trim(@$_POST['authorization']),
			);
		@update_option('SMMS_DATA', $Uploader);
		echo '<div class="updated" id="message"><p>提交成功</p></div>';
	}

	$Uploader = get_option('SMMS_DATA'); 
	$Content	= $Uploader['Content']	!== '' ? 'checked="checked"' : '';
	$Comment	= $Uploader['Comment']	!== '' ? 'checked="checked"' : '';
	$Authorization	= $Uploader['Authorization'];
	
     if ( !current_user_can( 'manage_options' ) )  {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
     }
	 echo '<div class="wrap">';
     echo '<h2>SMMS-UPLOADER 插件设置</h2>';
	 echo '<p>&nbsp;&nbsp;SMMS-UPLOADER是一款为WordPress添加上传图片小工具以及评论处图片上传按钮的插件！</p>';
     echo '<form method = "post">';
     echo '<table class = "form-table">';
     echo '<tbody>';

     echo '<tr valign="top">';
     echo '<th scope="row">Authorization设置</th>';
     echo '<td><label><input value = "'.$Authorization.'" type = "text" name = "authorization" size="40">  <a target="_blank" href="https://sm.ms/home/apitoken">点击我获取</a></label></td>';
	 echo '</tr>';
	 
	 echo '<tr valign="top">';
     echo '<th scope="row">后台文章编辑启用图片上传</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "content" '.$Content.'>  勾选后在后台文章编辑处自动添加图片上传按钮</label></td>';
	 echo '</tr>';

	 
	 echo '<tr valign="top">';
	 echo '<th scope="row">是否启用评论上传按钮</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "comment" '.$Comment.'>  勾选后在评论框后自动添加图片上传按钮</label></td>'; 
	 echo '</tr>';
	 
	 echo '</tbody>';
	 echo '</table>'; 
	 echo '<p class = "submit">'; 
	 echo '<input class = "button button-primary" type = "submit" name = "DataSubmit" id = "submit" value = "保存更改" />&nbsp;&nbsp;&nbsp;&nbsp;'; 
	 echo '</p>'; 
	 
	 echo '</table>'; 
	 echo '</div>'; 
	 
	 
}