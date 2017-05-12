<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('博主头像地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个自己的头像'));
    $form->addInput($logoUrl);     

    $qqlink = new Typecho_Widget_Helper_Form_Element_Text('qqlink', NULL, NULL, _t('你的QQ联系地址'), _t('在这里填入QQ联系地址，不知道请到QQ推广里获取代码，其格式为（http://wpa.qq.com/msgrd?v=3&uin=你的QQ号&site=qq&menu=yes）'));
	$form->addInput($qqlink);
	
    $mlink = new Typecho_Widget_Helper_Form_Element_Text('mlink', NULL, NULL, _t('你的联系邮箱'), _t('在这里填入你的邮箱联系地址,其格式为（mailto:admin@yiyeti.cc）'));
    $form->addInput($mlink);
	
    $wlink = new Typecho_Widget_Helper_Form_Element_Text('wlink', NULL, NULL, _t('你的联系微博'), _t('在这里填入你的微博联系地址'));
    $form->addInput($wlink);
	
    $glink = new Typecho_Widget_Helper_Form_Element_Text('glink', NULL, NULL, _t('你的github库'), _t('在这里填入你的github库地址'));
    $form->addInput($glink);

    $css = new Typecho_Widget_Helper_Form_Element_Text('css', NULL, NULL, _t('自定义你的主题风格颜色'), _t('在这里填入你的主题风格颜色，如颜色为黑色请填写为“#FFFFFF”，如此项不填写，前台将显示不完整，请知悉'));
    $form->addInput($css);
	
	$weixin = new Typecho_Widget_Helper_Form_Element_Text('weixin', NULL, NULL, _t('填入你的微信二维码图片地址'), _t('在这里填入你的微信二维码图片地址'));
    $form->addInput($weixin);
	
}
/*

function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('博主头像地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个自己的头像'));
    $layout->addItem($logoUrl);
	
    $qqlink = new Typecho_Widget_Helper_Form_Element_Text('qqlink', NULL, NULL, _t('你的QQ联系地址'), _t('在这里填入QQ联系地址，不知道请到QQ推广里获取代码'));
	$layout->addInput($qqlink);
	
	 $mlink = new Typecho_Widget_Helper_Form_Element_Text('mlink', NULL, NULL, _t('你的联系邮箱'), _t('在这里填入你的邮箱联系地址'));
    $layout->addInput($mlink);
	
	$wlink = new Typecho_Widget_Helper_Form_Element_Text('wlink', NULL, NULL, _t('你的联系微博'), _t('在这里填入你的微博联系地址'));
    $layout->addInput($wlink);
	
	$glink = new Typecho_Widget_Helper_Form_Element_Text('glink', NULL, NULL, _t('你的github库'), _t('在这里填入你的github库地址'));
    $layout->addInput($glink);

    $css = new Typecho_Widget_Helper_Form_Element_Text('css', NULL, NULL, _t('自定义你的主题风格颜色'), _t('在这里填入你的主题风格颜色，如颜色为黑色请填写为“#FFFFFF”，如此项不填写，前台将显示不完整，请知悉'));
    $layout->addInput($css);
	
	$weixin = new Typecho_Widget_Helper_Form_Element_Text('weixin', NULL, NULL, _t('填入你的微信二维码图片地址'), _t('在这里填入你的微信二维码图片地址'));
    $layout->addInput($weixin);
	
}

*/