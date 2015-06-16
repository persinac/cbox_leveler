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



    <div id="first_row" class="row">
        <h3>Search by:</h3>
        <form id="search_fields">
            <div class="col-lg-4">
                Event Name: <input type="text" name="event_name" id="event_name" value=""/><p></p>
                Host Box: <input type="text" name="host_box" id="host_box" value=""/><p></p>
                Level Range: <span id="level_selectors"></span>
            </div>
            <div class="col-lg-4">
                Month: <span id="span_month_selectors"></span><p></p>
                Year: <span id="span_year_selectors"></span><p></p>
            </div>
            <div class="col-lg-4">
                City: <input type="text" name="city" id="city" value=""/><p></p>
                State: <select name="state_selector" id="state_selector">
                    <option value=""></option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select><p></p>
            </div>
        </form>
    </div>

    <div id="second_row" class="row">
        <div class="col-lg-6">
            <a onclick="init_search()" class="btn btn-primary btn-large" id="search_button" >Search</a><p></p>
        </div>
        <div class="col-lg-6">
            <a onclick="clear_form()" class="btn btn-primary btn-large" id="search_button" >Clear Form</a><p></p>
        </div>
    </div>
    <div class="row">
        <div id="map-canvas"></div>
    </div>
    <div id="third_row" class="row">
        <!-- Will display the events in a list/table  -->
        <table id="list_of_events" class="table table-striped table-hover">
            <thead class="header_bg">
                <tr>
                    <td>Event</td>
                    <td>Host</td>
                    <td>Location</td>
                    <td>Date</td>
                    <td>Level</td>
                    <td>Price</td>
                    <td>Divisions</td>
            </tr>
            </thead>
            <tbody id="tbody_LoE">

            </tbody>
        </table>
    </div>

    <div id="dialog-modal" title="" class="container">
        <div id="workoutcontent" class="workout-content"></div>
        <div id="workout-footer" class="workout-footer"></div>
        <p></p>
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
        initialize_gmaps();
        $("#level_selectors").html(generateLevelDropDowns());
        $("#span_month_selectors").html(generateMonthDropDowns());
        $("#span_year_selectors").html(generateYearDropDowns());
        var $table = $('#third_row');
        $table.floatThead({
            scrollContainer: function($table){
                //console.log("What? "+$table.closest('.wrapper'));
                return $table.closest('#list_of_events');
            }
        });

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

    function getRowWidth() {
        $("#map-canvas").width( $("#second_row").width() )
            .height( 400 );
    }

    function init_search() {
        var myEventArray = new Array();

        var f = new Object();
        f.host_box = $("#host_box").val();
        f.event_name = $("#event_name").val();
        f.state = $("#state_selector").val();
        f.city = $("#city").val();
        f.level_low = $("#low_rng_selector").val();
        f.level_high = $("#high_rng_selector").val();
        f.month = $("#month").val();
        f.year = $("#year").val();

        myEventArray = SearchEvents(list_of_events, f);
        deleteMarkers();
        for(i=0;i < myEventArray.length; i++) {
            AddMarker(myEventArray[i]);
        }
        setAllMap(map);
        LoadEventTable(myEventArray);
    }

    function clear_form() {
        deleteMarkers();
        GetUserLat(0);
        setAllMap(map);

        $("input").each(function(index) {
            $(this).val("");
        });

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