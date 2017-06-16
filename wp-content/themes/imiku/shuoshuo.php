<?php
/** WordPress Administration Bootstrap */
require_once('./wp-load.php');
if ( ! current_user_can('activate_plugins') )
    wp_die( __( '您无权在本站点修改说说内容。' ) );
echo "<title>说说管理 &lsaquo; ".get_bloginfo('name')." &#8212; WordPress</title>"
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<style type="text/css">
body{
    margin:0;
    padding:0;
    background:#c2edf4;
    color:#333;
    overflow-x:hidden;
}
::-webkit-input-placeholder{color: #3a909e;font-weight: bold;}
::-moz-placeholder{color: #3a909e;font-weight: bold;}
:-moz-placeholder{color: #3a909e;font-weight: bold;}
:-ms-input-placeholder{color: #3a909e;font-weight: bold;}
.nagging{
    max-width:1300px;
    text-align:center;
    margin:0 auto;
}

.nagging h2{
    padding: 10px 0;
    margin: 0;
    font-size: 62px;
    line-height: 58px;
    color: #fff;
    font-weight: 400;
    background: transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAI0lEQVQIW2P8DwSMQMCABBhBgiA+sgRYBboEXBuyBIpZMAkAW1YUAh9deX8AAAAASUVORK5CYII=) repeat-x bottom left;
    text-shadow: 4px 4px 0px #41838e;
}

.nagging h2 span{
    display: block;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 10px;
    font-size: 18px;
    color: #3a909e;
    text-shadow: none;
}

#xiabb,#xiabb_but {
    max-width:768px;
    width:80%;
    font-size:1.5em;
    font-weight: bold;
    color:#3a909e;
    border-radius: 10px;
    padding: 7px 15px;
}

#xiabb {
    height:118px;
    border: 2px solid #6cf;
    border-width: 1px 1px 2px 1px;
}

#xiabb_but{
    margin-top:5px;
    border: 2px dashed #6cf;
    background: rgba(104, 204, 255, 0.5);
    color:#3a909e;
}

#xiabb_but:hover{
    background: rgba(104, 204, 255, 0.75);
    color:#fff;
}

ul,ol{
    margin:0 auto;
    padding:0;
    max-width:768px;
    list-style-type:none;
}

.list li:nth-child(odd){
    clear: both;
    float: left;
    margin:10px 5px 10px 20px;
}

.list li:nth-child(even){
    float: right;
    margin:10px 20px 10px 5px;
}
.list li{
    width:325px;
    padding:10px;
    list-style-type:none;
    background: rgba(255,255,255,.8);
    border-radius: 15px;
    font-weight: bold;
}

.list li:hover {
    box-shadow: 0 5px 5px 0 rgba(0,0,0,.4);
}

.list li,.list li:hover,#xiabb_but,#xiabb_but:hover{
    -webkit-transition: all ease 0.5s;
    -moz-transition: all ease 0.5s;
    -ms-transition: all ease 0.5s;
    transition: all ease 0.5s;
}

.id{
    float:left;
    width:20%;
    height:50px;
    display:block;
    text-align: center;
    font-size: 3em;
    opacity: .5;
}

.data{
    font-size:1em;
}

.data,.cont span {
    color:#6cf;
}

.list li a{
    clear:both;
    width:50px;
    font-size:1em;
    text-align:center;
    margin: 5px auto;
    padding: 5px 10px;
    border: 2px dashed #6cf;
    border-radius: 7px;
    background: rgba(104, 204, 255, 0.5);
    color:#3a909e;
    display:block;
}

.list li a:hover{
    background: rgba(104, 204, 255, 0.75);
    color:#fff;
}

.list li .data time,.list li .data span{
    display: inline-block;
}

