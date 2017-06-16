<?php
/**
 * Custom function
 * @Siren
*/

// 允许分类、标签描述添加html代码
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('term_description', 'wp_kses_data');
// 去除顶部工具栏
show_admin_bar(false);


/*
 * 视频
 */
function bgvideo(){
  if(!akina_option('focus_amv') || akina_option('focus_height')) $dis = 'display:none;';
  $html = '<div id="video-container" style="'.$dis.'">'; 
  $html .= '<video id="bgvideo" class="video" video-name="" src="" width="auto" preload="auto"></video>';
  $html .= '<div id="video-btn" class="loadvideo videolive"></div>';
  $html .= '<div id="video-add"></div>';
  $html .= '<div class="video-stu"></div>';
  $html .= '</div>';
  return $html;
}


/*
 * 使用本地图片作为头像，防止外源抽风问题
 */
function get_avatar_profile_url(){ 
  if(akina_option('focus_logo')){
    $avatar = akina_option('focus_logo');
  }else{
    $avatar = get_avatar_url(get_the_author_meta( 'ID' ));
  }
  return $avatar;
}


/*
 * 首页随机背景图
 * NB: I can think of this
 */
function get_random_bg_url(){
  $arr = array();
  for($i=0; $i<6; $i++){ 
    if(akina_option('focus_img_'.$i)){
      $arr[] = akina_option('focus_img_'.$i);
    }
  }
  $url = rand(0, count($arr)-1);
  return $arr[$url];
}


/*
 * 订制时间样式
 * poi_time_since(strtotime($post->post_date_gmt));
 * poi_time_since(strtotime($comment->comment_date_gmt), true );
 */
function poi_time_since( $older_date, $comment_date = false, $text = false ) {
  $chunks = array(
    array( 24 * 60 * 60, __( ' 天前', 'akina' ) ),
    array( 60 * 60, __( ' 小时前', 'akina' ) ),
    array( 60, __( ' 分钟前', 'akina' ) ),
    array( 1, __( ' 秒前', 'akina' ) )
  );

  $newer_date = time();
  $since = abs( $newer_date - $older_date );
  if($text){
    $output = '';
  }else{
    $output = '发布于 ';
  }

  if ( $since < 30 * 24 * 60 * 60 ) {
    for ( $i = 0, $j = count( $chunks ); $i < $j; $i ++ ) {
      $seconds = $chunks[ $i ][0];
      $name    = $chunks[ $i ][1];
      if ( ( $count = floor( $since / $seconds ) ) != 0 ) {
        break;
      }
    }
    $output .= $count . $name;
  } else {
    $output .= $comment_date ? date( 'Y-m-d H:i', $older_date ) : date( 'Y-m-d', $older_date );
  }

  return $output;
}


/*
 * 首页不显示指定的分类文章
 */
if(akina_option('classify_display')){
  function classify_display($query){
    $source = akina_option('classify_display');
    $cats = explode(',', $source);
    $cat = '';
    if ( $query->is_home ) {
      foreach($cats as $k => $v) {
        $cat .= '-'.$v.','; //重组字符串
      }
      $cat = trim($cat,',');
      $query->set( 'cat', $cat);
    }
    return $query;
  }
  add_filter( 'pre_get_posts', 'classify_display' ); 
}


/*
 * 评论添加@
 */
function comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<a href="#comment-' . $comment->comment_parent . '" class="comment-at">@'.get_comment_author( $comment->comment_parent ) . '</a><br/> ' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'comment_add_at', 20, 2);


