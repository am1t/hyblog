<?php
/*
    Name: hyblog home
*/

// Initialise session
session_start();

define('APP_RAN', '');

require_once('config.php');
require_once('content_filters.php');
require_once('Parsedown.php');
require_once('ParsedownExtra.php');
require_once('functions.php');

$target_dir = dirname(__FILE__); //$_SERVER['DOCUMENT_ROOT']

$auth = file_get_contents($target_dir . '/session.php');

$today = date('Y-m-d');
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$year = date('Y', strtotime($date));
$month = date('m', strtotime($date));
$day = date('d', strtotime($date));

if (!file_exists($target_dir.'/posts/'.$year.'/'.$month.'/'.$date.'.md') && (!isset($_SESSION['hauth']) || $_SESSION['hauth'] != $auth)) {
$files = glob($target_dir.'/*/*/*/*.md');
	foreach($files as $postfile) {
		if (substr(explode('/',$postfile)[7],0,1) != 'c') {
			$filedate[] = substr(explode('/',$postfile)[7],0,10);
		}
	}
	
	$prev_check = date('Y-m-d', strtotime($date .' -1 day'));
	$before = date('Y-m-d', strtotime($filedate[0].' -1 day'));
	$length = count($filedate);
	$newest = $filedate[$length-1];
	$after  = date('Y-m-d', strtotime($newest.' +1 day'));
				
	rsort($filedate);
	
	do {
		foreach($filedate as $file) {
			if ($prev_check == $file) {
					header("location: ".BASE_URL."?date=".$prev_check);
				    //echo '<meta http-equiv="refresh" content="0; URL='.BASE_URL.'?date='.$prev_check.'">';
				    exit;
				}
			}
			$prev_check = date('Y-m-d', strtotime($prev_check .' -1 day'));
	}  while (strtotime($prev_check) >= strtotime($before));
}

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo NAME.' - '.$date; ?></title>
	<meta name="description" content="<?php echo DESCRIPTION; ?>">
  	<link rel="icon" type="image/png" href="<?php echo AVATAR; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>bigfoot/bigfoot-bottom.css" type="text/css" media="all">
	<link rel="stylesheet" href="style_min.css" type="text/css" media="all">
    	<link rel="home alternate" type="application/rss+xml" title="<?php echo NAME; ?> feed" href="<?php echo BASE_URL; ?>hyblog.xml">
    	<link rel="canonical" href="<?php echo BASE_URL; ?>">
    	<link rel="me" href="mailto:<?php echo MAILTO; ?>">
	<style>
		.replies {
			height: auto;	
		}
		
		@media screen and (min-width: 768px) {
		    .nav-next a {
		        padding-right: 25px;
		    }
		    .nav-previous a {
		        padding-left: 25px;
		    }
		}
	</style>
	
	<script src="script.js"></script>
	
</head>

<body>
	<div id="wrapper" style="width: 100vw; position: absolute; left: 0px;">
	    <div id="page" class="hfeed h-feed site">
	        <header id="masthead" class="site-header">
	            <div class="site-branding">
	                <h1 class="site-title">
	                    <a href="<?php echo BASE_URL; ?>" rel="home">
	                        <span class="p-name"><?php echo NAME;?></span>
	                    </a>
	                </h1>
	                <?php echo SUBTITLE;?>
	            </div>
	        </header>
	        <div id="primary" class="content-area">
				<main id="main" class="site-main today-container">

					<h2><span class="dateSpan">
					<?php echo ($today == $date) ? 'Today' : date(DATEFORMAT, strtotime($date)); ?>
					</span></h2>
<?php					

if (isset($_SESSION['hauth']) && $_SESSION['hauth'] == $auth) {
	echo '<div id="postwrapper" hx-target="this" hx-post="update.php?date='.$date.'" hx-trigger="dblclick">';
} else {
	echo '<div id="postwrapper">';
}

if (file_exists($target_dir.'/posts/'.$year.'/'.$month.'/'.$date.'.md')) {		
	$posts = file_get_contents($target_dir.'/posts/'.$year.'/'.$month.'/'.$date.'.md');
	
	if (!empty($posts) && isset($_SESSION['hauth']) && $_SESSION['hauth'] == $auth) {
?>
	<a id="toggle" tabindex="1" class="toggle" onclick="toggleForm()" accesskey="e"><picture>
        <source srcset="../images/add_dark.png" media="(prefers-color-scheme: dark)">
        <img src="../images/add_light.png" />
        </picture>
    </a>
    <a id="cancel" class="cancel" onclick="toggleForm()" accesskey="e"><img  loading="lazy" alt="cancel" src="../images/cancel.png" />
    </a>
    
    <div id="editdiv" style="height: 0px; overflow: hidden;">
    	<iframe id="upload_frame" scrolling="no" loading="lazy" src="uploader.php" style="display: inline;"></iframe>
			<form name="form" method="post" action="addpost.php?date=<?php echo $date; ?>">
			<textarea rows="10" id="content" name="content" class="text" placeholder="Write ..."></textarea>
			<input type="submit" style ="float: right;" value="Post" />
	</form>
    </div>

<?php
	}
} else {
	if (isset($_SESSION['hauth']) && $_SESSION['hauth'] == $auth) {
?>
	<iframe id="upload_frame" scrolling="no" loading="lazy" src="uploader.php" style="display: inline;"></iframe>
	<form name="form" method="post" action="newpost.php?date=<?php echo $date; ?>">
		<textarea rows="10" id="content" name="content" class="text" placeholder="Write ..."></textarea>
		<input type="submit" style ="float: right;" value="Post" />
	</form>
<?php
	}
}



