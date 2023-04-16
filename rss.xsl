<?xml version="1.0" ?>
<xsl:stylesheet version="3.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <title><xsl:value-of select="/rss/channel/title"/> Web Feed</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <style type="text/css">
            
            html{
                font-family: sans-serif;
            	font-size: 16px;
            }
            
            body {
                margin:0;
            }
            
            article, details, header, main, menu, nav, section {
                display:block;
            }
            
            header {
                margin-bottom: 40px;   
            }
            
            a {
                color: #1B597B;   
            }
            
            h1 {
                font-size: 170%;
                margin-block-end: 0;
            }
            
            h2 {
                font-size: 150%;
            }
            
            h3 {
                font-size: 140%;
                margin-block-end: 0em;
            }
            
            .bg-yellow {
                background-color: #fff5b1 !important;
                padding: 10px 15px;
            }
            
            /* Images */

            .i50 {
            	width: 50%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .i60 {
            	width: 60%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .i75 {
            	width: 75%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .i80 {
            	width: 80%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .i90 {
            	width: 90%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .i100 {
            	width: 100%;
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 1em auto 1.25em;
            }
            
            .noradius {
            	border-radius: 0 !important;
            }
            
            .center, .aligncenter {
            	clear: both;
            	text-align: center;
            	display: block;
            	margin: 0.75em auto 1.25em;
            	width: auto;
            }
            
            .alignleft {
            	display: inline;
            	float: left;	
            	margin-right: 1.5em;
            	margin-top: .75em;
            	margin-bottom: .75em;
            }
            
            .alignright {
            	display: inline;
            	float: right;	
            	margin-left: 1.5em;
            	margin-top: .75em;
            	margin-bottom: .75em;
            }
            
            .left {
                float: left;
                width: 48%;
                margin: 1em 0px;
            }
            
            .right {
                float: right;
                width: 48%;
                margin: 1em 0px;
            }
            
            .overlay {
                z-index: 10;
                position: absolute;
                top: -50px;
                left: calc(50% - 10px);
                width: 20px;
            }

            
            .container-md {
                max-width: 768px;
                margin-right: auto;
                margin-left: auto;
            }

            .markdown-body {
            	font-family: sans-serif;
            	font-size: 16px;
            	line-height: 1.5;
            	word-wrap: break-word;
            }
        
            .markdown-body hr {
                border: none;
                overflow: visible;
                text-align: center;
                height: 0px;
                width: 33%;
                margin: 10px auto 20px;
            }
            
            .markdown-body hr:after {
                color: #24292e;
                content: '***' !important;
                padding: 0 5px;
                position: relative;
                top: -0.35em;
                font-size: 24px;
            }
            
            .markdown-body blockquote {
                border-radius: 0px 8px 8px 0px;
            	-webkit-border-radius: 0px 8px 8px 0px;
            	border-top: 0px solid #f9f9f9;
            	border-right: 0px solid #f9f9f9;
            	border-bottom: 0px solid #f9f9f9;
            	overflow: hidden;
            	position: relative;
            	left: -18px;
            	border-left: 2px solid #1B597B !important;
            	background: #f9f9f9;
            	color: #555;
            	font-style: italic;
            	font-weight: 300;
            	margin: 0 0 1.5em 35px;
            	padding: 16px;
            }
            
            .badge {
                background-color: #dd0000;
                color: white;
                font-size: 85%;
                font-weight: bold;
                border-radius: 5px;
                padding: 1px 4px 1px;
                text-transform: uppercase;
                position: relative; bottom: 1px;
            }
            
            @media screen and (max-width: 767px) {
                .container-md {
                    max-width: 90%;
                }
                
                html {
                    font-size: 18x;
                }
            }
        </style>
      </head>
      <body>
        <nav class="container-md markdown-body">
            <p class="bg-yellow">
                This is an <strong>RSS feed</strong>. <strong>Subscribe</strong> by copying the URL from the address bar into your newsreader.
                <br/>
                For more information visit <a href="https://aboutfeeds.com/">aboutfeeds.com</a>
            </p>
        </nav>
        <div class="container-md markdown-body">
          <header>
            <h1 class="border-0">
              <xsl:value-of select="/rss/channel/title"/>
            </h1>
            <p><xsl:value-of select="/rss/channel/description"/></p>
            <a class="head_link" target="_blank">
              <xsl:attribute name="href">
                <xsl:value-of select="/rss/channel/link"/>
              </xsl:attribute>
              <strong>Visit the blog &#x2192;</strong>
            </a>
          </header>
          <h2>Recent Items</h2>
          <xsl:for-each select="/rss/channel/item">
            <div style="border-bottom: 1px dotted #999; margin-bottom: 35px; padding-bottom: 10px;">
              <h3>
                <a target="_blank" style="text-decoration: none;">
                  <xsl:attribute name="href">
                    <xsl:value-of select="link"/>
                    </xsl:attribute>
                    <xsl:choose>
                        <xsl:when test="title!=''">
                            <span style="margin-bottom: font-size: 150%;"><xsl:value-of select="title"/></span>
                        </xsl:when>
                        <xsl:otherwise>  
                            <span style="float: left; margin-right: 10px; margin-bottom: 0; line-height: 24px; font-size: 100% !important;">#</span>
                        </xsl:otherwise>
                    </xsl:choose>
                </a>
              </h3>
              <div>
                <xsl:value-of select="description" disable-output-escaping="yes" />
              </div>
            </div>
          </xsl:for-each>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>