/*
 * Ajax评论
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) { wp_die('请升级到4.4以上版本'); }
// 提示
if(!function_exists('siren_ajax_comment_err')) {
    function siren_ajax_comment_err($t) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $t;
        exit;
    }
}
// 机器评论验证
function siren_robot_comment(){
  if ( !$_POST['no-robot'] && !is_user_logged_in()) {
     siren_ajax_comment_err('上车请打卡。');
  }
}
if(akina_option('norobot')) add_action('pre_comment_on_post', 'siren_robot_comment');
// 纯英文评论拦截
function scp_comment_post( $incoming_comment ) {
  if(!preg_match('/[一-龥]/u', $incoming_comment['comment_content'])){
    siren_ajax_comment_err('写点汉字吧，博主外语很捉急。You should type some Chinese word.');
  }
  return( $incoming_comment );
}
add_filter('preprocess_comment', 'scp_comment_post');
// 评论提交
if(!function_exists('siren_ajax_comment_callback')) {
    function siren_ajax_comment_callback(){
      $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
      if( is_wp_error( $comment ) ) {
        $data = $comment->get_error_data();
        if ( !empty( $data ) ) {
          siren_ajax_comment_err($comment->get_error_message());
        } else {
          exit;
        }
      }
      $user = wp_get_current_user();
      do_action('set_comment_cookies', $comment, $user);
      $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
      ?>
      <li <?php comment_class(); ?> id="comment-<?php echo esc_attr(comment_ID()); ?>">
        <div class="contents">
          <div class="comment-arrow">
            <div class="main shadow">
                <div class="profile">
                  <a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment->comment_author_email, '80', '', get_comment_author() ); ?></a>
                </div>
                <div class="commentinfo">
                  <section class="commeta">
                    <div class="left">
                      <h4 class="author"><a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment->comment_author_email, '80', '', get_comment_author() ); ?><?php comment_author(); ?> <span class="isauthor" title="<?php esc_attr_e('Author', 'akina'); ?>"></span></a></h4>
                    </div>
                    <div class="right">
                      <div class="info"><time datetime="<?php comment_date('Y-m-d'); ?>"><?php echo poi_time_since(strtotime($comment->comment_date_gmt), true );//comment_date(get_option('date_format')); ?></time></div>
                    </div>
                  </section>
                </div>
                <div class="body">
                  <?php comment_text(); ?>
                </div>
            </div>
            <div class="arrow-left"></div>
          </div>
        </div>
      </li>
      <?php die();
    }
}
add_action('wp_ajax_nopriv_ajax_comment', 'siren_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'siren_ajax_comment_callback');


/*
 * 前台登陆
 */
// 指定登录页面
if(akina_option('exlogin_url')){
  add_action('login_enqueue_scripts','login_protection');
  function login_protection(){
    if($_GET['word'] != 'press'){
      $admin_url = akina_option('exlogin_url');
      wp_redirect( $admin_url );
      exit;
    }
  }
}

// 登陆跳转
function Exuser_center(){ ?>
  <script language='javascript' type='text/javascript'> 
    var secs = 5; //倒计时的秒数 
    var URL;
    var TYPE; 
    function gopage(url,type){ 
        URL = url; 
        if(type == 1){
          TYPE = '管理后台';
        }else{
          TYPE = '主页';
        }
        for(var i=secs;i>=0;i--){ 
            window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000); 
        } 
    } 
    function doUpdate(num){ 
        document.getElementById('login-showtime').innerHTML = '空降成功，'+num+'秒后自动转到'+TYPE; 
        if(num == 0) { window.location=URL; } 
    } 
  </script>    
  <?php if(current_user_can('level_10')){ ?>
  <div class="admin-login-check">
    <?php echo login_ok(); ?>
    <?php if(akina_option('login_urlskip')){ ?><script>gopage("<?php bloginfo('url'); ?>/wp-admin/",1);</script><?php } ?>
  </div>
  <?php }else{ ?>
  <div class="user-login-check">
    <?php echo login_ok(); ?>
    <?php if(akina_option('login_urlskip')){ ?><script>gopage("<?php bloginfo('url'); ?>",0);</script><?php } ?>
  </div>
<?php 
  }
}

