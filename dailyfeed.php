<?php

//if(null === APP_RAN) {
	define('APP_RAN', '');
//}

require_once('config.php');
require_once('content_filters.php');
require_once('ping.php');
require_once('Parsedown.php');
require_once('ParsedownExtra.php');

$target_dir = dirname(__FILE__);
$rss = $target_dir.'/daily.xml';

if ( file_exists( $rss ) ) {
	unlink( $rss );
}

$rssfile = fopen($rss, 'w');

fwrite($rssfile, '<?xml version="1.0" standalone="yes" ?>'.PHP_EOL);
fwrite($rssfile, '<?xml-stylesheet href="/rss.xsl" type="text/xsl"?>'.PHP_EOL);
fwrite($rssfile, '<rss version="2.0"'.PHP_EOL);
fwrite($rssfile, 'xmlns:atom="http://www.w3.org/2005/Atom">'.PHP_EOL);
fwrite($rssfile, '<channel>'.PHP_EOL);
fwrite($rssfile, '<title>'.NAME.'</title>'.PHP_EOL);
fwrite($rssfile, '<description>'.NAME.' Daily Digest</description>'.PHP_EOL);
fwrite($rssfile, '<link>'.BASE_URL.'</link>'.PHP_EOL);
fwrite($rssfile, '<lastBuildDate>' . gmdate('D, d M Y H:i:s') . ' +0530</lastBuildDate>'.PHP_EOL);
fwrite($rssfile, '<cloud domain="rpc.rsscloud.io" port="5337" path="/pleaseNotify" registerProcedure="" protocol="http-post"/>'.PHP_EOL);
fwrite($rssfile, '<atom:link href="' .BASE_URL. 'daily.xml" rel="self" type="application/rss+xml" />'.PHP_EOL);
fwrite($rssfile, '<generator>hyblog</generator>'.PHP_EOL);
fwrite($rssfile, '<language>en-GB</language>'.PHP_EOL);

$postfiles = glob($target_dir.'/*/*/*/*.md');
foreach($postfiles as $postfile) {
	if (substr(explode('/',$postfile)[7],0,1) != 'c') {
		$filedates[] = substr(explode('/',$postfile)[7],0,10);
	}
}

// get files and use only last 5

rsort($filedates);
array_splice($filedates,5);

//get posts from each file

foreach($filedates as $file) {
	$fullcontent = '';
	$year = date('Y', strtotime($file));
	$month = date('m', strtotime($file));
	$posts = file_get_contents($target_dir.'/posts/'.$year.'/'.$month.'/'.$file.'.md');
	
	$explode = array_filter(explode('@@', $posts),'strlen');
    //$explode = array_reverse($explode);
    $p = count($explode);
	$post_title = $h2 = '';
	foreach ($explode as $i=>$post) {
		$draft = false;
		$title_in_body = false;
		$post_title = '';
		$content = trim($post);
		$post_array = explode("\n", $content);
	    $size = sizeof($post_array);
	    
	    // check for title
	    
		if (substr($post_array[0], 0, 2) === "# ") {
			$length = strlen($post_array[0]);
			$required = $length - 3;
			$post_title = substr($post_array[0], 2, $required);
			$title_in_body = true;
			$content = substr($content,$length);
		}
		
		//check if draft
		
		if (substr($post_array[0], 0, 2) === "! ") {
			$draft = true;
			$p-=1;
		}
		
		// trim date from posts and sort content
		
		$post_parts = explode('!!', $content);
		$content = trim($post_parts[0]);
		$content = filters($content);
		$Parsedown = new ParsedownExtra();
		$feedcontent = $Parsedown->text($content);
		$feedcontent = substr($feedcontent, 3);
		if (substr($feedcontent, -4) == '</p>') {
			$feedcontent = substr($feedcontent, 0, -4);
		}
		
		if ($post_title != '') {
			$h2 = '<span style="font-size: 24px; text-transform: uppercase;"><strong>' . $post_title . '</strong></span></br>';
		}
		
		// add post to day
		
		if (!$draft) {
			$feedcontent = '<p><a href="' . BASE_URL . '?date=' . $file . '#p' . $i . '" style="text-decoration: none; float: left; margin-right: 8px;">#</a> ' . $h2 . $feedcontent . '</p>'.PHP_EOL;
			$fullcontent .= $feedcontent;
		}
	}
		
	// add each day
	
	fwrite($rssfile, '<item>'.PHP_EOL);
	
	fwrite($rssfile, '<link>'.BASE_URL.'?date='.$file.'</link>'.PHP_EOL);
    fwrite($rssfile, '<guid isPermaLink="false">'.BASE_URL.'?date='.$file.'</guid>'.PHP_EOL);
	fwrite($rssfile, '<title>Notes from ' . date("D, d M Y", strtotime($file)) . '</title>'.PHP_EOL);
	fwrite($rssfile, '<description><![CDATA['.$fullcontent.']]></description>'.PHP_EOL);
	fwrite($rssfile, '<pubDate>' . date('D, d M Y H:i:s', strtotime('+1 day',strtotime($file))) . ' +0530</pubDate>'.PHP_EOL);
	fwrite($rssfile, '</item>'.PHP_EOL);

}

fwrite($rssfile, '</channel>'.PHP_EOL);
fwrite($rssfile, '</rss>'.PHP_EOL);
fclose($rssfile);

$feedurl = BASE_URL.'daily.xml';

doPing($feedurl);

?>