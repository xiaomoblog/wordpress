<?php 

	/**
	 * sharelike
	 */

?>

<?php if ( akina_option('post_like') == 'yes') { ?>
<div class="post-like">
<a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.get_the_ID()])) echo 'done';?>">
	<i class="iconfont">&#xe669;</i> <span class="count">
		<?php if( get_post_meta(get_the_ID(),'specs_zan',true) ){
			echo get_post_meta(get_the_ID(),'specs_zan',true);
		} else {
			echo '0';
		}?></span>
	</a>
</div>
<?php } ?>
<?php if ( akina_option('post_share') == 'yes') { ?>		
<div class="post-share">
<ul class="sharehidden">
	<li><a href="http://www.jiathis.com/send/?webid=weixin&url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" onclick="window.open(this.href, 'renren-share', 'width=490,height=700');return false;" class="s-weixin"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAC4ElEQVRYR+1XbU4aURQ95wmNiQy1KyiuoOMKCkmHv9oVFFdQXYG6AnEF6gqkf4cf0BVIVyCuoHTQxPDxbvMeDg7DwMBoYpp0fhnfzD3nnnfvuRfijR++MT7+EQJ+4TMUS0pYMopp0W3kR3eoPHZfquBiBZqFMsHvBPcXgYigS+qGzo3Os5KZJ9DCNkfOxTLgBYROtBecrqvILAF/yyU3WgS21w1k3hdBR/JBBRX0Vv3+mYDNvHibFTwEXJfElACbTotgeRoIuJPcoAw89jh02iQ/zWQlcqWr/Rp8p6bIi1jGp9oLTlZRYUKgWSgrqNaiIKpZNMGOo+c6N9gJC49+8ZaE7ZDwiZ4vI2IJKN+5BPkt+mJUSjad64SinBSdv+UqbtzEQTRwBC+op6lgCbBZ/J3l7gXohd+JyC9C2hrsTEB1B9WHp78X05go0CxKGtOF56YWFBpKY0/AcvwqBNIWYQP54CqpOzITEOCPiByS2FvFM4xaQjnAl34jmkwmAs/gPFv/6nRde/dHIYmFRbjsSrTIAcHjuNyrXqP5HtX+pa2/JW2YGE9EfhLoRrvGKpIbuBhubMc7Qst4F/lxj6N3HQLvTVB7HbnBrmnjqBE1CO6lZWHYx43Htmw12LUZRTzBAnnBh6f/35Bwp/FFn+vq/eGsFSc5XoyRhq4kmJadAxYoCvI0H0DpRV3WqiDoSjXYmR1Gk0l4uUwJYzAKOEtTapVz7QVM3AeW+YKmfFXC61UA0t5JJhC1VpEroRnNdAl8tP6WUANpQEnnYoadF5TmFFB+oS6gK9CHc1bqb7nIP3QTp+O6LOaKMAzQ2iylrlfJ03NlCjb7XOAaa86+FSfvAakkJi46LofqZidgoHynRrIeGkwaus1cxvvRq30ZAYPY2iypYf5EyP00IgL5IV5/Zst+OYFo2pPamK51WqRr94L8Q1cNnbqxb9N6c9MwTbpXOzcFbp7ID5rXVSAD0/8E/gI9jlAw7Xo40QAAAABJRU5ErkJggg=="/></a></li>
	<li><a href="http://www.jiathis.com/send/?webid=qzone&url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" onclick="window.open(this.href, 'weibo-share', 'width=730,height=500');return false;" class="s-qq"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAACmklEQVRYR8WWzXEaQRCFv4YTpaWMIhCKwPio1cFSBmRgHIGlCIwjMIpAVgRyBrYOwFE4AqMMUImyfBGt6tllveCd/aNsTdVepma2X79+/aaFF16yS3y9pSNvWOzyj50APEz4LqBByGldELUBPEw5EeWbBW4Kh60j5nVA1AcQZf82DnoVhAz+G4DlmB7CbTrgXov9OnqoxcBywhfgXRqAKp/axwyrslAZwOOU7pPyczuQKov2Mfv/HEBW9klQ4X1w5NgpvSox4Ms+FW0ehByWjg6UBmCms3zkUqBfEOA8CBmVBZEAsOxQDp6ErkBXV3QRt9dB6JX9YXJOmSEsFBYNYeb2V8wawuJJuQ+Ooz0HIG0qFQLdKZH5GGDgoMJdVDhtHzkviZZPXKZuESeseZM4E6AVcuMLaAk1lI7CtedMYlwbGlhOXO0+VMnEgLlPOV/TGjN6ScTM9roIQs7Wm3+JcDllgGKXSy2F+wYM9kK+unKOGYrwMfNyRptmdkFZEAo3QYu+WbCzZ7j0CtbjEd42NBCqjAReZWWTtt7lxFH62UtZjkHl+oBlpeKU+geE8gMYWL1jY7JyndQJnrRhXrG3anqx12JolJvQWHEtQifn/obgss4VOqG1p0I/LbT1j5w7/o5MytpupZuGJQ3mTXu4hDvfwFIMYMxM4UBiN9twtq2UDICQMOLKsjYcH0vFACZoqX70HArC/PcmF0BNi96AshMDhX5gHRGJ0P8OFMwI+W3ot+Y7hOF6+IiB2jiWBSS3E/JLsDn5mhjuUUZZs5/riF+cIZylfcPcsh36faKIgbQAr5rCsGj+j83J2EiG1jwhFgKwDIxue7urdIMT8IoRwuv6AMb01k9sleDpswYkD3yhD9QNXPbeiwN4Bg68AjDqXDLZAAAAAElFTkSuQmCC"/></a></li>
	<li><a href="http://www.jiathis.com/send/?webid=tsina&url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" onclick="window.open(this.href, 'weibo-share', 'width=550,height=235');return false;" class="s-sina"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADmklEQVRYR+1WXU4aURT+zjgYbTXFVEjAh+JbEyHiCtQVVFcgrkC6AukKyg7EFagrUFfQMWDSN+mDmECNGJq2cWBOc+/MHe78gDTR2IfOC+TO3Hu+c873ffcQXvihF46P/wCevAKtt4UtGLzHoCIRkgCaAFs8oNrSbf0k3PKnB5DKn4FoPY5bzGwlwLvpzqWl3j89ALcCGwSymJ0kyCgC2ALhjQjKjG4CzqYC8VcAbpLvc0hMrTMoaYLP9UzGqekumUv+nJ4rE2hfgXhl95YXus3uRABuFvMbTNgH0UYg0ADb2dv6cTh4O7VSHBB9kOvMzUzn8lD8bS2ulGEYn+Uy+NNSu1EZC0Ag/zU9dwDQ1ogMT7LteuTddTpfUdm6GNha6jTWJIghR5rZdn15JACRhQ06ICLRw/iH+TzbaQSrEvqylSrUQNghxm6mU6/dpAolJhyIz7LtOsUCcIMbp56MRreXcUi2XcG0ueMwthRYQTQD+CgCulWcv1Mll+006HQkgImDT+Dhsw+9BUG0VrrAEwGQbE3MnY4t+wSBfY07vJn53jhrpfJVE1wTqlH8YOaLpU6jGGhBK50/GkM4QaYLAroBDCNMB+Bv2XYjF8arOAHGYbZTL/kApIVO4SiSIOMQDo7j5Ka+FW3rwygLsmn7mzxAOWy/osq/zbniTP+HFfCBVrpwBWCImPmc7H4p0/3aVIe6m+dXZ/q9C7E5DFYYlZMwj4loVQdisrM9yrRkBSLZe+VRh4j3bPB+iBtNcnhX9FgH4nmHBdA7tS5VYdtrejI+TzxzqIJoz3OugLZ13cbxz2RnLZxd3B6lgvAZbgX0G0yzV1cV81dhP5BkHJY54oa61v2AI0wrAoAe7GVVKv8gxj0TV4kpB3DOBJf7ZHzxDpeWqmcWCwCItW0JQPduvaRqnTw9R6rl+rzUsw7Al5q2qKw4tgWCvTydECrwbynxX/VSVcWzVZG5r5Zwb6Ukh9XxaBUFGSChTsTwwHCdyktGkxirhmOWuz+kllgbZ9ybcDbGytCXm0dGKRvmbSExmbX5usREJZ14GKCmm1MrlRdzYCVA2EeCi7iR2zBwlzOfsUPVuGFStkhNSGRUAibmVWfW7pXjDEvnQex1LDmRSIhDtVmOrcA9QEIRmnO6Qe8BHJtwqpOOa4+OZEJSjgExZBbBnIT49QdM93JiwhkNyBp3X8SZWGwLRn34XOuPVuC5Akdk+NyB/tkW/AGViAw/bZdEDAAAAABJRU5ErkJggg=="/></a></li>
	<li><a href="http://www.jiathis.com/send/?webid=douban&url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" onclick="window.open(this.href, 'renren-share', 'width=490,height=600');return false;" class="s-douban"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAABmElEQVRYR+1Vy23CQBB9s3tBcIg7COnAggISKkg6COkguQGXmIvhmBKcDiiBFIBDB4EKwgULIXknWotEDrbxB0sYiTlZ8nzevHkzSzix0Ynr4wIgloH6oGUB4LLH49nucD9nLIDGoF16cV14bc8i9aoJoGzqD+Wr9hbUeuYdiI7Ww2b0+ZHEwkEGyhJjnPh+AZ0HAAYPPdvVtyGz6VtCoNek9cvFwAVAFRhwFLOTWQAABFGXQN1SNJCncJzv+a5hcAl3Jkga+lOxvzrEiBSiyUyrsN9mPJ8WuoRBkGUa9a10CLhnxrs3mgVzTbJ6v+0Q4ZEZE8X+y2Y8Xxz9GDX6rSmIbnUiX/mdxI4s02hs5bf2Y/DSs91mmn4yvYa1ntmUJOcgXIExXY9mnbjE4esH8NPadlM3JxMAXSyc3Ff+TYTaoHvxBZCRtXudNwJAdwui6/0OhWCDWE4CevV8od7CPhL0AKLnHf2WYo4Kj3m5DzwC4D+NaRPM9z/uolYPQDACIFW9+Xr/816kjqBg4sJhmbegcIWUwAuAH/7E0CHFMGPxAAAAAElFTkSuQmCC"/></a></li>
	</ul>
	<i class="iconfont show-share">&#xe6eb;</i>
</div>
<?php } ?>