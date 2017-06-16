<?php
/*Template Name: 说说
author: 兰陵
url: http://blog.thkira.com/
*/
?>
<?php get_header(); ?>
<link href="/wp-content/themes/Siren/css/style.css" rel="stylesheet">
		<div class="container">				
			<header class="clearfix">
				<h2>碎碎念<span>日常瞎逼逼</span></h2>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>
				
			</header>
			
			<section class="main">

				<ul class="timeline">
<?php
function view() {
$xiabb = file_get_contents(esc_url( home_url( '/xiabb.json' ) ));
$json = json_decode("[".rtrim($xiabb,",\n")."]");
$arr=range(1,50);//此处我弄了50个图标随机显示
shuffle($arr);
for($id=0,$i=0;$i<count($json);$i++){
	$id++;
	if($id==1)$checked=" checked";else $checked="";
	$content=$json[$i]->content;
	$time=$json[$i]->time;
	$weather=$json[$i]->weather;
	echo '
					<li class="event" id="xiabb'.$id.'">
						<input type="radio" name="tl-group"'.$checked.'/>
						<label></label>
						<div class="thumb user-'.$arr[$i].'"><span>#'.$id.'</span></div>
						<div class="content-perspective">
							<div class="content">
								<div class="content-inner">
									<h3>'.$content.'</h3>
									<p>时间：'.$time.' >天气：'.$weather.'</p>
								</div>
							</div>
						</div>
					</li>'."\n";
	}
}
view();
?>
					
				</ul>
			</section>
		</div>

<?php get_footer(); ?>