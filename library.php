<?php

global $wpdb;

//$result = $wpdb->get_results('SELECT `url` FROM `'. MY_NEW_TABLE .'` ORDER BY `id` DESC LIMIT 50');

if(@$_POST['action'] == 'delete' || @$_POST['action2'] == 'delete'){
	$option = get_option('SMMS_DATA');
    $auth = $option['Authorization'];
    $smapi = new SMApi($auth);
	foreach ($_POST['imglist'] as $v) {
		$wpdb->get_results("DELETE FROM `". MY_NEW_TABLE ."` WHERE ((`hash` = '$v'))");
	    $smapi->Delete($v);
	}
}
$pages = $_GET['paged']? : 1;
$limit = 10;
$offset = ($pages - 1) * 10;
$sql = $wpdb->prepare('SELECT * FROM `'. MY_NEW_TABLE .'` ORDER BY `id` DESC LIMIT %d OFFSET %d', $limit, $offset);

$rs = $wpdb->get_results($sql);
$count = $wpdb->get_results('SELECT COUNT(*) FROM `'. MY_NEW_TABLE .'`');
$t = 'COUNT(*)';
$count =  $count[0]->$t;

$all_pages = (int) ($count/10) + 1;

?>

<div class="wrap">
	<h1 class="wp-heading-inline">
		图片库</h1>
		<?php if(@$_POST['action'] == 'delete' || @$_POST['action2'] == 'delete'){ ?>
<div id="message" class="updated notice is-dismissible"><p>已删除</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button></div>
<?php } ?>
<form method="post">
		<div class="tablenav top">

				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
<option value="-1">批量操作</option>
	<option value="delete">删除</option>
</select>
<input type="submit" id="doaction" name="test" class="button action" value="应用"  />
		</div>
		
		<div class='tablenav-pages one-page'><span class="displaying-num"><?php echo $count;?>个项目</span>
<span class='pagination-links'><span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
<span class="paging-input">第<label for="current-page-selector" class="screen-reader-text">当前页</label><input class='current-page' id='current-page-selector' type='text' name='paged' value='1' size='1' aria-describedby='table-paging' /><span class='tablenav-paging-text'>页，共<span class='total-pages'>1</span>页</span></span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span></span></div>
		<br class="clear" />
	</div>
		<h2 class='screen-reader-text'>用户列表</h2><table class="wp-list-table widefat fixed striped users">
	<thead>
	<tr>
		<td  id='cb' class='manage-column column-cb check-column'><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox" /></td><th scope="col" id='username' class='manage-column column-username column-primary sortable desc'><a><span>图片</span></a></th><th scope="col" id='name' class='manage-column column-name'>尺寸</th><th scope="col" id='email' class='manage-column column-email sortable desc'><a><span>大小</span></a></th><th scope="col" id='role' class='manage-column column-role'>URL</th><th scope="col" id='posts' class='manage-column column-posts num'>HASH</th>	</tr>
	</thead>

	<tbody id="the-list"
		 data-wp-lists='list:user'		>
		<?php foreach($rs as $res){ ?>
	<tr>
		<th scope='row' class='check-column'><input type="checkbox" name="imglist[]" id="user_1" class="administrator" value="<?php echo $res->hash; ?>" /></th>
		<td class='username column-username has-row-actions column-primary' data-colname="图片"><img alt='' src='<?php echo $res->url; ?>' class='avatar avatar-32 photo' height='100' width='100' /> </td>
		<td><?php echo $res->width; ?> * <?php echo $res->height; ?></td>
		<td><?php echo $res->size; ?></td>
		<td><?php echo $res->url; ?></td>
		<td><?php echo $res->hash; ?></td>
	</tr>
<? } ?>
</tbody>

	<tfoot>
	<tr>
		<td   class='manage-column column-cb check-column'><label class="screen-reader-text" for="cb-select-all-2">全选</label><input id="cb-select-all-2" type="checkbox" /></td><th scope="col"  class='manage-column column-username column-primary sortable desc'><a><span>图片</span></a></th><th scope="col"  class='manage-column column-name'>尺寸</th><th scope="col"  class='manage-column column-email sortable desc'><a><span>大小</span></a></th><th scope="col"  class='manage-column column-role'>URL</th><th scope="col"  class='manage-column column-posts num'>HASH</th>	</tr>
	</tfoot>

</table>
			<div class="tablenav bottom">

				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
<option value="-1">批量操作</option>
	<option value="delete">删除</option>
</select>
<input type="submit" id="doaction2" class="button action" value="应用"  />
		</div>
				
		<div class="tablenav-pages"><span class="displaying-num"><?php echo $count;?>个项目</span>
<a <?php if($pages != 1){ ?>href="admin.php?page=smms-image-library&paged=<?php echo ($pages - 1);?>"<?php }?>>
<span class="tablenav-pages-navspan button <?php if($pages == 1){ ?>disabled<?php }?>" aria-hidden="true">‹</span></a>
<span class="screen-reader-text">当前页</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">第1页，共<span class="total-pages"><?php echo $all_pages;?></span>页</span></span>
<a class="next-page button <?php if($pages == $all_pages){ ?>disabled<?php }?>" <?php if($pages != $all_pages){ ?>href="admin.php?page=smms-image-library&paged=<?php echo ($pages + 1);?>"<?php }?>><span aria-hidden="true">›</span></a></span></div>

		<br class="clear" />
	</div>
		</form>

		<br class="clear" />
</div>