.cont{
    width:75%;
    float:right;
    font-size:1.5em;
    color:#4a4a4a;
    word-wrap: break-word;
}
.copyright{
    width: 100%;
    clear: both;
    position:relative;
    bottom:5px;
    text-align:center;
    font-weight: bold;
    color:#3a909e;
}
@media screen and (max-width: 750px){
.list li{
    float: none!important;
    width:80%;
    margin:10px auto!important;
}
}
</style>
<div class="nagging">
<form method="post" action="">
  <label for="xiabb"><h2>碎碎念<span>日常瞎逼逼</span></h2></label><br>
  <textarea id="xiabb" name="say" required="required" aria-required="true" placeholder="随便说两句~"></textarea>
  <input id="xiabb_but" type="submit" value="发♂射" />
</textarea>
</form>
</div>
<div class="list"><ul>
<?php
if($say=$_POST['say'])add(stripslashes($say));//防止双层转义
if($del=$_GET['del'])del($del);
//类
class xiabb{
    public $id;
    public $content;
    public $time;
    public $weather;
    
    function __construct($id,$content,$time,$weather){
        $this->id = $id;
        $this->content = $content;
        $this->time = $time;
        $this->weather = $weather;
    }
}

//浏览
function view() {
$xiabb = file_get_contents("xiabb.json");
$json = json_decode("[".rtrim($xiabb,",\n")."]");
for($id=0,$i=0;$i<count($json);$i++){
    $id++;
    $content=$json[$i]->content;
    $time=$json[$i]->time;
    $weather=$json[$i]->weather;
    echo "<li><p class=\"id\">#".$id."</p><p class=\"data\"><time>".$time."</time>-><span>".$weather."</span></p><p class=\"cont\"><span>#</span>".$content."<span>#</span></p><a href=\"?del=".$id."\">删除</a></li>"."\n";
    }
}
view();

//天气接口
function forecast($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $weather = curl_exec($ch);
    curl_close($ch);
    return $weather;
}

//IP
function ip(){
    if(getenv('HTTP_CLIENT_IP')) { 
    $ip = getenv('HTTP_CLIENT_IP'); 
    } elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
    $ip = getenv('HTTP_X_FORWARDED_FOR'); 
    } elseif(getenv('REMOTE_ADDR')) { 
    $ip = getenv('REMOTE_ADDR'); 
    } else { 
    $ip = $HTTP_SERVER_VARS['REMOTE_ADDR']; 
    }
    return $ip; 
}

//增加
function add($word) {
    $xiabb = file_get_contents("xiabb.json");
    $json = json_decode("[".rtrim($xiabb,",\n")."]");
    //天气
    $weather = json_decode(forecast("https://api.thinkpage.cn/v3/weather/now.json?key=wfhcvltljt1g3c0u=".ip()."&language=zh-Hans&unit=c"))->results[0]->now->text;
    //时间
    date_default_timezone_set('PRC');
    $time = strftime("%Y-%m-%d %H:%M:%S",time());
    $id=$json[0]->id+1;
    $new_xiabb = new xiabb($id,$word,$time,$weather);
    //备份历史版本
    copy("xiabb.json","xiabb.json.old");
    $fp = fopen("xiabb.json","w");
    flock($fp, LOCK_EX);
    fwrite($fp,json_encode($new_xiabb).",\n".$xiabb);
    flock($fp, LOCK_UN);
    fclose($fp);
    //备份
    copy("xiabb.json","xiabb.json.bak");
    header("Location:shuoshuo.php");
}
//为什么会有两个备份呢，因为之前想弄一个误删恢复，但是好像没什么必要

//删除
function del($line) {
    $filename="xiabb.json";
    $farray=file($filename);
    for($i=0;$i<count($farray);$i++) {   
        if(strcmp($i+1,$line)==0) {   
        continue;
        }   
    if(trim($farray[$i])<>"") {   
        $newfp.=$farray[$i];
        }   
    }   
    $fp=fopen($filename,"w");
    flock($fp, LOCK_EX);
    fwrite($fp,$newfp);
    flock($fp, LOCK_UN);
    fclose($fp);
    header("Location:shuoshuo.php");
}
?>
</ul></div>
<footer class="copyright">©兰陵</footer>