// 登录成功
function login_ok(){ 
  global $current_user;
  get_currentuserinfo();
?>
  <p class="ex-login-avatar"><a href="http://cn.gravatar.com/" title="更换头像" target="_blank" rel="nofollow"><?php echo get_avatar( $current_user->user_email, '110' ); ?></a></p>
  <p class="ex-login-username">你好，<strong><?php echo $current_user->display_name; ?></strong></p>
  <?php if($current_user->user_email){echo '<p>'.$current_user->user_email.'</p>';} ?>
  <p id="login-showtime"></p>
  <p class="ex-logout">
    <a href="<?php bloginfo('url'); ?>" title="首页">首页</a>
    <?php if(current_user_can('level_10')){  ?>
    <a href="<?php bloginfo('url'); ?>/wp-admin/" title="后台" target="_top">后台</a> 
    <?php } ?>
    <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>" title="登出" target="_top">登出？</a>
  </p>
<?php 
}


/*
 * 文章，页面头部背景图
 */
function the_headPattern(){
  $t = ''; // 标题
  $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
  if(is_single()){
    $full_image_url = $full_image_url[0];
    if (have_posts()) : while (have_posts()) : the_post();
    $center = 'single-center';
    $header = 'single-header';
    $ava = akina_option('focus_logo', '') ? akina_option('focus_logo', '') : get_avatar_url(get_the_author_meta('user_email'));
    $t .= the_title( '<h1 class="entry-title">', '</h1>', false);
    $t .= '<p class="entry-census"><span><a href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'),get_the_author_meta( 'user_nicename' ))) .'"><img src="'. $ava .'"></a></span><span><a href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'),get_the_author_meta( 'user_nicename' ))) .'">'. get_the_author() .'</a></span><span class="bull">·</span>'. poi_time_since(get_post_time('U', true),false,true) .'<span class="bull">·</span>'. get_post_views(get_the_ID()) .' 次阅读</p>';
    endwhile; endif;
  }elseif(is_page()){
    $full_image_url = $full_image_url[0];
    $t .= the_title( '<h1 class="entry-title">', '</h1>', false);
  }elseif(is_archive()){
    $full_image_url = z_taxonomy_image_url();
    $des = category_description() ? category_description() : ''; // 描述
    $t .= '<h1 class="cat-title">'.single_cat_title('', false).'</h1>';
    $t .= ' <span class="cat-des">'.$des.'</span>';
  }elseif(is_search()){
    $full_image_url = get_random_bg_url();
    $t .= '<h1 class="entry-title search-title"> 关于“ '.get_search_query().' ”的搜索结果</h1>';
  }
  if(akina_option('patternimg')) $full_image_url = false;
  if(!is_home() && $full_image_url) : ?>
  <div class="pattern-center <?php if(is_single()){echo $center;} ?>">
    <div class="pattern-attachment-img" style="background-image: url(<?php echo $full_image_url; ?>)"> </div>
    <header class="pattern-header <?php if(is_single()){echo $header;} ?>"><?php echo $t; ?></header>
  </div>
  <?php else :
    echo '<div class="blank"></div>';
  endif;
}


/*
 * 导航栏用户菜单
 */
function header_user_menu(){
  global $current_user;get_currentuserinfo(); 
  if(is_user_logged_in()){
    $ava = akina_option('focus_logo') ? akina_option('focus_logo') : get_avatar_url( $current_user->user_email );
    ?>
    <div class="header-user-avatar">
      <img src="<?php echo $ava; ?>" width="30" height="30">
      <div class="header-user-menu">
        <div class="herder-user-name">Signed in as 
          <div class="herder-user-name-u"><?php echo $current_user->display_name; ?></div>
        </div>
        <div class="user-menu-option">
          <?php if (current_user_can('level_10')) { ?>
            <a href="<?php bloginfo('url'); ?>/wp-admin/" target="_top">管理中心</a>
            <a href="<?php bloginfo('url'); ?>/wp-admin/post-new.php" target="_top">撰写文章</a>
          <?php } ?>
          <a href="<?php bloginfo('url'); ?>/wp-admin/profile.php" target="_top">个人资料</a>
          <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>" target="_top">退出登录</a>
        </div>
      </div>
    </div>
  <?php
  }else{ 
    $ava = get_template_directory_uri().'/images/none.png';
    $login_url = akina_option('exlogin_url') ? akina_option('exlogin_url') : get_bloginfo('url').'/wp-login.php';
  ?>
  <div class="header-user-avatar">
    <a href="<?php echo $login_url; ?>">
      <img src="data:image/png;base64,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" width="30" height="30">
    </a>
    <div class="header-user-menu">
      <div class="herder-user-name no-logged">Whether to log in now ?
        <a href="<?php echo $login_url; ?>">Sign in</a>
      </div>
    </div>
  </div>
  <?php 
  }
}


