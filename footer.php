<?php if(!defined('APP_RAN')){ die(); } 

require_once('config.php');

$target_dir = dirname(__FILE__);
$auth = file_get_contents($target_dir . '/session.php');

?>

<input type="checkbox" style="display: none;" id="menu_tray_checkbox"/>
<label for="menu_tray_checkbox" id="bottom_toggle" class="dict" accesskey="t" style="position: fixed; bottom: 35px; z-index: 9;" >
	<picture style="position: fixed; bottom: 50px; left: calc(50vw - 307px) !important;">
    	<source srcset="<?php echo constant('BASE_URL'); ?>images/feed_list_dark.png" media="(prefers-color-scheme: dark)">
    	<img src="<?php echo constant('BASE_URL'); ?>images/feed_list_light.png" alt="menu"/>
    </picture>
</label>

<div id="menu_tray" style="overflow-y: scroll; transition: transform .4s ease-in-out; position: fixed; top: 0px; bottom: 0px; left: -395px; height: auto; width: 375px; z-index: 99; padding: 20px 20px 20px 0px; line-height: 1.6em; text-align: right; margin-bottom: 0px;">


<div class="nameSpan" style="font-weight: bold;">
  <nav>
	<a href="<?php echo BASE_URL; ?>" style="font-size: 1.2em;">Home</a><br/>
	<div class="spacer"></div>
<?php
$pages = $target_dir.'/pages/';

foreach(glob($pages.'*.md') as $i=>$file) {
	$pagename = rtrim(explode('/',$file)[5], '.md');
	$link = str_replace('_', ' ', $pagename);
	echo '<a href="'.BASE_URL.$pagename.'">'.$link.'</a>';
	echo '</br>';
}
if (!empty($pagename)) {
	echo '<div class="spacer"></div>';
}
?>
    <a href="<?php echo BASE_URL; ?>feeds/" title="Subscribe to regular & daily RSS feeds">Feeds</a>
    </br>
    <a href="<?php echo BASE_URL; ?>about/">ABOUT</a>
    </br>
    <a href="<?php echo BASE_URL; ?>colophon/">COLOPHON</a>
    <div class="spacer"></div>
<?php
    if (isset($_SESSION['hauth']) && $_SESSION['hauth'] == $auth) {
?>		
        <a id="admin" href="<?php echo BASE_URL; ?>admin/" style="position: absolute; bottom: 20px; left: 345px;">
            <picture>
                <source srcset="<?php echo constant('BASE_URL'); ?>images/admin_dark.png" media="(prefers-color-scheme: dark)">
                <img src="<?php echo constant('BASE_URL'); ?>images/admin_light.png" style="width: 18px;" />
            </picture>
        </a>
<?php
    } else {
?>
        <div style="text-transform: lowercase; font-size: 20px; position: absolute; bottom: 23px; left: 345px;">
			<a accesskey="l" href="<?php echo BASE_URL; ?>login/" class="menuLogin">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-fingerprint" viewBox="0 0 16 16">
				<path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
				<path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115V7Zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
				<path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
				<path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
				<path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49Z" />
			</svg></a>
		</div>
<?php
    }
?>
</nav>
</div>
        
</div>

<!-- div class="top_fade" style="position: fixed; top: 0px; left: 0px; z-index: 2; width: 100%; background-image: linear-gradient(0deg, rgba(255,255,255,0), #ffffff); height: 30px;" -->
<!--/div -->

<div class="bottom_fade" style="position: fixed ; bottom: 40px; left: 0px; z-index: 2; width: 100%; background-image: linear-gradient(rgba(255,255,255,0), #ffffff); height: 48px;">
</div>
<div class="linksDiv day-links bottom_solid" style="margin-bottom: 0px; position: fixed ; bottom: 0px; left: 0px; z-index: 2; text-align: center; width: 100%; background: #ffffff; height: 40px;">
    
</div>

<div class="h-card p-author vcard author">
    <img class="u-photo" src="<?php echo constant('AVATAR'); ?>" alt="<?php echo constant("NAME"); ?>"/>
    <a class="u-url u-uid" rel="me" href="<?php echo constant('BASE_URL'); ?>"><?php echo constant("NAME"); ?></a>
    <a rel="me" class="u-email" href="mailto:<?php echo constant("MAILTO"); ?>"><?php echo constant("MAILTO"); ?></a>
    <p class="p-note"></p>
