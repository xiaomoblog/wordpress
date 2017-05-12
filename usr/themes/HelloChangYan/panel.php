<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
include 'header.php';
include 'menu.php';
?>
<div class="main">
    <div class="body body-950">
        <center><?php include 'page-title.php'; ?></center>
        <div class="container typecho-page-main">
            <div class="column-22 start-02">
                <div class="message success typecho-radius-topleft typecho-radius-topright typecho-radius-bottomleft typecho-radius-bottomright">
                    <form action="<?php $options->index('/action/HelloChangYan'); ?>" method="post">
                        <blockquote>
                            <ul>
                              <p>因为配置完成后会自动卸载面板和ACTION，所以会出现404界面，点击返回键提示配置成功即可</p>
                                <input type="submit" value="准备就绪,点击配置">
                            </ul>
                        </blockquote>
                    </form>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'copyright.php';
include 'common-js.php';
include 'footer.php';
?>
