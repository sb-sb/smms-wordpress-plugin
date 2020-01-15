<?php

add_action( 'admin_menu', 'my_plugin_menu' );


function my_plugin_menu() {
    add_menu_page( 'SMMS图床', 'SMMS图床', 'manage_options', 'smms-image-library', 'my_plugin_library' );
    add_submenu_page( 'smms-image-library', '图片库', '图片库', 'manage_options', 'smms-image-library', 'my_plugin_library' );
    add_submenu_page( 'smms-image-library', '设置', '设置', 'manage_options', 'smms-image', 'my_plugin_options' );
}

function my_plugin_library(){
	@require_once( 'library.php' );
}
function my_plugin_options() {
	if(isset($_POST['DataSubmit']))
	{
		$Uploader = array( 
			'Content' => trim(@$_POST['content']),
			'Comment' => trim(@$_POST['comment']),
			'Authorization' => trim(@$_POST['authorization']),
			'Nolocal' => trim(@$_POST['no_local'])
		);
		@update_option('SMMS_DATA', $Uploader);
		echo '<div class="updated" id="message"><p>提交成功</p></div>';
	}

	$Uploader = get_option('SMMS_DATA'); 
	$Content	= $Uploader['Content']	!== '' ? 'checked="checked"' : '';
	$Comment	= $Uploader['Comment']	!== '' ? 'checked="checked"' : '';
	$Nolocal	= $Uploader['Nolocal']	!== '' ? 'checked="checked"' : '';
	$Authorization	= $Uploader['Authorization'];
	
     if ( !current_user_can( 'manage_options' ) )  {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
     }
	 echo '<div class="wrap">';
     echo '<h2>SMMS-UPLOADER 插件设置</h2>';
	 echo '<p>&nbsp;&nbsp;smms-image是一款为WordPress添加上传图片小工具以及评论处图片上传按钮的插件！</p>';
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

	 echo '<tr valign="top">';
	 echo '<th scope="row">删除本地文件</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "no_local" '.$Nolocal.'>  勾选后不保留本地上传文件</label></td>'; 
	 echo '</tr>';
	 
	 echo '</tbody>';
	 echo '</table>'; 
	 echo '<p class = "submit">'; 
	 echo '<input class = "button button-primary" type = "submit" name = "DataSubmit" id = "submit" value = "保存更改" />&nbsp;&nbsp;&nbsp;&nbsp;'; 
	 echo '</p>'; 
	 
	 echo '</table>'; 
	 echo '</div>'; 
	 
	 
}