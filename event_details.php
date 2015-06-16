<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 05/19/15
 * Time: 10:53 AM
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
    <link href="dist/css/group_ext.css" rel="stylesheet">
    <link href="dist/css/league_custom.css" rel="stylesheet">
    <link href="dist/css/graph_NetworkOfSummoners.css" rel="stylesheet">
    <link href="dist/css/events_page.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
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

    <div id="title_row" class="row">
        <h2 id="event_name">Test Event</h2>
    </div>
    <div id="first_row" class="row">
        <div id="main_details_1" class="col-lg-6">
            <h4 id="event_host">Host: Crossfit 301 Elite</h4>
            <h4 id="event_location">Where? 309 Northern Ave, Hagerstown MD, 21742</h4>
            <h4 id="event_date">When? 5/23/15 <span id="event_time">9:00-3:00</span></h4>
            <h4 id="event_price">Price: $75.00</h4>
            <h4 id="event_contact">Tim Kellinger <a href="mailto:admin@cboxbeta.com">admin@cboxbeta.com</a></h4>
        </div>
        <div id="main_details_2" class="col-lg-6">
            <h4 id="event_level_range">Level Range: <p>RX: 40-60</p><p>Scaled: 25-40</p></h4>
        </div>
    </div>

    <div id="second_row" class="row">
        <div id="accordion_divisions">
            <h3>RX 8/10 Spots Left!</h3>
            <div id="rx_standards">
                <p>Some standards here</p>
                <p>Some standards and here</p>
                <p>Some standards there</p>
                <p><a onclick="" class="btn btn-primary btn-large" id="register_button" >Register</a></p>
            </div>
            <h3>Scaled 5/10 Spots Left!</h3>
            <div id="sc_standards">
                <p>Some standards here</p>
                <p>Some standards and here</p>
                <p>Some standards there</p>
                <p><a onclick="" class="btn btn-primary btn-large" id="register_button" >Register</a></p>
            </div>
        </div>
    </div>

    <div id="third_row" class="row">

    </div>

    <div id="dialog-modal" title="" class="container">
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://d3js.org/d3.v3.js" charset="utf-8"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="dist/jq_ui/js/jquery-1.10.2.js"></script>
<script src="dist/jq_ui/js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/1.2.10/jquery.floatThead.js"></script>
<script src="dist/js/challenge_builds.js"></script>
<script src="dist/js/api_interface.js"></script>
<script src="dist/js/graphing_utility.js"></script>
<script src="dist/js/svg-pan-zoom.min.js"></script>
<script src="dist/js/utilities.js"></script>
<script src="dist/js/google_maps.js"></script>
<script src="dist/js/event_utilities.js"></script>

<script src="holderJS/holder.js"></script>


<script>

    var total = 0;

    $(document).ready(function() {
        $("#main_nav").html(buildMainNavigation());
        getRowWidth();
        $("#accordion_divisions").accordion();
    });

    $("#main_nav").on("click", "li", function() {
        var toParse = $(this).find('a').attr('href');
        $("ul").find("li.active").removeClass("active");
        $(this).addClass('active');
        console.log(toParse);
    });

    function getRowWidth() {
        $("#map-canvas").width( $("#second_row").width() )
            .height( 400 );
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