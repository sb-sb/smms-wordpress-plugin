<?php
/**
 * SMMS by MrJun
 */
class Smms
{
	
	function __construct(){

		add_action('wp_enqueue_scripts', array( $this, 'add_scripts_css') );;
		$Uploader = get_option('SMMS_DATA'); 
		if($Uploader['Content']){
			add_action('admin_head', array( $this, 'admin_scripts_css') );
			add_action('media_buttons', array( $this, 'admin_upload_img') );  
		}
		if($Uploader['Comment']){
			add_filter('comment_form', array( $this, 'comment_upload_img') ); 
		}

		add_filter( 'plugin_action_links', array( $this, 'SMMS_UPLOADER_LINKS'), 10, 4 );
		//默认数据
		add_action('admin_init', array( $this, 'SMMS_options_default_options'));

	}

	function add_scripts_css() {  
		wp_deregister_script('jquery');
		wp_register_script('jquery', SMMS_URL . 'js/jquery.min.js', SMMS_VERSION);
		wp_enqueue_script( 'jquery' );

		if(is_single() || is_page())wp_enqueue_script( 'smms-comment-js', SMMS_URL . 'js/comment.js', array(), SMMS_VERSION, true); 
		if(is_single() || is_page() || is_home())wp_enqueue_style( 'smms-widget-css', SMMS_URL . 'css/smms.diy.css', array(),SMMS_VERSION); 
	}

	function admin_scripts_css() {  
		wp_enqueue_script( 'admin-content-js', SMMS_URL . 'js/content.js', array(), SMMS_VERSION, true); 
		wp_enqueue_script( 'modal-js', SMMS_URL . 'js/modal.js', array(), SMMS_VERSION, true); 
		wp_enqueue_style( 'admin-content-css', SMMS_URL . 'css/input.min.css', array(),SMMS_VERSION); 
		wp_enqueue_style( 'modal-css', SMMS_URL . 'css/modal.css', array(),SMMS_VERSION); 
	}

	function SMMS_UPLOADER_LINKS( $actions, $plugin_file , $plugin_data){
	    static $plugin;
	    global $language;
		if (!isset($plugin))
			$plugin = plugin_basename(__FILE__);
		//if ($plugin == $plugin_file) {
				$settings	= array('settings' => '<a href="admin.php?page=smms-image">'.$language[4].'</a>');
				$actions 	= array_merge($settings, $actions);
		//}
		return $actions;
	}

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

	function comment_upload_img() {
		global $language;
		echo '<div class="zz-add-img"><input id="zz-img-file" type="file" accept="image/*" multiple="multiple"><div id="zz-img-add">'.$language[31].'</div><div id="zz-img-show"></div></div>';
	}
	function admin_upload_img() {
		global $language;
	    echo '<a class="button"  id="toggleModal" title="'.$language[0].'">'.$language[0].'</a><a href="javascript:;" class="file">'.$language[30].'<input id="admin-img-file" type="file" accept="image/*" multiple="multiple"></a><div class="modal">
				<div class="modal-header">
					<p class="close">×</p>
				</div>
				<div class="modal-content">
					<ul id="img_list">
					</ul>
					<span id="pages-list"></span>
				</div>
				
				<div class="modal-footer">
					<input id="upload-btn" type="button" class="load btn" value="'.$language[32].'">
					<input type="button" class="close btn" value="'.$language[33].'">
				</div>
			</div><div class="mask"></div>';
	}

}