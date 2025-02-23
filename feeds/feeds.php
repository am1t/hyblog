<?php
 
// Initialise session
session_start();

define('APP_RAN', '');

require_once('../config.php');

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo NAME; ?> - feeds</title>
	<meta name="description" content="<?php echo DESCRIPTION; ?>">
    <link rel="icon" type="image/png" href="<?php echo AVATAR; ?>">
	<link defer rel="stylesheet" href="../style_min.css" type="text/css" media="all">
    <link rel="me" href="mailto:<?php echo MAILTO; ?>" />
	<link rel="me" href="https://micro.blog/colinwalker" />
</head>

<body>
    <div id="page" class="hfeed h-feed site">
        <header id="masthead" class="site-header">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo BASE_URL; ?>" rel="home">
                        <span class="p-name">Subscribe</span>
                    </a>
                </h1>
            </div>
        </header>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<article>
					<div class="entry-content e-content pre-line">
					    <strong>Want to keep up with what I write?</strong>
                        
						<?php

							if (DAILYFEED == 'yes') {
						?>
								Subscribe to the <a href="<?php echo BASE_URL; ?>daily.xml">daily digest</a> RSS feed. It clubs all the posts from the day before and sends a digest at the end of the day. As most posts that I make here are quick shorts notes, this is the best way to follow them.
						<?php
							}
						?>

                        For a more traditional way to follow the posts, subscribe to the <a href="<?php echo BASE_URL; ?>hyblog.xml">posts</a> RSS Feed which is updated as I publish new posts.
                        
                        What's an RSS feed and how do you use it? Find out at <a href="https://aboutfeeds.com">aboutfeeds.com</a>             
	                </div>
	            </article>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #page -->

<?php
    $pageDesktop = "157";
    $pageMobile = "227";
    include('../footer.php');
?>