<?php
require __TYPECHO_ROOT_DIR__ . __TYPECHO_PLUGIN_DIR__ . '/HelloChangYan/FileUtil.php';
class HelloChangYan_Action extends Typecho_Widget implements Widget_Interface_Do
{
    public function doImport()
    {
        $f1 = __TYPECHO_ROOT_DIR__ .__TYPECHO_PLUGIN_DIR__ . '/HelloChangYan/';
       echo $f2 =str_replace(Helper::options()->siteUrl,__TYPECHO_ROOT_DIR__.'/',Helper::options()->themeUrl).'/comments.php';
        //必须有写入权限
        $fu = new FileUtil();
      	$fu->copyFile($f1.'comments.php',$f2,true);
      	$fu->copyFile($f1.'feedback.php',__TYPECHO_ROOT_DIR__.'/feedback.php',true);
      	Helper::removePanel(1, 'HelloChangYan/panel.php');
        Helper::removeAction('HelloChangYan');
      	$this->widget('Widget_Notice')->set(_t("配置完成"), NULL, 'success');
        $this->response->goBack();
      	
      

    }
    public function action()
    {
        $this->widget('Widget_User')->pass('administrator');
        $this->on($this->request->isPost())->doImport();
    }
}