/*
 * 获取相邻文章缩略图
 * 特色图 -> 文章图 -> 首页图
 */
// 上一篇
function get_prev_thumbnail_url() { 
  $prev_post = get_previous_post(); 
  if ( has_post_thumbnail($prev_post->ID) ) { 
    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'large'); 
    return $img_src[0]; // 特色图
  } 
  else { 
    $content = $prev_post->post_content; 
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER); 
    $n = count($strResult[1]); 
    if($n > 0){ 
      return $strResult[1][0];  // 文章图
    }else{
      return get_random_bg_url(); // 首页图
    } 
  } 
}

// 下一篇
function get_next_thumbnail_url() { 
  $next_post = get_next_post(); 
  if ( has_post_thumbnail($next_post->ID) ) { 
    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'large'); 
    return $img_src[0]; 
  } 
  else { 
    $content = $next_post->post_content; 
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER); 
    $n = count($strResult[1]); 
    if($n > 0){ 
      return $strResult[1][0];   
    }else{
      return get_random_bg_url();
    } 
  } 
}

/**
 * 文章摘要
 */
function changes_post_excerpt_more( $more ) {
    return ' ...';
}
function changes_post_excerpt_length( $length ) {
    return 65;
}
add_filter( 'excerpt_more', 'changes_post_excerpt_more' );
add_filter( 'excerpt_length', 'changes_post_excerpt_length', 999 );


/*
 * SEO优化
 */
// 外部链接自动加nofollow
add_filter( 'the_content', 'siren_auto_link_nofollow');
function siren_auto_link_nofollow( $content ) {
  $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
  if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
    if( !empty($matches) ) {
      $srcUrl = get_option('siteurl');
      for ($i=0; $i < count($matches); $i++){
        $tag = $matches[$i][0];
        $tag2 = $matches[$i][0];
        $url = $matches[$i][0];
        $noFollow = '';
        $pattern = '/target\s*=\s*"\s*_blank\s*"/';
        preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
        if( count($match) < 1 )
            $noFollow .= ' target="_blank" ';
        $pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
        preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
        if( count($match) < 1 )
            $noFollow .= ' rel="nofollow" ';
        $pos = strpos($url,$srcUrl);
        if ($pos === false) {
            $tag = rtrim ($tag,'>');
            $tag .= $noFollow.'>';
            $content = str_replace($tag2,$tag,$content);
        }
      }
    }
  }
   
  $content = str_replace(']]>', ']]>', $content);
  return $content;
}

// 图片自动加标题
add_filter('the_content', 'siren_auto_images_alt');
function siren_auto_images_alt($content) {
  global $post;
  $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  $replacement = '<a$1href=$2$3.$4$5 alt="'.$post->post_title.'" title="'.$post->post_title.'"$6>';
  $content = preg_replace($pattern, $replacement, $content);
  return $content;
}

// 分类页面全部添加斜杠，利于SEO
function siren_nice_trailingslashit($string, $type_of_url) {
    if ( $type_of_url != 'single' )
      $string = trailingslashit($string);
    return $string;
}
add_filter('user_trailingslashit', 'siren_nice_trailingslashit', 10, 2);


