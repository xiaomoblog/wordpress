<?php
/**
 * HelloChangYan,精彩的不只是评论还有你我.在appid和appkey配置完成以前请不要开启畅言评论，填写后去面板进行配置即可
 * 修复原生评论切换，增加回推typecho评论同步回推功能，即使以后不用畅言，你的评论也会得到保留
 * @package HelloChangYan
 * @author Angboo
 * @version 1.1
 * @link http://www.aecode.cn
 */
class HelloChangYan_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法
     *
     * @access public
     * @return void
     */
    public static function activate()
    {
        Helper::addPanel(1, 'HelloChangYan/panel.php', _t('HelloChangYan'), _t('HelloChangYan|让你的评论精彩起来'), 'administrator');
        Helper::addAction('HelloChangYan', 'HelloChangYan_Action');
    }

    /**
     * 禁用插件方法
     *
     * @static
     * @access public
     * @return void
     */
    public static function deactivate(){
        Helper::removePanel(1, 'HelloChangYan/panel.php');
        Helper::removeAction('HelloChangYan');
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $appid=new Typecho_Widget_Helper_Form_Element_Text('appid', NULL, '',
            _t('畅言appid'), _t('请输入您在畅言注册后，后台获取到的APPID'));
        $appkey=new Typecho_Widget_Helper_Form_Element_Text('appkey', NULL, '',
            _t('畅言appkey'), _t('请输入您在畅言注册后，后台获取到的APPKEY'));
      	$authorSite=new Typecho_Widget_Helper_Form_Element_Text('appkey', NULL, 'http://www.aecode.cn',
            _t('作者网址'), _t('友情提示：请不要随意修改此项目，且畅言评论功能可能会被广告屏蔽软件屏蔽，如出现找不到畅言提示框，请检查您电脑是否安装广告屏蔽软件'));
      	$backurl=new Typecho_Widget_Helper_Form_Element_Text('backurl', NULL, Helper::options()->siteUrl.'feedback.php',
            _t('回推地址'), _t('如果您想要将畅言的评论同步到您的博客自带评论中，请将回推地址填写到畅言后台系统设置->通用设置->高级内的第二个选项回推地址内并保存，或登陆畅言后复制http://changyan.kuaizhan.com/setting/common/further打开填写保存'));
        $isOpenComment=new Typecho_Widget_Helper_Form_Element_Select('isOpenComment',array('1'=>'否','0'=>'是'),'',
            _t('是否使用畅言'), _t('选是使用畅言评论，选否将使用typecho自带评论功能,请设置appid和appkey之后再开启畅言评论'));
        $form->addInput($authorSite->addRule('required', _t('请不要随意修改')));
      	$form->addInput($backurl->addRule('required', _t('请不要随意修改')));
      	$form->addInput($appid->addRule('required', _t('必须填写一个APPID')));
        $form->addInput($appkey->addRule('required', _t('必须填写一个APPKEY')));
        $form->addInput($isOpenComment);

    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function PluginNav()
    {
    }
}