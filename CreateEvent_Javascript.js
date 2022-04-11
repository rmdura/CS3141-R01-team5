

function get_text(event)
{
    var string = event.textContent;

    document.getElementsByName('newEventTag')[0].value = string;

    document.getElementById('search_result').innerHTML = '';
}

function load_data(query)
{
    if(query.length > 2)
    {
        var form_data = new FormData();

        form_data.append('query', query);

        var ajax_request = new XMLHttpRequest();

        ajax_request.open('POST', 'process_data.php');

        ajax_request.send(form_data);

        ajax_request.onreadystatechange = function()
        {
            if(ajax_request.readyState == 4 && ajax_request.status == 200)
            {
                var response = JSON.parse(ajax_request.responseText);

                var html = '<div class="list-group">';

                if(response.length > 0)
                {
                    for(var count = 0; count < response.length; count++)
                    {
                        html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].name+'</a>';
                    }
                }
                else
                {
                    html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
                }

                html += '</div>';

                document.getElementById('search_result').innerHTML = html;
            }
        }
    }
    else
    {
        document.getElementById('search_result').innerHTML = '';
    }
}

var tag_array = new Array();

function AddInterest() {
    tag_array.push(document.getElementById("newEventTag").value)

    PopulateList(tag_array);
}

function PopulateList(arr) {
    LLen = arr.length;

    
    text = "<ol>";
    for (i = 0; i < LLen; i++) {
        text += "<li>" + arr[i] + "<input type='button' onclick='Delitem(" + i + ")' value='Delete' /></li>";

    }
    text += "</ol>";

    document.getElementById("InterestList").innerHTML = text;

    text = arr[0];
    for (i = 1; i < LLen; i++) {
        text += "," + arr[i];
    }

    oFormObject = document.forms['CreateEventForm'];
    oFormObject.elements["str"].value = text;
}

function Delitem(index) {
    tag_array.splice(index, 1);
    PopulateList(tag_array);
}