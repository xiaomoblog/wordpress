<?php
class Sitemap_Action extends Typecho_Widget implements Widget_Interface_Do
{
	public function action()
	{
		$db = Typecho_Db::get();
		$options = Typecho_Widget::widget('Widget_Options');

		$pages = $db->fetchAll($db->select()->from('table.contents')
		->where('table.contents.status = ?', 'publish')
		->where('table.contents.created < ?', $options->gmtTime)
		->where('table.contents.type = ?', 'page')
		->order('table.contents.created', Typecho_Db::SORT_DESC));
		
		$cates = $db->fetchAll($db->select()->from('table.metas')
		->where('table.metas.type = ?', 'category')
		->order('table.metas.order', Typecho_Db::SORT_DESC));
		
		$tags = $db->fetchAll($db->select()->from('table.metas')
		->where('table.metas.type = ?', 'tag')
		->order('table.metas.count', Typecho_Db::SORT_ASC));

		$articles = $db->fetchAll($db->select()->from('table.contents')
		->where('table.contents.status = ?', 'publish')
		->where('table.contents.created < ?', $options->gmtTime)
		->where('table.contents.type = ?', 'post')
		->order('table.contents.created', Typecho_Db::SORT_DESC));

		header("Content-Type: application/xml");
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach($articles AS $article) {
			$type = $article['type'];
			$article['categories'] = $db->fetchAll($db->select()->from('table.metas')
					->join('table.relationships', 'table.relationships.mid = table.metas.mid')
					->where('table.relationships.cid = ?', $article['cid'])
					->where('table.metas.type = ?', 'category')
					->order('table.metas.order', Typecho_Db::SORT_ASC));
			$article['category'] = urlencode(current(Typecho_Common::arrayFlatten($article['categories'], 'slug')));
			$routeExists = (NULL != Typecho_Router::get($type));
			$article['pathinfo'] = $routeExists ? Typecho_Router::url($type, $article) : '#';
			$article['permalink'] = Typecho_Common::url($article['pathinfo'], $options->index);

			echo "\t<url>\n";
			echo "\t\t<loc>".$article['permalink']."</loc>\n";
			echo "\t\t<lastmod>".date('Y-m-d\TH:i:s\Z',$article['modified'])."</lastmod>\n";
			echo "\t\t<changefreq>always</changefreq>\n";
			echo "\t\t<priority>0.8</priority>\n";
			echo "\t</url>\n";
		}		
		foreach($pages AS $page) {
			$type = $page['type'];
			$routeExists = (NULL != Typecho_Router::get($type));
			$page['pathinfo'] = $routeExists ? Typecho_Router::url($type, $page) : '#';
			$page['permalink'] = Typecho_Common::url($page['pathinfo'], $options->index);

			echo "\t<url>\n";
			echo "\t\t<loc>".$page['permalink']."</loc>\n";
			echo "\t\t<lastmod>".date('Y-m-d\TH:i:s\Z',$page['modified'])."</lastmod>\n";
			echo "\t\t<changefreq>always</changefreq>\n";
			echo "\t\t<priority>0.8</priority>\n";
			echo "\t</url>\n";
		}
		foreach($tags AS $tag) {
			$type = $tag['type'];
			$routeExists = (NULL != Typecho_Router::get($type));
			$tag['pathinfo'] = $routeExists ? Typecho_Router::url($type, $tag) : '#';
			$tag['permalink'] = Typecho_Common::url($tag['pathinfo'], $options->index);

			echo "\t<url>\n";
			echo "\t\t<loc>".$tag['permalink']."</loc>\n";
			//echo "\t\t<lastmod>".date('Y-m-d\TH:i:s\Z',time())."</lastmod>\n";
			echo "\t\t<changefreq>always</changefreq>\n";
			echo "\t\t<priority>0.4</priority>\n";
			echo "\t</url>\n";
		}
		foreach($cates AS $cate) {
			$type = $cate['type'];
			$art_rs = $db->fetchRow($db->select()->from('table.contents')
					->join('table.relationships', 'table.contents.cid = table.relationships.cid')
					->where('table.contents.status = ?', 'publish')
					->where('table.relationships.mid = ?', $cate['mid'])
					->order('table.relationships.cid', Typecho_Db::SORT_DESC)
					->limit(1));
			$routeExists = (NULL != Typecho_Router::get($type));
			$cate['pathinfo'] = $routeExists ? Typecho_Router::url($type, $cate) : '#';
			$cate['permalink'] = Typecho_Common::url($cate['pathinfo'], $options->index);

			echo "\t<url>\n";
			echo "\t\t<loc>".$cate['permalink']."</loc>\n";
			echo "\t\t<lastmod>".date('Y-m-d\TH:i:s\Z',$art_rs['modified'])."</lastmod>\n";
			echo "\t\t<changefreq>always</changefreq>\n";
			echo "\t\t<priority>0.5</priority>\n";
			echo "\t</url>\n";
		}
		echo "</urlset>";
	}
}
