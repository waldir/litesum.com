<?php

//Server Configuration
$host = "en.wikipedia.org";
$port = 80;
$path = "/wiki/";
//Plugin Configuration
$use_cache = true;
$cache_life = 10080;
$edit_link = false;
$retrieved_link = false;
$copy_left = "<div class=\"gfdl\">&copy; This material from <a href=\"http://en.wikipedia.org\">Wikipedia</a> is licensed under the <a href=\"http://www.gnu.org/copyleft/fdl.html\">GFDL</a>.</div>";
if( !function_exists(cache_recall) || !function_exists(cache_store) ) { 
        // caching function not available 
        $use_cache = false; 
} 

function cleanUp( $article ) {
    global $edit_link,$retrieved_link,$copy_left;
    $article = str_replace("\n","",$article);
    if(preg_match("/^.*(\<\!\-\- start content \-\-\>.*\<\!\-\- end content \-\-\>).*$/i",$article,$match)!=0) $article = $match[1];
    $article = preg_replace("#\<\!\-\-.*\-\-\>#imseU","",$article);
    $article = preg_replace("#\[\!\&\#.*\]#imseU","",$article);
    if(!$retrieved_link) $article = preg_replace("#\<div\sclass=\"printfooter\".*\<\/div\>#imseU","",$article);
    if(!$edit_link) $article = preg_replace("#\s*\<div\s*class=\"editsection\".*\<\/div\>\s*#imseU","",$article);
    $article = str_replace("/w/","http://en.wikipedia.org/w/",$article);
    $article = str_replace("/wiki/","http://en.wikipedia.org/wiki/",$article);
    $article = str_replace("/skins-1.5/","http://en.wikipedia.org/skins-1.5/",$article);
    $article = "<div class=\"wiki\">".$article.$copy_left."</div>";
    return $article;
}

function getArticle( $title ) {
    global $host,$port,$path,$use_cache,$cache_life;
    if($use_cache) { 
        $function_string = "getArticle(".$title.")"; 
        if($article = cache_recall($function_string,$cache_life)) return $article; 
    } 
    $out = "GET $path$title HTTP/1.0\r\nHost: $host\r\nUser-Agent: Litesum.com\r\n\r\n";
    $fp = fsockopen($host, $port, $errno, $errstr, 30);
    fwrite($fp, $out);
    $article = "";
    while (!feof($fp)) {
        $article .= fgets($fp, 128);
    }
    if(substr($article,0,12)=="HTTP/1.0 301")
    {
        if(preg_match("/^.*Location\:\s(\S*).*$/im",$article,$match)!=0) {
            $article = str_replace("http://en.wikipedia.org/wiki/","",$match[1]);
            $article = getArticle( $article );
        } else {
            $article = "== WIKI Error ==";
        }
    }
    fclose($fp);
	$article = cleanUp($article);
    if($use_cache) cache_store($function_string,$article); 
    return $article;
}

function capitalize($word) {
return strtoupper(substr($word,0 ,1)).substr($word,1);
}
//NO FORCED LOWER CASE, TO PRESERVE, FOR INSTANCE, "McDonald."
//NOTE THE FORCED LOWER CASE IN THE MAIN FUNCTION IS ONLY USED 
//IN MULTI-WORD PREPOSITIONS.

function getTitle($title){

$article=array("a","an","the");

$preposition=array("about","above","across","after","against","along",
"amid","among","around","at","before","behind","below", "beneath",
"beside","besides","between","beyond","but","by","concerning","despite",
"down","during","except","from","in","including", "inside","into","like",
"minus","near","notwithstanding","of","off","on", "onto","opposite","out",
"outside","over","past","per","plus","regarding","since","through",
"throughout","till","to","toward","towards","under","underneath","unless",
"unlike","until","up","upon","versus","via","with","within","without");

$conjunction_coordinating=array("and","but","for","nor","or","so","yet");

$conjunction_subordinating=array("after","although","as","because","if",
"lest","than","that","though","when","whereas","while");

$conjunction_correlative=array("also","both","each","either","neither","whether");

$nocaps=array_merge($article,$preposition,$conjunction_coordinating,
$conjunction_subordinating, $conjunction_correlative);

$multi_word_preposition=array("according to","in addition to","in back of",
"in front of", "in spite of","on top of","other than","together with");

$word=explode(" ",$title);
$first=0;
$n=count($word);$last=$n-1;

$text = str_replace("_", " ", $text);

//CAPITALIZE ONLY WORDS THAT SHOULD BE CAPITALIZED
for($i=0;$i<$n;$i++){
	if(in_array($word[$i],$nocaps)){continue;}
		else{$word[$i]=capitalize($word[$i]);}
	}//END LOOP

	$title=implode(" ",$word);
	
	//REPLACING A STRING THAT MAY HAVE CAPITAL LETTERS
	//WITH ONE THAT IS ALL LOWER-CASE.
	//USE str_ireplace() IF YOU HAVE PHP 5; 
	//IT CAN USE ARRAYS FOR PATTERN AND REPLACEMENT
	foreach($multi_word_preposition as $value){ 
		$title=eregi_replace($value,$value,$title); }
	$word=explode(" ",$title);
	
	//CAPITALIZE FIRST AND LAST WORDS
	$word[$first]=capitalize($word[$first]);
	$word[$last]=capitalize($word[$last]);
	

	
	$title = implode(" ",$word);
	$title = str_replace(" ", "_", $title);
	return $title;

}//END englishTitle()

function getTopic ( $text ) {
	$text = str_replace("_", " ", $text);
	return $text;
}

function strip_selected_tags($str, $tags = "", $stripContent = false) {
   preg_match_all("/<([^>]+)>/i", $tags, $allTags, PREG_PATTERN_ORDER);
   foreach ($allTags[1] as $tag) {
   $replace = "%(<$tag.*?>)(.*?)(<\/$tag.*?>)%is";
       if ($stripContent) {
           $str = preg_replace($replace,'',$str);
       }
           $str = preg_replace($replace,'${2}',$str);
   }
   return $str;
}

function formatText ( $text, $title ) {
	// Ignore the information box on the right side
	$text = strip_selected_tags($text, "<table>", true);
	// Get rid of internal citations
	$text = preg_replace('/\\[[^\\]]*\\]/', '', $text);
	// Escape apostrphes
	$text = addslashes($text);
	// Replace Wikipedia links with our links
	$text = str_replace("\"http://en.wikipedia.org/wiki/", "\"/?q=", $text);
	// Strip all HTML (including wiki links, etc) except formatting and links
	$text = strip_tags($text, '<b>,<i>,<a>,<ul>,<li>,<p>,<div>,<span>');
	if (strpos($text, "notice metadata") && strpos($text, "disambig")) {
		// Take everything before the first </p>
		$text = substr($text, strpos($text, "<p>"), strlen($text));
		$text = substr($text, 0, strpos($text, "<div class"));
	} else {
		// Take everything after the first <p>
		$text = substr($text, strpos($text, "<p>"), strlen($text));
		$text = substr($text, 0, strpos($text, "</p>"));
	}




	return $text;
}

?>