// 去除链接显示categroy
add_action( 'load-themes.php',  'no_category_base_refresh_rules');
add_action('created_category', 'no_category_base_refresh_rules');
add_action('edited_category', 'no_category_base_refresh_rules');
add_action('delete_category', 'no_category_base_refresh_rules');
function no_category_base_refresh_rules() {
  global $wp_rewrite;
  $wp_rewrite -> flush_rules();
}
 
// Remove category base
add_action('init', 'no_category_base_permastruct');
function no_category_base_permastruct() {
  global $wp_rewrite, $wp_version;
  if (version_compare($wp_version, '3.4', '<')) {
    
  } else {
    $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
  }
}
// Add our custom category rewrite rules
add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
function no_category_base_rewrite_rules($category_rewrite) {
  //var_dump($category_rewrite); // For Debugging
  $category_rewrite = array();
  $categories = get_categories(array('hide_empty' => false));
  foreach ($categories as $category) {
    $category_nicename = $category -> slug;
    if ($category -> parent == $category -> cat_ID)// recursive recursion
      $category -> parent = 0;
    elseif ($category -> parent != 0)
      $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
    $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
    $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
    $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
  }
  // Redirect support from Old Category Base
  global $wp_rewrite;
  $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
  $old_category_base = trim($old_category_base, '/');
  $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
 
  //var_dump($category_rewrite); // For Debugging
  return $category_rewrite;
}
 
// Add 'category_redirect' query variable
add_filter('query_vars', 'no_category_base_query_vars');
function no_category_base_query_vars($public_query_vars) {
  $public_query_vars[] = 'category_redirect';
  return $public_query_vars;
}
 
// Redirect if 'category_redirect' is set
add_filter('request', 'no_category_base_request');
function no_category_base_request($query_vars) {
  //print_r($query_vars); // For Debugging
  if (isset($query_vars['category_redirect'])) {
    $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
    status_header(301);
    header("Location: $catlink");
    exit();
  }
  return $query_vars;
}
// 去除链接显示categroy END ~


/**
 * 更改作者页链接为昵称显示
 */
// Replace the user name using the nickname, query by user ID
add_filter( 'request', 'siren_request' );
function siren_request( $query_vars ){
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", $query_vars['author_name'] ) );
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}
 
// Replace a user name in a link with a nickname
add_filter( 'author_link', 'siren_author_link', 10, 3 );
function siren_author_link( $link, $author_id, $author_nicename ){
    $author_nickname = get_user_meta( $author_id, 'nickname', true );
    if ( $author_nickname ) {
        $link = str_replace( $author_nicename, $author_nickname, $link );
    }
    return $link;
}


/*
 * 私密评论
 * @bigfa
 */
function siren_private_message_hook($comment_content , $comment){
    $comment_ID = $comment->comment_ID;
    $parent_ID = $comment->comment_parent;
    $parent_email = get_comment_author_email($parent_ID);
    $is_private = get_comment_meta($comment_ID,'_private',true);
    $email = $comment->comment_author_email;
    $current_commenter = wp_get_current_commenter();
    if ( $is_private ) $comment_content = '#私密# ' . $comment_content;
    if ( $current_commenter['comment_author_email'] == $email || $parent_email == $current_commenter['comment_author_email'] || current_user_can('delete_user') ) return $comment_content;
    if ( $is_private ) return '该评论为私密评论';
    return $comment_content;
}
add_filter('get_comment_text','siren_private_message_hook',10,2);

function siren_mark_private_message($comment_id){
    if ( $_POST['is-private'] ) {
        update_comment_meta($comment_id,'_private','true');
    }
}
add_action('comment_post', 'siren_mark_private_message');


/*
 * 删除后台某些版权和链接
 * @wpdx
 */