if (isset($posts)) {
	$explode = array_filter(explode('@@', $posts), "strlen");
	foreach ($explode as $p=>$post) {
		$draft = false;
		$post_title = '';
		$content = trim($post);
		$post_array = explode("\n", $content);
	    $size = sizeof($post_array);
		if (substr($post_array[0], 0, 2) === "# ") {
			$length = strlen($post_array[0]);
			$required = $length - 2;
			$post_title = substr($post_array[0], 2, $required);
			$title_in_body = 'true';
			$content = substr($content,$length);
		}
		
		if (substr($post_array[0], 0, 2) === "! ") {
			$draft = true;
		}
		
		$content = explode('!!', $content)[0];
		
		$content = filters($content);
		$Parsedown = new ParsedownExtra();
		$content = $Parsedown->text($content);
		
		// display each post
		
		if (!$draft) {
			echo '<article id="p' . $p . '" class="h-entry hentry">' . PHP_EOL;
			echo '<div class="section">';
			
			if ( file_exists( $target_dir.'/posts/'.$year.'/'.$month.'/comments'.$p.'-'.$date.'.md' ) ) {	$comments = file_get_contents($target_dir.'/posts/'.$year.'/'.$month.'/comments'.$p.'-'.$date.'.md');
				$explode = preg_split('/@@/', $comments, -1, PREG_SPLIT_NO_EMPTY);
				if (count($explode) > 0) {
					$has ='has'; 
				} else {
					$has='';
				}
			} else {
				$has='';
			}
			
			echo '<a id="toggleComments'.$p.'" onclick="toggleComments('.$p.')" class="toggleComments"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="env rss bi bi-envelope" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"></path></svg></a>';
			echo '<a style="text-decoration: none;" href="#p' . $p . '" onclick="toggleComments('.$p.')">';
			
			if (isset($post_title)) {
				echo '<h3 class="p-name postTitle">'.$post_title.'</h3>';
			}
			echo '</a><div class="entry-content e-content"><p>';
			echo '<p>'.$content.'</p>';
			echo '</div>';
			echo '</div>';
			echo '</article>';
			echo '<div class="replies" id="replies'.$p.'" style="display: none;">';
			echo '<h3>Interact</h3>';
			echo '<div id="comment'.$p.'">';
			
			// build a custom mailto:link
                
			$subjecttitle = '';
			$postlink = '';
			$postlink = BASE_URL . '?date=' . $date . '#p' . $p;
			
			if (!empty($post_title)) {
				$subjecttitle = $post_title;
			} else {
				$subjecttitle = $postlink;
			}

			$email = MAILTO;
			$subject = 'Comment: ' . $subjecttitle;
			$body = 'Hi, I was reading through your post (' . $postlink . ') and wanted to send a quick note.';
			$link = encode_email_link($email, $subject, $body);
			echo "<p>Have something you'd like to respond with? &#128227. <a href=\"$link\">Send me a note via email</a> and let's start a conversation on this very topic.</p>";
			echo '</div>';
			echo '</div>';
		}
		unset($draft);
		unset($post_title);
	}
}
?>
					</div>
				</div>
			</main>
		</div>
		<div class="navigation paging-navigation">
			<div class="nav-links">
<?php
				$prev_check = date('Y-m-d', strtotime($date .' -1 day'));
				$next_check = date('Y-m-d', strtotime($date .' +1 day'));
				$match = false;
				
				foreach(glob($target_dir.'/*/*/*/*.md') as $file) {
					if (substr(explode('/',$file)[7],0,1) != 'c') {
						$filedate[] = substr(explode('/',$file)[7],0,10);
					}
				}
				
				$before = date('Y-m-d', strtotime($filedate[0].' -1 day'));
				$length = count($filedate);
				$newest = $filedate[$length-1];
				$after  = date('Y-m-d', strtotime($newest.' +1 day'));
				
				rsort($filedate);
				
				do {
				    foreach($filedate as $file) {
						if ($prev_check == $file) {
							echo "<div class='nav-previous'><a href='".BASE_URL."?date=$prev_check'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-left-circle' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z'></path></svg></a></div>";
							$match = true;
						}
				    }
						$prev_check = date('Y-m-d', strtotime($prev_check.' -1 day'));
					} while (strtotime($prev_check) >= strtotime($before) && $match != true);
				
				$match = false;
				sort($filedate);

                do {
				foreach($filedate as $file) {
					if ($next_check == $file) {
					    if ($next_check == $today) {
					        $next = '';
					    } else {
					        $next = '?date='.$next_check;
					    }
						echo "<div class='nav-next'><a href='".BASE_URL."$next'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-right-circle' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z'></path></svg></a></div>";
							$match = true;
					}
				}
				$next_check = date('Y-m-d', strtotime($next_check.' +1 day'));
				} while (strtotime($next_check) <= strtotime($after) && $match != true);
				
?>
			</div>
		</div>

	<script src="htmx.min.js"></script>
	<script src="jquery.slim.min.js"></script>
	<script src="bigfoot/bigfoot.min.js"></script>
	<script>
	    var bigfoot = $.bigfoot( {
	        positionContent: true,
	        preventPageScroll: true
	    } );
	</script>
	

<?php
	$pageDesktop = "157";
	$pageMobile = "207";
	include('footer.php');
?>
