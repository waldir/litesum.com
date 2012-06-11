<?php include("functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Litesum - Instant Wikipedia Summaries</title>
  <meta name="description" content="Litesum instantly extracts brief summaries from Wikipedia on any given topic. Created by Jake Jarvis.">
  <meta name="keywords" content="wikipedia, wiki, encyclopedia, pedia, litesum, ajax, instant, jake jarvis, jakejarvis">
  <link rel="stylesheet" href="/style.css">
  <script src="/article.js"></script>
  <script>
    function sf() {
      document.f.q.focus();
    }
  </script>
</head>

<body onload="sf();getArticle();">

  <div class="wrapper">
    <div class="center"><a href="/"><img src="/header.gif" alt="LiteSum - Instant Wikipedia Summaries"></a></div>

    <form action="/" method="get" name="f">
      <input type="text" value="<?php echo getTopic($_GET['q']) ?>" name="q" id="q" class="text" autocomplete="off">
    </form>

    <div id="summary">
      <p class="big"><b>Type a topic above and wait for results.</b></p>
      <p class="center">A brief summary of the requested topic will appear instantly.</p>
    </div>

    <p class="small" style="margin-top:55px;"><span style="color:#e6a728;">Lite</span><span style="color:#356aa0;">sum</span> by <a href="http://www.jakejarvis.com/">Jake Jarvis</a>.</p></div>
  </div>

  <script>
    var _gauges = _gauges || [];
    (function() {
      var t   = document.createElement('script');
      t.type  = 'text/javascript';
      t.async = true;
      t.id    = 'gauges-tracker';
      t.setAttribute('data-site-id', '4fd6063c613f5d04b0000032');
      t.src = '//secure.gaug.es/track.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(t, s);
    })();
  </script>

  <script>
    var _gaq = [['_setAccount', 'UA-1563964-3'], ['_setDomainName', 'litesum.com'], ['_trackPageview']];
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>

</body>
</html>