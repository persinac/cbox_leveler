
function generateTimeDropDowns(h,m,s,name) {
    var retVal = '';
    if(h == 1) {
        retVal += '<select name="rft_hr_selector_'+name+'" id="rft_hr_selector_'+name+'">';
        for(var i = 0; i < 60; i++) {
            if(i < 10) {
                retVal += '<option value="0'+i+'">0'+i+'</option>';
            } else {
                retVal += '<option value="'+i+'">'+i+'</option>';
            }
        }
        retVal += '</select> : ';
    }
    if(m == 1) {
        retVal += '<select name="rft_min_selector_'+name+'" id="rft_min_selector_'+name+'">';
        for(var i = 0; i < 60; i++) {
            if(i < 10) {
                retVal += '<option value="0'+i+'">0'+i+'</option>';
            } else {
                retVal += '<option value="'+i+'">'+i+'</option>';
            }
        }
        retVal += '</select> : ';
    }
    if(s == 1) {
        retVal += '<select name="rft_sec_selector_'+name+'" id="rft_sec_selector_'+name+'">';
        for(var i = 0; i < 60; i++) {
            if(i < 10) {
                retVal += '<option value="0'+i+'">0'+i+'</option>';
            } else {
                retVal += '<option value="'+i+'">'+i+'</option>';
            }
        }
        retVal += '</select>';
    }
    return retVal;
}

function generateLevelDropDowns(name) {
    var retVal = '';
    retVal += '<select name="low_rng_selector" id="low_rng_selector">';
    retVal += '<option value="0"> ANY </option>';
    for(var i = 0; i < 100; i++) {
        /*if(i < 10) {
            retVal += '<option value="0'+i+'">0'+i+'</option>';
        } else {
            retVal += '<option value="'+i+'">'+i+'</option>';
        }*/
        retVal += '<option value="'+i+'">'+i+'</option>';
    }
    retVal += '</select> to ';

    retVal += '<select name="high_rng_selector" id="high_rng_selector">';
    retVal += '<option value="0"> ANY </option>';
    for(var i = 0; i < 100; i++) {
        /*if(i < 10) {
            retVal += '<option value="0'+i+'">0'+i+'</option>';
        } else {
            retVal += '<option value="'+i+'">'+i+'</option>';
        }*/
        retVal += '<option value="'+i+'">'+i+'</option>';
    }
    retVal += '</select>';
    return retVal;
}

function generateMonthDropDowns() {
    var retVal = '';
    retVal += '<select name="month_selector" id="month_selector">';
    retVal += '<option value="0"> </option>';
    for(var i = 1; i < 13; i++) {
        retVal += '<option value="'+i+'">'+i+'</option>';
    }
    retVal += '</select>';
    return retVal;
}

function generateYearDropDowns() {
    var retVal = '';
    retVal += '<select name="year_selector" id="year_selector">';
    retVal += '<option value="0"> </option>';
    for(var i = 2000; i < 2020; i++) {
        retVal += '<option value="'+i+'">'+i+'</option>';
    }
    retVal += '</select>';
    return retVal;
}

function buildMainNavigation() {
    var html = '<li id="nav_home" class="active"><a href="/home_page.php">Home</a></li>';
    html += '<li class="dropdown">';
    html += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Social<b class="caret"></b></a>';
    html += '<ul class="dropdown-menu">';
    html += '<li id="nav_profile" ><a href="/profile_page.php">Profile</a></li>';
    html += '<li id="nav_friends" ><a href="/friends.php">Friends</a></li>';
    html += '<li id="nav_groups" ><a href="/groups.php">Groups</a></li>';
    html += '<li id="nav_account" ><a href="/accounts.php">Account</a></li>';
    html += '</ul>';
    html += '</li>';
    html += '<li class="dropdown">';
    html += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<b class="caret"></b></a>';
    html += '<ul class="dropdown-menu">';
    html += '<li id="nav_events" ><a href="/events.php">Competitions</a></li>';
    html += '<li id="nav_chall" ><a href="/challenges.php">Challenges</a></li>';
    html += '</ul>';
    html += '</li>';
    html += '<li id="nav_logout" ><a href="#log">Logout</a></li>';

    return html;
}