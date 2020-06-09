<?php
include 'language.php';
add_action('admin_menu', 'my_plugin_menu');


function my_plugin_menu()
{
	global $language;
	add_menu_page($language[0], $language[0], 'manage_options', 'smms-image-library', 'my_plugin_library');
	add_submenu_page('smms-image-library', $language[1], $language[1], 'manage_options', 'smms-image-library', 'my_plugin_library');
	add_submenu_page('smms-image-library', $language[2], $language[2], 'manage_options', 'smms-image', 'my_plugin_options');
}

function my_plugin_library()
{
	@require_once('library.php');
}
function my_plugin_options()
{
	global $language;
	if (isset($_POST['DataSubmit'])) {
		$Uploader = array(
			'Content' => trim(@$_POST['content']),
			'Comment' => trim(@$_POST['comment']),
			'Authorization' => trim(@$_POST['authorization']),
			'Nolocal' => trim(@$_POST['no_local'])
		);
		@update_option('SMMS_DATA', $Uploader);
		echo '<div class="updated" id="message"><p>'.$language[3].'</p></div>';
	}

	$Uploader = get_option('SMMS_DATA');
	$Content	= $Uploader['Content']	!== '' ? 'checked="checked"' : '';
	$Comment	= $Uploader['Comment']	!== '' ? 'checked="checked"' : '';
	$Nolocal	= $Uploader['Nolocal']	!== '' ? 'checked="checked"' : '';
	$Authorization	= $Uploader['Authorization'];
	
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	echo '<div class="wrap">';
	echo '<h2>'.$language[4].'</h2>';
	echo '<p>&nbsp;&nbsp;'.$language[5].'</p>';
	echo '<form method = "post">';
	echo '<table class = "form-table">';
	echo '<tbody>';

	echo '<tr valign="top">';
	echo '<th scope="row">Authorization'.$language[2].'</th>';
	echo '<td><label><input value = "'.$Authorization.'" type = "text" name = "authorization" size="40">  <a target="_blank" href="https://sm.ms/home/apitoken">'.$language[6].'</a></label></td>';
	echo '</tr>';
	 
	echo '<tr valign="top">';
	echo '<th scope="row">'.$language[7].'</th>';
	echo '<td><label><input value = "true" type = "checkbox" name = "content" '.$Content.'>  '.$language[8].'</label></td>';
	echo '</tr>';

	 
	echo '<tr valign="top">';
	echo '<th scope="row">'.$language[9].'</th>';
	echo '<td><label><input value = "true" type = "checkbox" name = "comment" '.$Comment.'>  '.$language[10].'</label></td>';
	echo '</tr>';

	echo '<tr valign="top">';
	echo '<th scope="row">'.$language[11].'</th>';
	echo '<td><label><input value = "true" type = "checkbox" name = "no_local" '.$Nolocal.'>  '.$language[12].'</label></td>';
	echo '</tr>';
	 
	echo '</tbody>';
	echo '</table>';
	echo '<p class = "submit">';
	echo '<input class = "button button-primary" type = "submit" name = "DataSubmit" id = "submit" value = "'.$language[13].'" />&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '</p>';
	 
	echo '</table>';
	echo '</div>';
}
