<?php
header('Access-Control-Allow-Origin:*'); 
header("Access-Control-Allow-Method:POST,GET");  
require_once dirname(__FILE__).'/config.inc.php';
$jsonp = $_POST["data"];
$jsonp=json_decode($jsonp);
$title=str_replace(' - Hello World','',$jsonp->title);
$rows = $db->fetchAll($db->select()->from('table.contents')->where('title = ?', $title));
$db->query($db->insert('table.comments')->rows(array('cid'=>$rows['0']['cid'],'created' =>$jsonp->comments['0']->ctime, 'author' => $jsonp->comments['0']->user->nickname, 'ownerId' =>$jsonp->comments['0']->cmtid , 'url' => $jsonp->comments['0']->user->userurl,
'ip' => $jsonp->comments['0']->ip, 'agent' => $jsonp->comments['0']->useragent, 'text' => $jsonp->comments['0']->content, 'type' => 'comment', 'status' => 'approved', 'parent' => $jsonp->comments['0']->replyid)));

