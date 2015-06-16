<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 05/05/15
 * Time: 3:09 PM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CBox Leveler</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="dist/jq_ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link href="dist/css/tabs.css" rel="stylesheet">
    <link href="dist/css/tabs_ext_profile.css" rel="stylesheet">
    <link href="dist/css/profiles.css" rel="stylesheet">
    <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>
<body >

<div class="container">
    <!-- Static navbar  -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/home_page.php">Leveler</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul id="main_nav" class="nav navbar-nav">

                </ul>
            </div>
        </div>
    </div>

    <div id="first_row" class="row">
        <h3 id="greeting"></h3>
    </div>

    <div id="second_row" class="row">
        <div class="col-lg-6">
            <img src="holder.js/300x300" alt="Generic placeholder image" id="profile_pic">
            <input type="file" name="picture" id="picture">
            <br>
            <input type="button" value="upload" onclick="submitNewPicture()">
            <p></p>
        </div>
        <div class="col-lg-6">
            <p>Some level info in this block</p>
            <p>Experience, strength, skill, conditioning, etc...</p>
        </div>
    </div>

    <div id="extra_row_1" class="row">
        <div class="col-lg-6">
            <h3>Challenges</h3>
            <div class="tabs">
                <ul class="tab-links">
                    <li class="active"><a href="#upcoming_challenges">Upcoming</a></li>
                    <li><a href="#completed_challenges">Completed</a></li>
                </ul>

                <div class="tab-content">
                    <div id="upcoming_challenges" class="tab active">
                        <p>6/7/15 Strongman in Ashburn</p>
                        <p>6/27/15 Vektor Games at Crossfit ReVamped</p>
                        </div>

                    <div id="completed_challenges" class="tab">
                        <p>3/30/15 Evolution Competition Series - M/F</p>
                        <p>5/5/15 Highland Gmaes at CFI</p>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h3>Competitions</h3>
            <div class="tabs">
                <ul class="tab-links">
                    <li class="active"><a href="#upcoming_competitions">Upcoming</a></li>
                    <li><a href="#completed_competitions">Completed</a></li>
                </ul>

                <div class="tab-content">
                    <div id="upcoming_competitions" class="tab active">
                        <p>6/7/15 Strongman in Ashburn</p>
                        <p>6/27/15 Vektor Games at Crossfit ReVamped</p>
                    </div>

                    <div id="completed_competitions" class="tab">
                        <p>3/30/15 Evolution Competition Series - M/F</p>
                        <p>5/5/15 Highland Gmaes at CFI</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="third_row" class="row">
        <div class="col-lg-6">
            <p>Some inputs here for updating some favorite's info and maybe a bio</p>
        </div>
    </div>

</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://d3js.org/d3.v3.js" charset="utf-8"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- Required for team details dropdown in match details view -->
<script src="dist/jq_ui/js/jquery-1.10.2.js"></script>
<script src="dist/jq_ui/js/jquery-ui-1.10.4.custom.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/1.2.10/jquery.floatThead.js"></script>
<!--<script src="dist/js/lol_builds.js"></script>-->
<script src="dist/js/challenge_builds.js"></script>
<script src="dist/js/api_interface.js"></script>
<script src="dist/js/graphing_utility.js"></script>
<script src="dist/js/svg-pan-zoom.min.js"></script>
<script src="dist/js/utilities.js"></script>

<script src="holderJS/holder.js"></script>


<script>

    var total = 0;

    $(document).ready(function() {
        $("#main_nav").html(buildMainNavigation());
    });

    $('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        jQuery(currentAttrValue).show().siblings().hide();

        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });

    $("#main_nav").on("click", "li", function() {
        var toParse = $(this).find('a').attr('href');
        $("ul").find("li.active").removeClass("active");
        $(this).addClass('active');
        console.log(toParse);
        /*if(toParse == "#basic") {
         buildBasicStats();
         } else if(toParse == "#adv") {
         alert("Maybe one day...");
         } else if(toParse == "#players") {
         buildPlayers();
         } else if(toParse == "#sbs") {
         buildAPIView();
         } else if(toParse == "#pac") {
         printAllChampions();
         } else if(toParse == "#cpr") {
         printChampionPriority();
         } else if(toParse == "#gar") {
         buildGarrettTestPage();
         } else if(toParse == "#gwp") {
         buildGroupPage();
         } else if(toParse == "#php") {
         phpInfo();
         }*/
    });

    $('#btn_click').on('click', function() { window.location = 'http://www.google.com'; });

    function changeTo400() {
        $("#profile_pic").attr("src", "holder.js/400x400")
    }
    function changeTo300() {
        $("#profile_pic").attr("src", "holder.js/300x300")
    }

</script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    /*TEST SERVER*/
    ga('create', 'UA-50665970-1', 'cboxbeta.com');

    /* LIVE SERVER */
    //ga('create', 'UA-50665970-2', 'compete-box.com');

    ga('send', 'pageview');

</script>

</body>
</html>