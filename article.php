

<?php include("functions.php"); ?>


divSummary.innerHTML = '<?php echo formatText(getArticle(getTitle($_GET['q'])), getTitle($_GET['q'])) ?></p><!--<p style="text-align:center;"><iframe src="/gads.php?kw=<?php echo  $_GET['q'] ?>" style="border:0;width:475px;height:65px;" scrolling="no"></iframe></p>--><p class="small"><a href="http://en.wikipedia.org/wiki/<?php echo getTitle($_GET['q']) ?>" target="new"><b>Read the full article.</b></a><br />Summary extracted from <a href="http://en.wikipedia.org">Wikipedia</a> under <a href="http://www.gnu.org/copyleft/fdl.html">GFDL</a>.</p>';
var sum = divSummary.innerHTML;



if (sum.indexOf("Wikipedia does not have an article with this exact name.") > 0) {
	divSummary.innerHTML = '<p style="color:#ff0000;" class="big">No results found for "<?php echo $_GET['q'] ?>".</p>';
}