<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?>
<?php $this->options->title(); ?></title>
<?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&atom=&rss1=&rss2='); ?>
<link rel="shortcut icon" href="http://yiyeti.cc/favicon.ico">
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/iconfont.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/prism.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/player.css'); ?>">
</head>
<body>
<style type="text/css">
.article-title a{color:<?php $this->options->css() ?>;}
header{width:100%;background:<?php $this->options->css() ?>;}
footer{margin:20px auto;color:<?php $this->options->css() ?>;text-align:center;}
.toTop{z-index:1000;position:fixed;right:1.2em;bottom:2.2em;display:none;width:36px;height:36px;background:<?php $this->options->css() ?>;color:#fff;text-align:center;line-height:36px;font-size:14px;cursor:pointer;transition:all .3s;-webkit-animation:totop .8s;animation:totop .8s;}
.article-time{display:block;color:<?php $this->options->css() ?>;text-align:center;font-size:12px;}
a,u{position:relative;display:inline-block;color:<?php $this->options->css() ?>;text-decoration:none;}
.readmore a:hover{background:<?php $this->options->css() ?>;color:#fff;}
.readmore a{padding:0 10px;color:<?php $this->options->css() ?>;transition:all .5s;}
.qrcode {position: fixed;right: 1400px;bottom: 350px;border: 1px solid <?php $this->options->css() ?>;padding: 5px;background: #FFF;text-align: center;border-radius: 2px;z-index: 1000;}
body{color:<?php $this->options->css() ?>;font-size:16px;font-family: "Lucida Grande", Lucida Sans Unicode, Hiragino Sans GB, WenQuanYi Micro Hei, Verdana, Aril, sans-serif;line-height:1.8;}
#pContent .ssBtn{width:20px;height:60px;background:<?php $this->options->css() ?> none repeat scroll 0% 0%;position:relative;right:0px;bottom:0px;box-sizing:border-box;border-left:none;cursor:pointer;display:box-shadow:;float:right;}
</style>
<header>
  <div class="main">
    <div class="intro"> <img src="<?php $this->options->logoUrl(); ?>" class="intro-logo"/> <span class="intro-sitename"><a href="<?php $this->options->siteUrl(); ?>">
      <?php $this->options->title() ?>
      </a></span> <span class="intro-siteinfo">
      <?php $this->options->description() ?>
      </span> <span class="social"> <a href="<?php $this->options->qqlink(); ?>" target="_blank"><i class="iconfont icon-qq"></i></a> <a href="<?php $this->options->mlink(); ?>" target="_blank"><i class="iconfont icon-mail"></i></a> <a href="<?php $this->options->wlink(); ?>" target="_blank"><i class="iconfont icon-weibo"></i></a> <a href="<?php $this->options->glink(); ?>" target="_blank"><i class="iconfont icon-github"></i></a> </span> </div>
    <nav>
      <div class="collapse"> </div>
      <ul class="bar">
        <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
        <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while($pages->next()): ?>
        <li><a<?php if($this->is('page', $pages->slug)): ?><?php endif; ?> href="<?php $pages->permalink(); ?>">
          <?php $pages->title(); ?>
          </a></li>
        <?php endwhile; ?>
      </ul>
    </nav>
  </div>
</header>