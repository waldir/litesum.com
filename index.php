<?php include("functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Litesum - Instant Wikipedia Summaries</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Litesum instantly extracts brief summaries from Wikipedia on any given topic. Created by Jake Jarvis." />
	<meta name="keywords" content="wikipedia,wiki,encyclopedia,pedia,litesum,ajax,jake jarvis,jakejarvis" />

	<script type="text/javascript" src="/article.js"></script>

	<script>
		function sf() {
			document.f.q.focus();
		}
	</script>

	<style type="text/css" media="all">
		@import "/style.css";
	</style>
</head>

<!--<?php echo md5(rand()) ?>-->

<body onload="sf();getArticle();">

<div class="wrapper">
	<div class="center"><a href="/"><img src="/img/header.gif" alt="LiteSum - Instant Wikipedia Summaries"/></a></div>

	<form action="/" method="get" name="f">
		<input type="text" value="<?php echo getTopic($_GET['q']) ?>" name="q" id="q" class="text" autocomplete="off"/>
	</form>

	<div id="summary">
		<p class="big"><b>Type a topic above and wait for results.</b></p>
		<p class="center">A brief summary of the requested topic will appear instantly.</p>
	</div>

	<p class="small" style="margin-top:55px;"><span style="color:#e6a728;">Lite</span><span style="color:#356aa0;">sum</span> by <a href="http://www.jakejarvis.com/">Jake Jarvis</a>.</p>
</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1563964-3";
urchinTracker();
</script>

</body>
</html>