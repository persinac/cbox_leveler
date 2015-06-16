/**
 * Created by APersinger on 05/14/15.
 */

function SearchEvents(events, searchObj) {
    var new_list_of_events = new Array();
    var found = false;
    for(i = 0; i < events.length; i++) {
        found = false;
        if(searchObj.host_box.length > 0) {
            var res = searchObj.host_box.split(" ");
            for(a = 0; a < res.length; a++) {
                if(events[i].host_box.toUpperCase().indexOf(res[a].toString().toUpperCase().trim()) > -1) {
                    found = true;
                }
            }
        }

        if(searchObj.state.length > 0) {
            if(events[i].state.toString().trim() == searchObj.state.toString().trim()) {
                found = true;
            }
        }

        if(found == true){
            new_list_of_events.push(events[i])
        }
    }

    return new_list_of_events
}

function LoadEventTable(list) {
    var html = "";

    for(i = 0; i < list.length; i++) {

        html += "<tr>";
        html += '<td><a href="/event_details.php?id='+list[i].id+'">'+list[i].event_name+'</a></td>';
        html += "<td>"+list[i].host_box+"</td>";
        html += "<td>"+list[i].address+"</td>";
        html += "<td>"+list[i].date+"</td>";
        html += "<td>"+list[i].level+"</td>";
        html += "<td>"+list[i].price+"</td>";
        html += '<td>'
        if(i == 2) {
            html += '<img src="images/event_divisions/male_stick_fig.png" class="division_stick_fig_rx">';
            html += '<img src="images/event_divisions/female_stick_fig.png" class="division_stick_fig_rx">';
        } else if(i == 1) {
            html += '<img src="images/event_divisions/male_stick_fig.png" class="division_stick_fig_rx">';
            html += '<img src="images/event_divisions/female_stick_fig.png" class="division_stick_fig_rx">';
            html += '<img src="images/event_divisions/male_stick_fig.png" class="division_stick_fig_sc">';
            html += '<img src="images/event_divisions/female_stick_fig.png" class="division_stick_fig_sc">';
        } else {
            html += '<img src="images/event_divisions/male_stick_fig.png" class="division_stick_fig_rx">';
        }
        html += '</td>';
        html += "</tr>";
    }
    $("#tbody_LoE").html(html);
}