</div>
    
<?php

if($pageMobile) {
?>
    <style>
    	@media screen and (max-width: 767px) {

        	#page {
            	min-height: calc(100vh - <?php echo $pageMobile; ?>px) !important;
        	}
    	}
	</style>
<?php
}

if($pageDesktop) {
?>
    <style>
      #menu_tray {
		  	background: rgba(225,225,225,0.95);
	  	}
	  	
	  	#menu_tray a {
	  		color: var(--light-links) !important;
	  		font-weight: bold;
	  		text-decoration: none;
	  	}
	  	
	  	#menu_tray {
			scrollbar-width: thin;
	        scrollbar-color: #999 rgba(225,225,225,0.95);
	  	}
			
		#menu_tray::-webkit-scrollbar {
			width: 1px;
			height: 0px;
		}
		
		#menu_tray::-webkit-scrollbar-track {
		    background: rgba(225,225,225,0.95);
		}
		
		#menu_tray::-webkit-scrollbar-thumb {
		    background: #999;
		}

		#menu_tray_checkbox:checked ~ #menu_tray {
			-webkit-transform: translateX(350px);
			-ms-transform: translateX(350px);
			transform: translateX(350px);
		}
		
		.nameSpan a {
		  margin-right: 0px;
		}
		
		.top_fade, .bottom_fade, .bottom_solid {
         /*pointer-events: none;*/
		}
		
		@media screen and (prefers-color-scheme: dark) {
    		.top_fade {
                background-image: linear-gradient(0deg, rgba(34,34,34,0), #222) !important;
            }
		  
		    .bottom_fade {
                background-image: linear-gradient(rgba(34,34,34,0), #222) !important;
            }
  
            .bottom_solid {
                background: #222 !important;
            }
	    	
		  	#menu_tray {
                background: rgba(75,75,75,0.95);
		  	}
		  	
		  	#menu_tray a {
                color: var(--dark-links) !important;
		  	}
		  	
		  	#menu_tray {
		        scrollbar-color: #999 rgba(75,75,75,0.95);
		  	}
		
			#menu_tray::-webkit-scrollbar-track {
			    background: rgba(75,75,75,0.95);
			}
		}
		
		@media screen and (max-height: 400px) and (orientation: landscape) {
		    #dictionary {
		        top: 23px;
		        left: 178px !important;
		    }
		    
		    #labels {
		        top: 73px;
		        left: 178px !important;
		    }
		    
		    #admin {
		        top: 121px;
		        left: 178px !important;
		    }
		    
		    .dict picture, .dict img {
                left: 23px !important;
            }
		    
    		#menu_tray_checkbox:checked ~ #menu_tray {
    			-webkit-transform: translateX(225px);
    			-ms-transform: translateX(225px);
    			transform: translateX(225px);
    		}
		    
		}
		  
		@media screen and (max-width: 767px) {
            .dict picture, .dict img {
                left: 23px !important;
            }
	      
    		#menu_tray_checkbox:checked ~ #menu_tray {
    			-webkit-transform: translateX(225px);
    			-ms-transform: translateX(225px);
    			transform: translateX(225px);
    		}
		}
		
        @media screen and (min-width: 768px) {

        	#page {
            	min-height: calc(100vh - <?php echo $pageDesktop; ?>px) !important;
        	}
    	}
        
        .paging-navigation a {
            position: relative;
            z-index: 1;   
        }

        .paging-navigation {
            margin: 2.0em auto 6em !important;
        }     
    </style>
<?php
}

?>


<script type="text/javascript">

document.getElementById("page").addEventListener("click", hide_menu);

if (document.body.contains(document.getElementById("wrapper"))) {
    document.getElementById("wrapper").addEventListener("click", hide_menu);
}

function hide_menu() {
  var style = window.getComputedStyle(menu_tray);
  var matrix = style['transform'] || style.webkitTransform || style.mozTransform;
  var posx = matrix.split(',')[4];
  if (document.getElementById('menu_tray_checkbox').checked && posx != 0) {
    document.getElementById('menu_tray_checkbox').checked = false;
  }
}

</script>
</body>
</html>
