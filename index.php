<?php
header('Content-Type: text/html; charset=utf-8');
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Löydä lähin lintutorni</title>
        <meta name="description" content="Sovellus joka näyttää lähimmät lintutornit.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/app.css">


        <!--[if lt IE 9]>
            <script src="js/vendor/html5-3.6-respond-1.4.2.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div id="header-container">
            <header class="wrapper clearfix">
                <h2 class="title">
                    <a href="./" id="titlelink">
                        <img src="images/trineb.svg.php" id="logo" alt="">
                        Löydä lähin lintutorni
                    </a>
                    <a id="helplink" href="#" title="Apua ja taustatietoa">?</a>
                </h2>
            </header>
        </div>


        <div id="help-container">
            <p>Tämä sovellus hakee sijaintisi puhelimen GPS:lla tai tietokoneesi IP-osoitteen perusteella ja näyttää lähimpien lintutornien sijainnin. Sijainnin tarkkuus riippuu mm. puhelimesi ominaisuuksista ja asetuksista.
            </p>

        </div>

        <div id="error-container"></div>
        <div id="message-container"></div>

        <div id="main-container">

            <a href="http://www.birdlife.fi/" class="birdlifelink topright"><img src="images/birdlife-suomi.svg.php" alt=""></a>
            <h1>Lähimmät lintutornit</h1>

            <ol id="towers">
                
            </ol>

            <a href="http://www.birdlife.fi/" class="birdlifelink bottom"><img src="images/birdlife-suomi.svg.php" alt=""></a>

        </div> <!-- #main-container -->

        <div id="share-container">
            <div class="fb-share-button" data-href="http://www.biomi.org/retkelle/" data-layout="button_count"></div>
            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="fi" data-dnt="true">Twiittaa</a>
            <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            </script>

            <p id="seealso"><a href="/kotiseudun-linnut/">Katso myös mitä lintuja tällä alueella pesii</a></p>
            <p id="feedback"><a href='http://goo.gl/forms/Xgh1Lpf1u5TjwEXD2'>Palaute</a></p>

        </div>

        <div id="footer-container">
            <footer class="wrapper">

                <h3>Tietolähteet</h3>
                <p>Tornien tiedot &copy; <a href="http://www.birdlife.fi/">BirdLife Suomi</a>, kaikki oikeudet pidätetään.</p>

                <h3>Tietosuoja</h3>
                <p>Palvelu tallettaa käyttäjän sijainnin ja selaimen ominaisuuksia, mutta ei henkilötietoja. Palvelun käyttöä seurataan <a href="https://www.google.com/policies/privacy/partners/">Google Analytics:in</a> ja evästeiden avulla. Voit halutessasi estää evästeiden käytön selaimestasi.</p>

                <p id="credits">Toteutus: <strong>Mikko Heikkinen / <a href="http://www.biomi.org/">biomi.org</a></strong> | <a href="https://github.com/mikkohei13/retkikohteet">Code on Github</a> | <a href="tietosuojaseloste/">Tietosuojaseloste</a></p>

            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script>
            var logData = { };
            <?php
                echo "logData.datetime = " . date("YmdHis") . ";\n";
                echo "logData.ip = \"" . sha1($_SERVER['REMOTE_ADDR']) . "\";\n";

                // Automatic base url, https://gist.github.com/mikkohei13/9312936
                $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                $base_url .= "://".$_SERVER['HTTP_HOST'];
                $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

                echo "var rootUrl = \"" . $base_url . "\";\n" // http://192.168.56.10/suomen-linnut/

            ?>
        </script>
        <script src="js/main.js"></script>

        <div id="fb-root"></div>

        <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>

        <?php
        if (! @$_GET['nolog'])
        {
            include_once "../../googleanalytics.php";
        }
        ?>

    </body>
</html>