add_filter('admin_title', 'wpdx_custom_admin_title', 10, 2);
function wpdx_custom_admin_title($admin_title, $title){
    return $title.' &lsaquo; '.get_bloginfo('name');
}
//去掉Wordpress LOGO
function remove_logo($wp_toolbar) {
    $wp_toolbar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_logo', 999);

//去掉Wordpress 底部版权
function change_footer_admin () {return '';}  
add_filter('admin_footer_text', 'change_footer_admin', 9999);  
function change_footer_version() {return '';}  
add_filter( 'update_footer', 'change_footer_version', 9999);

//去掉Wordpres挂件
function disable_dashboard_widgets() {   
    //remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');//近期评论 
    //remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');//近期草稿
    remove_meta_box('dashboard_primary', 'dashboard', 'core');//wordpress博客  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');//wordpress其它新闻  
    remove_meta_box('dashboard_right_now', 'dashboard', 'core');//wordpress概况  
    //remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');//wordresss链入链接  
    //remove_meta_box('dashboard_plugins', 'dashboard', 'core');//wordpress链入插件  
    //remove_meta_box('dashboard_quick_press', 'dashboard', 'core');//wordpress快速发布   
}  
add_action('admin_menu', 'disable_dashboard_widgets');


/**
 * 获取用户UA信息
 */
// 浏览器信息
function siren_get_browsers($ua){
  $title = 'unknow';
  $icon = 'unknow'; 
    if (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'Internet Explorer '. $matches[1];
    if ( strpos($matches[1], '7') !== false || strpos($matches[1], '8') !== false)
      $icon = 'ie8';
    elseif ( strpos($matches[1], '9') !== false)
      $icon = 'ie9';
    elseif ( strpos($matches[1], '10') !== false)
      $icon = 'ie10';
    else
      $icon = 'ie';
    }elseif (preg_match('#Edge/([a-zA-Z0-9.]+)#i', $ua, $matches)){
    $title = 'Microsoft Edge '. $matches[1];
        $icon = 'edge';
  }elseif (preg_match('#Firefox/([a-zA-Z0-9.]+)#i', $ua, $matches)){
    $title = 'Firefox '. $matches[1];
        $icon = 'firefox';
  }elseif (preg_match('#CriOS/([a-zA-Z0-9.]+)#i', $ua, $matches)){
    $title = 'Chrome for iOS '. $matches[1];
    $icon = 'crios';
  }elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'Google Chrome '. $matches[1];
    $icon = 'chrome';
    if (preg_match('#OPR/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
      $title = 'Opera '. $matches[1];
      $icon = 'opera15';
      if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[1];
    }
  }elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'Safari '. $matches[1];
    $icon = 'safari';
  }elseif (preg_match('#Opera.(.*)Version[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'Opera '. $matches[2];
    $icon = 'opera';
    if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[2];   
  }elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua,$matches)) {
    $title = 'Maxthon '. $matches[2];
    $icon = 'maxthon';
  }elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = '360 Browser '. $matches[1];
    $icon = '360se';
  }elseif (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'SouGou Browser 2'.$matches[1];
    $icon = 'sogou';
  }elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {
    $title = 'UCWEB '. $matches[1];
    $icon = 'ucweb';
  }elseif(preg_match('#wp-(iphone|android)/([a-zA-Z0-9.]+)#i', $ua, $matches)){ // 1.2 增加 wordpress 客户端的判断
    $title = 'wordpress '. $matches[2];
    $icon = 'wordpress';
  }
  
  return array(
    $title,
    $icon
  );
}

