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
define('MY_PLUGIN_MINIMUM_WP_VERSION', '4.0');

include 'smms.function.php';
include 'setting.php';
include 'class.smms.php';
include 'route.smms.php';
include 'smapi.php';

//注册信息
$start = new Smms();

//激活插件创建数据表
register_activation_hook(__FILE__, 'plugin_activation_cretable');
//禁用插件删除数据表
register_deactivation_hook(__FILE__, 'plugin_deactivation_deltable');