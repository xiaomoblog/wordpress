<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="willerce">
<div> </div>
<!--播放器 -->
<div id="QPlayer">
  <div id="pContent">
    <div id="player"> <span class="cover"></span>
      <div class="ctrl">
        <div class="musicTag marquee"> <strong>Title</strong> <span> - </span> <span class="artist">Artist</span> </div>
        <div class="progress">
          <div class="timer left">0:00</div>
          <div class="contr">
            <div class="rewind icon"></div>
            <div class="playback icon"></div>
            <div class="fastforward icon"></div>
          </div>
          <div class="right">
            <div class="liebiao icon"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="ssBtn">
      <div class="adf"></div>
    </div>
  </div>
  <ol id="playlist">
  </ol>
</div>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="<?php $this->options->themeUrl('js/jquery.marquee.min.js'); ?>"></script>
<script>
	var	playlist = [	
{title:"丁香花",artist:"周玥",mp3:"http://p2.music.126.net/RNenjbsCEeeI2bnGB4EcPg==/2903810210384172.mp3",cover:"http://p4.music.126.net/O0MbXlINzZabpOEjZA-otA==/2929098977807667.jpg?param=106x106",},
{title:"喜欢两个人",artist:"彭佳慧",mp3:"http://p2.music.126.net/E5X5r0w_MgUilKBDpz9Log==/7936274930834753.mp3",cover:"http://p3.music.126.net/GpsgjHB_9XgtrBVXt8XX4w==/93458488373078.jpg?param=106x106",},
{title:"约定",artist:"光良",mp3:"http://p2.music.126.net/K2GgsEh7WdPIU8QisLLH0A==/3213872487990028.mp3",cover:"http://p4.music.126.net/Zxzq0d-ZD2W0c43yczQMgw==/65970697678836.jpg?param=106x106",},
];
  var isRotate = 1;
  var autoplay = 0;  
</script>
<script src="<?php $this->options->themeUrl('js/player.js'); ?>"></script>
<script>
function bgChange(){
	var lis= $('.lib');
	for(var i=0; i<lis.length; i+=2)
	lis[i].style.background = 'rgba(246, 246, 246, 0.5)';
}
window.onload = bgChange;
</script>
<div class="qrcode">
  <img src="<?php $this->options->weixin(); ?>" width="126" height="136" alt=""> </div>
<footer>
  <p>Copyright &copy; 2015-2016 <a href="<?php $this->options->siteUrl(); ?>">
    <?php $this->options->title() ?>
    </a> <br>
    Powered by <a href="http://typecho.org/">Typecho</a>自豪的采用<a href="http://yiyeti.cc/zheteng/132.html" target="_blank">Sgreen</a>主题 托管于<a href="http://www.cefhost.cn/" target="_blank">优易主机</a>&<a href="http://www.qiniu.com/" target="_blank">七牛云</a> </p>
  <?php $this->footer(); ?>
<script>
  // Init Lightense
  window.addEventListener('load', function () {
    var el = document.querySelectorAll('img:not(.no-lightense),.lightense');
    Lightense(el);
  }, false);
</script>
</footer>
<div class="toTop">TOP</div>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
<script src="<?php $this->options->themeUrl('js/scrolltop.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/gbook_front.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/prism.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/smoothscroll.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/lightense.js'); ?>"></script>
</body>
</html>