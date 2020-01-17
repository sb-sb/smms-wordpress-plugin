<?
$language_cn = [
	"SMMS图床",
	"图片库",
	"设置",
	"提交成功",
	"插件设置",
	"smms-image是一款为WordPress添加上传图片小工具以及评论处图片上传按钮的插件！",
	"点击我获取",
	"后台文章编辑启用图片上传",
	"勾选后在后台文章编辑处自动添加图片上传按钮",
	"是否启用评论上传按钮",
	"勾选后在评论框后自动添加图片上传按钮",
	"删除本地文件",
	"勾选后不保留本地上传文件",
	"保存更改",

	"已删除",
	"忽略此通知。",
	"选择批量操作",
	"批量操作",
	"删除",
	"应用",
	"个项目",
	"列表",
	"全选",
	"尺寸",
	"图片",
	"大小",
	"当前页",
	"第",
	"页",
	"共",

	"添加图片",
	"上传图片",
	"加载更多",
	"关闭"

];

$language_en = [
	"SMMS Pictures",
	"Picture library",
	"Setting",
	"Submit successfully",
	"Plugins Setting",
	"smms-image is a plug-in for WordPress to add upload image widget and upload image button in comments！",
	"Click on me to get",
	"Background article editing enable image upload",
	"After checking, automatically add the image upload button in the background article editor",
	"Enable comment upload button",
	"Check and automatically add the upload button after the comment box",
	"Delete local file",
	"Do not keep local upload file after checking",
	"Save changes",

	"Deleted",
	"Ignore this notification.",
	"Select batch operation",
	"Batch operation",
	"Delete",
	"apply",
	"projects",
	"List",
	"Select All",
	"Width * Height",
	"Images",
	"Size",
	"Current page",
	"",
	"Pages",
	"All",

	"Add image",
	"Upload image",
	"Load more",
	"Close"

];

$system_language = get_option('WPLANG');
global $language;
$language = $system_language == "zh_CN" ? $language_cn : $language_en;