// 操作系统信息
function siren_get_os($ua){
  $title = 'unknow';
  $icon = 'unknow';
  if (preg_match('/win/i', $ua)) {
    if (preg_match('/Windows NT 10.0/i', $ua)) {
      $title = "Windows 10";
      $icon = "windows_win10";
    }elseif (preg_match('/Windows NT 6.1/i', $ua)) {
      $title = "Windows 7";
      $icon = "windows_win7";
    }elseif (preg_match('/Windows NT 5.1/i', $ua)) {
      $title = "Windows XP";
      $icon = "windows";
    }elseif (preg_match('/Windows NT 6.2/i', $ua)) {
      $title = "Windows 8";
      $icon = "windows_win8";
    }elseif (preg_match('/Windows NT 6.3/i', $ua)) {
      $title = "Windows 8.1";
      $icon = "windows_win8";
    }elseif (preg_match('/Windows NT 6.0/i', $ua)) {
      $title = "Windows Vista";
      $icon = "windows_vista";
    }elseif (preg_match('/Windows NT 5.2/i', $ua)) {
      if (preg_match('/Win64/i', $ua)) {
        $title = "Windows XP 64 bit";
      } else {
        $title = "Windows Server 2003";
      }
      $icon = 'windows';
    }elseif (preg_match('/Windows Phone/i', $ua)) {
      $matches = explode(';',$ua);
      $title = $matches[2];
      $icon = "windows_phone";
    }
  }elseif (preg_match('#iPod.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
    $title = "iPod ".$matches[1];
    $icon = "iphone";
  } elseif (preg_match('#iPhone OS ([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {// 1.2 修改成 iphone os 来判断 
    $title = "Iphone ".$matches[1];
    $icon = "iphone";
  } elseif (preg_match('#iPad.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
    $title = "iPad ".$matches[1];
    $icon = "ipad";
  } elseif (preg_match('/Mac OS X.([0-9. _]+)/i', $ua, $matches)) {
    if(count(explode(7,$matches[1]))>1) $matches[1] = 'Lion '.$matches[1];
    elseif(count(explode(8,$matches[1]))>1) $matches[1] = 'Mountain Lion '.$matches[1];
    $title = "Mac OSX ".$matches[1];
    $icon = "macos";
  } elseif (preg_match('/Macintosh/i', $ua)) {
    $title = "Mac OS";
    $icon = "macos";
  } elseif (preg_match('/CrOS/i', $ua)){
    $title = "Google Chrome OS";
    $icon = "chrome";
  }elseif (preg_match('/Linux/i', $ua)) {
    $title = 'Linux';
    $icon = 'linux';
    if (preg_match('/Android.([0-9. _]+)/i',$ua, $matches)) {
      $title= $matches[0];
      $icon = "android";
    }elseif (preg_match('#Ubuntu#i', $ua)) {
      $title = "Ubuntu Linux";
      $icon = "ubuntu";
    }elseif(preg_match('#Debian#i', $ua)) {
      $title = "Debian GNU/Linux";
      $icon = "debian";
    }elseif (preg_match('#Fedora#i', $ua)) {
      $title = "Fedora Linux";
      $icon = "fedora";
    }
  }
  return array(
    $title,
    $icon
  );
}

function siren_get_useragent($ua){
  if(akina_option('open_useragent')){
    $imgurl = get_bloginfo('template_directory') . '/images/ua/';
    $browser = siren_get_browsers($ua);
    $os = siren_get_os($ua);
    return '&nbsp;&nbsp;<span class="useragent-info">( <img src="'. $imgurl.$browser[1] .'.png">&nbsp;'. $browser[0] .'&nbsp;&nbsp;<img src="'. $imgurl.$os[1] .'.png">&nbsp;'. $os[0] .' )</span>';
  }
  return false;
}


/*
 * 打赏
 */
 function the_reward(){
  $alipay = akina_option('alipay_code');
  $wechat = akina_option('wechat_code');
  if($alipay || $wechat){
  $alipay =  $alipay ? '<li class="alipay-code"><img src="'.$alipay.'"></li>' : '';
  $wechat = $wechat ? '<li class="wechat-code"><img src="'.$wechat.'"></li>' : '';
  ?>
  <div class="single-reward">
    <div class="reward-open">赏
      <div class="reward-main">
        <ul class="reward-row">
          <?php echo $alipay.$wechat; ?>
        </ul>
      </div>
    </div>
  </div>
  <?php
  }
}
