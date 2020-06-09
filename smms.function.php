<?php

global $wpdb;
define('MY_NEW_TABLE', $wpdb->prefix . 'smms_image_list');
// 插件激活时，运行回调方法创建数据表, 在WP原有的options表中插入插件版本号

function plugin_activation_cretable()
{
	global $wpdb;

	$charset_collate = '';

	if (!empty($wpdb->charset)) {
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	}

	if (!empty($wpdb->collate)) {
		$charset_collate .= " COLLATE {$wpdb->collate}";
	}

	$sql = "CREATE TABLE " . MY_NEW_TABLE . " (
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		width int NOT NULL,
		height int NOT NULL,
		size int NOT NULL,
		hash varchar(255) NOT NULL,
		url varchar(255) NOT NULL
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
	dbDelta($sql);
}


// 插件停用时，运行回调方法删除数据表，删除options表中的插件版本号
function plugin_deactivation_deltable()
{
	global $wpdb;

	$wpdb->query("DROP TABLE IF EXISTS " . MY_NEW_TABLE);
	delete_option('my_plugin_version_num');
}
