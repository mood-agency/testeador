<!-- 
	Testeador
	Desarrollado por Argenis Leon. 
	argenisleon@gmail.com. 
	Twitter: @argenisleon.
	
	Mood Agency. Todos Los Derechos Reservados
	
	Todo.
	* SSL compatible
	* Test if web is SSL ready
	* Is using cloudflare? or another CDN
	* facebook og tags?
	* Detectar Doctype
	* Icono de carga al momento de hacer el yslow o pagespeed
	* javascript dentro de la pagina
	* htaccess que este abilitada la compresion y los expiration date
	* Verificar si el tamano de las imagenes es igual al de la ventana donde se despliegan
	
	de joomla
	* Verificar si el administrador esta protegido por plugin OSE
	probar validacion de http://html5.validator.nu
	* Verificar el tag de validacion de Google Plus
	<a href="https://plus.google.com/100162575262429404334" rel="publisher"> <img src="/images/mood_googleplus_logo.png" alt=""> </a>
	
 -->
<?php

$scoreParam = isset($_GET['score']) ? $_GET['score'] : '';
$validateParam = isset($_GET['validate']) ? $_GET['validate'] : '';
$validateFirewall = !empty($firewallParam) ? $firewallParam : "";
$host = isset($_GET['host']) ? $_GET['host'] : '';
$words = !empty($words) ? $words : "";
$firewall = !empty($firewall) ? $firewall : "";
$log =  !empty($log) ? $log : true;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Testeador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        .iframe {
            width: 100%;
            height: 600px;
        }
        .log{
            font-weight: bold;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png"/>
    <script src="js/jquery-2.1.1.js"></script>
    <script>

        $(document).ready(function () {
            /*$('#host').keypress(function(e){
             if (!validateURL ('http://' + $('#host').val())){
             console.log('Host url not valid!');
             }
             });*/
            $('#go_form').submit(function (e) {

                //validateURL ('http://' + $('#host').val());
                //if (!$('#host').val()){
                if (!validateURL('http://' + $('#host').val())) {
                    alert('Host url not valid!');

                    e.preventDefault();
                    return false;
                }
            })
        });

        function validateURL(textval) {
            var urlregex = new RegExp(
                "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
            return urlregex.test(textval);
        }
    </script>
</head>

<body>
<div class="container">

    <h1>
        Testeador v0.615
    </h1>
    <!--<small><a href='http://mood.com.ve'>By mood agency</a></small>-->

    <form id='go_form' action="index.php" method='get'>

        <div class="input">
            <span style="padding:0 5px">http://</span><input name="host" class="span2" id="host"
                                                             value="<?php echo $host ?>" type="text"
                                                             placeholder="Type your host..."/>
            <div id='host-message-validation'></div>
        </div>
        <p>
            <button id='go' class="btn btn-large btn-primary" type="submit">Go!</button>

        </p>
        <label class="checkbox">
            <input type="checkbox" name="score"
                   value="pSyS" <?php echo($scoreParam == 'pSyS' ? ' checked="checked"' : '') ?>>Get pageSpeed & ySlow
            Score<br>
        </label>
        <label class="checkbox">
            <input type="checkbox" name="validate"
                   value="w3c" <?php echo($validateParam == 'w3c' ? ' checked="checked"' : '') ?>>Validate W3C
        </label>
        <label class="checkbox">
            <input type="checkbox" name="firewall"
                   value="test" <?php echo($validateFirewall == 'test' ? ' checked="checked"' : '') ?>>Test Firewall
        </label>


    </form>

    <small><a href='changelog.txt'>Change Log </a></small>


    <?php

    if (!isset($_GET['host']))
        return;

    //$errorCount;

    define("YSLOWTRESHOLD", 90);
    define("PAGESPEEDTRESHOLD", 90);
    define("USERNAME_GTM", 'argenisleon@gmail.com');
    define("PASSWORD_GTM", '05224202ae927d4145d8693c24e0fccf');

    define("TITLE_WORDS_COUNT", 5);
    define("DESCRIPTION_WORDS_COUNT", 10);
    define("KEYWORD_WORDS_COUNT", 10);

    // Load the favicon test class.
    require_once('php/favicon.inc.php'); // Thanks to http://www.controlstyle.com/articles/programming/text/php-favicon/
    // Load the web test framework class.
    require_once("php/Services_WTF_Test.php"); // Thanks to http://gtmetrix.com

    // Load the W3C validatino test class.
    require_once("php/api_w3cvalidation.class.php"); // Thanks to http://www.phpclasses.org/package/5712-PHP-Validate-an-HTML-page-using-the-W3C-validator.html

    $url = $_GET['host'];
    $url = "http://" . $_GET['host'];

    str_replace("www.", "", $url); // strip www. from the url so we can check that the returned URL www

    $errorURL = $url . "/this-is-url-that-do-not-exit-to-test-the-404-page.html";
    $firewallTestURL = $url . "/index.php?%20union";

    // Verify the domain can be resolved

    $dataReturned = getDataFromURL($url);
    $html = $dataReturned['html'];

    if (isset($dataReturned['error'])) {
        //echo "Domain can not be resolved";
        echo $dataReturned['error'];
        fatal();
        exit;
    }


    echo "<h3>Host</h3>";
    echo "<a href='" . $url . "'>" . $url . "</a>";
    //------------------------------------------------ Check Favicon
    echo "<h3>Favicon</h3>";

    $favicon = new favicon($url, 0);
    $fv = $favicon->get_ico_url();
    //echo $favicon->is_ico_exists();

    echo "<img src='" . $fv . "'/>";
    //echo "<img src='". $fv ."' width='32px'/>";
    //echo "<img src='". $fv ."' width='64px'/>";

    //------------------------------------------------ Canonicalization
    echo "<h3>Canonicalization</h3>";

    $parsedURL = parse_url($dataReturned['effectiveURL']);

    echo "Check if the user is redirect to the www. domain";
    //.$dataReturned['effectiveURL'];

    if (preg_match("/www./i", $parsedURL['host'])) {
        pass();
    } else {
        fatal("Users was not redirected");
    }

    //------------------------------------------------ Check Title and metadata

    echo "<h3>Title and Metadata</h3>";
    echo "Looking for the 'Joomla' word or empty tags...";

    // Parse the html into a DOMDocument
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    //print_r ($dom->doctype);

    $xpath = new DOMXPath($dom);
    $nodelist = $xpath->query("//title");


    //------------------------ Doctype
    /*echo "<h4>doctype</h4>";
    $attrs = $xpath->query("//doctype");
    print_r ($attrs);
    */
    //------------------------ Encoding

    echo "<h4>Encoding</h4>";
    $attrs = $xpath->query("//meta");
    $encodingFound = false;


    for ($i = 0; $i < $attrs->length; $i++) {
        $attr = $attrs->item($i);

        // Reference. http://www.w3schools.com/html/html_charset.asp

        // For HTML 4
        $val = $attr->getAttribute('http-equiv');

        if (strcasecmp($val, "content-type") == 0) {
            echo "<p>http-equiv='" . $val . "'</p>";
            echo "<p>content='" . $attr->getAttribute('content') . "'</p>";
            $encodingFound = 'HTML4';
        }

        // For HTML 5
        $val = $attr->getAttribute('charset');

        if (strcasecmp($val, "UTF-8") == 0) {
            echo "<p>charset='" . $val . "'</p>";
            $encodingFound = 'HTML5';
        }
    }
    if ($encodingFound)
        pass($encodingFound . ' encoding found!');
    else
        warning("HTML encoding not found");

    //------------------------ Title

    echo "<h4>Title</h4>";


    if ($nodelist->length == 1) {
        foreach ($nodelist as $n) {
            $val = $n->nodeValue;
            echo "<blockquote>" . $val . "</blockquote>";
            $words = str_word_count($val);
            if ((!findString($val, "joomla") || ($val == "")) && $words > TITLE_WORDS_COUNT)
                pass(str_word_count($val) . " words found!");
            elseif ($words == 0) {
                fatal("Title is empty");
            } else {
                warning("Should have more than " . TITLE_WORDS_COUNT . " words");
            }
        }
    } else {
        fatal($nodelist->length . " title tags exist. Must be only 1");
    }

    $attrs = $xpath->query("//meta");
    $descriptionFound = false;
    $keywordsFound = false;

    //------------------------ Description


    echo "<h4>Description</h4>";
    for ($i = 0; $i < $attrs->length; $i++) {
        $attr = $attrs->item($i);

        if ($attr->getAttribute('name') == 'description') {
            $descriptionFound = true;

            $val = $attr->getAttribute('content');
            echo "<blockquote>" . $val . "</blockquote>";
            //strlen
            $words = str_word_count($val);

            if ((!findString($val, "joomla") || ($val == "")) && $words > DESCRIPTION_WORDS_COUNT)
                pass(str_word_count($val) . " words");
            elseif ($words == 0) {
                fatal("Description is empty");
            } else {
                warning("More than " . DESCRIPTION_WORDS_COUNT . " is recommended");
            }

        }
    }

    if (!$descriptionFound)
        fatal("meta description tag not found!");

    //------------------------ Keywords

    echo "<h4>Keywords</h4>";
    for ($i = 0; $i < $attrs->length; $i++) {
        $attr = $attrs->item($i);

        if ($attr->getAttribute('name') == 'keywords') {
            $keywordsFound = true;

            $val = $attr->getAttribute('content');
            echo "<blockquote>" . $val . "</blockquote>";

            $words = str_word_count($val);
            if ((!findString($val, "joomla") || ($val == "")) && $words > KEYWORD_WORDS_COUNT)
                pass('Total Keywords ' . $words);
            else
                warning("Should have more than " . KEYWORD_WORDS_COUNT . " keywords");

        }
    }


    if (!$keywordsFound)
        fatal("meta keywords tag not found!");
    //------------------------------------------------ Facebook Tags
    echo "<h4>Facebook Tags</h4>";
    for ($i = 0; $i < $attrs->length; $i++) {
        $attr = $attrs->item($i);

        $val = $attr->getAttribute('property');

        if (strcasecmp($val, "og:url") == 0) {
            echo "<p>http-equiv='" . $val . "'</p>";
            echo "<p>content='" . $attr->getAttribute('content') . "'</p>";
            //$encodingFound = 'HTML';
        }
    }

    /*
    <meta property="og:url"                content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="When Great Minds Don?t Think Alike" />
    <meta property="og:description"        content="How much does culture influence creative thinking?" />
    <meta property="og:image"              content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
    */
    //------------------------------------------------ W3C Validation
    if ($validateParam == 'w3c') {
        echo "<h3>W3C Validation</h3>";
        $validate = new W3cValidateApi;

        $a = $validate->validate($url);
        if ($a) {
            pass();
        } else {
            fatal($validate->ValidErrors . " error(s) found");
            echo "<a target='_blank' href='" . $validate->urlLink() . "'>View more details</a>";

        }
    }

    //------------------------------------------------ Check Google Analytics
    echo "<h3>Google Analytics</h3>";
    //echo "<p>Looking for 'UA-' string in the page... </p>";

    if (findString($html, "UA-"))
        pass();
    else
        fatal("UA- string not found");


    //------------------------------------------------ Check Google Webmaster Tools
    echo "<h3>Google Webmaster Tools</h3>";
    //echo "<p>Looking for 'google-site-verification' string in the page... </p>";

    if (findString($html, "google-site-verification"))
        pass();
    else
        fatal("google-site-verification tag not found!");

    //------------------------------------------------ Check SEF
    echo "<h3>SEF</h3>";

    // grab all the a tags on the page
    $attrs = $xpath->query("//a");

    $NotSEFCount = 0;

    if ($attrs->length > 0)
        //echo "Not SEF URL's";
        for ($i = 0; $i < $attrs->length; $i++) {
            $attr = $attrs->item($i);
            $linkURL = $attr->getAttribute('href');
            $parsedURL = parse_url($linkURL);
            //print_r (isset($parsedURL['query']));

            if (isset($parsedURL['query'])) {

                $NotSEFCount++;
                echo "<a href='$linkURL'>$linkURL</a><br />";
            }
        }
    if ($NotSEFCount == 0) {
        pass();
    } else {
        warning($NotSEFCount . " Not SEF link of " . $attrs->length . " detected");
    }


    //------------------------------------------------ PageSpeed & Yslow
    if ($scoreParam == 'pSyS') {
        echo "<h3>PageSpeed & Yslow</h3>";
        pSyS($url); // Check Pagespeed and yslow
    }
    //------------------------------------------------ Firewall

    if ($firewall == 'test') {
        echo "<h3>Firewall</h3>";
        echo "<p>We made and attack! Verify that the site respond accordingly!";
        echo "<div><iframe class='iframe' src='" . $firewallTestURL . "'></iframe></div>";
    }
    //echo INFO;


    //------------------------------------------------ CSS in home
    echo "<h3>CSS style in file</h3>";

    $nodes = $xpath->query("//style");
    $styleFound = false;
    $encodingFound = false;

    echo "<blockquote>";
    for ($i = 0; $i < $attrs->length; $i++) {
        $node = $nodes->item($i);
        echo $node->nodeValue;
        $styleFound = true;
    }
    echo "</blockquote>";

    if ($styleFound)
        warning('Put styles in a external file');
    //------------------------------------------------ Old Browser detection
    echo "<h3>Old Browser detection</h3>";
    echo "<p>Looking for 'BrowserUpdateWarning.js' </p>";

    if (findString($html, "BrowserUpdateWarning.js"))
        pass();
    else
        fatal("BrowserUpdateWarning.js not found!");

    //------------------------------------------------ Check 404
    echo "<h3>404 Page</h3>";
    echo "<p>We are trying to reach the 404 page! Verify that the site respond accordingly!";

    echo "<div><iframe class='iframe' src='" . $errorURL . "'></iframe></div>";
    // Do you have to check visually if the 404 page is what you expect

    //------------------------------------------------ HotLinking
    echo "<h3>Hotlinking</h3>";

    //Trying to get thefirst image of the page
    $attrs = $xpath->query("//img");

    if (!findString($url, getHost())) {

        if ($attrs->length > 0) ;
        {
            $attr = $attrs->item(0);
            $val = $attr->getAttribute('src');
            echo "<img src='" . "$url$val' alt='Hotlinking Detection'  />";
        }
    } else {
        fatal('We can not test hotlinking. The script domain and the test domain are the same');
    }
    //}

    //------------------------------------------------ Done
    echo "<h3>Done!</h3>";
    if ($errorCount > 0)
        fatal($errorCount . " errors found!");

    if ($warningCount > 0)
        warning($warningCount . " warnings found!");

    pass($passCount . " tests success!");

    if ($warningCount == 0 && $errorCount == 0)
        pass("Success! Everything looks OK!");

    ?>

    <?php
    function fatal($text = "This is a fatal error.")
    {

        echo '<div class="alert alert-error">
			<a class="close" data-dismiss="alert">?</a>  
			<strong>Error! </strong>' . $text . '</div>';
        global $errorCount;
        $errorCount++;

    }

    function pass($text = "You have successfully done it.")
    {

        echo '<div class="alert alert-success">
			<a class="close" data-dismiss="alert">?</a>  
			<strong>Success! </strong>' . $text . '</div>';
        global $passCount;
        $passCount++;

    }

    function warning($text = "Best check yorself, you're not looking too good")
    {

        echo "<div class='alert'>
			<a class='close' data-dismiss='alert'>?</a>  
			<strong>Warning! </strong>" . $text . "</div>";
        global $warningCount;
        $warningCount++;
    }

    // thanks gtmetrix.com for the service
    function pSyS($url)
    {

        $test = new Services_WTF_Test(USERNAME_GTM, PASSWORD_GTM);

        $testid = $test->test(array(
            'url' => $url
        ));

        if (!$testid) {
            die("Test ALERTed: " . $test->error() . "\n");
        }

        $test->get_results();

        if ($test->error()) {
            die($test->error());
        }

        $testid = $test->get_testid();
        //echo "<p>Test completed succesfully with ID $testid</p>";
        $results = $test->results();

        $pageSpeed = $results['pagespeed_score'];
        $ySlow = $results['yslow_score'];


        echo "<p>Page Load Time:" . ($results['page_load_time'] / 1000) . " seconds" . "</p>";

        echo "<p>Page Bytes:" . ($results['page_bytes'] / 1024) . " Kb</p>";

        if ($pageSpeed <= PAGESPEEDTRESHOLD)
            fatal("pageSpeed score is " . $pageSpeed . " must be greater than " . PAGESPEEDTRESHOLD);
        else
            pass("pageSpeed score is " . $pageSpeed);


        if ($ySlow <= YSLOWTRESHOLD)
            fatal("ySlow score is " . $ySlow . " must be greater than " . YSLOWTRESHOLD);
        else
            pass("ySlow score is " . $ySlow);

        $reportURL = $results['report_url'];
        echo "<a href='$reportURL'>View more details</a>";


        // If you no longer need a test, you can delete it:
        //echo "Deleting test id $testid\n";
        //$result = $test->delete();
        //if (! $result) { die("error deleting test: " . $test->error()); }
    }

    function findString($text, $cadena) {

        return strpos($text, $cadena);

    }

    function getDataFromURL($url)
    {
        logM("getDtaFromURL");
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        // make the cURL request to $target_url
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix - SSL certificate problem: unable to get local issuer certificate

        $dataReturned;

        $dataReturned['html'] = curl_exec($ch);
        $dataReturned['effectiveURL'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);


        if (!$dataReturned['html']) {
            //echo "<br />cURL error number:" .curl_errno($ch);
            //echo "<br />cURL error:" . curl_error($ch);
            $dataReturned['error'] = curl_error($ch);
        }

        return $dataReturned;
    }

    function logM($message){
        if (true){
            echo "<div class='log'>Log Message:".$message."</div>";
        }
    }
    // http://stackoverflow.com/questions/1459739/php-serverhttp-host-vs-serverserver-name-am-i-understanding-the-ma
    function getHost()
    {
        if ($host = isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $elements = explode(',', $host);
            $host = trim(end($elements));
        } else {
            if (!$host = $_SERVER['HTTP_HOST']) {
                if (!$host = $_SERVER['SERVER_NAME']) {
                    $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
                }
            }
        }
        // Remove port number from host
        $host = preg_replace('/:\d+$/', '', $host);

        return trim($host);

    }

    ?>
</div>
</body>
<html>