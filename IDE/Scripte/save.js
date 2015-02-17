/*
    Qube-IDE
Copyright (C) 2015 Paul Nykiel

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function newFile(){
    x_box = [];
    y_box = [];
    type = [];
    cate = [];
    actions = new Array([]);

    connection2x = [];
    connection2y = [];

    connection1 = [];
    connection2 = [];

    updateBoxes();
    updateLines();
}


function saveFile(){
// Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
// Create some variables we need to send to our PHP file
    var url = "save/savefile.php";

    var _x_box = "";
    var _y_box = "";
    var _type = "";
    var _cate = "";
    var _connection1 = "";
    var _connection2 = "";
    var _actions = "";
    for(var counter=0; counter<x_box.length; counter++)
        _x_box+=x_box[counter]+"|";
    for(counter=0; counter<y_box.length; counter++)
        _y_box+=y_box[counter]+"|";
    for(counter=0; counter<type.length; counter++)
        _type+=type[counter]+"|";
    for(counter=0; counter<cate.length; counter++)
        _cate+=cate[counter]+"|";
    for(counter=0; counter<connection1.length; counter++)
        _connection1+=connection1[counter]+"|";
    for(counter=0; counter<connection2.length; counter++)
        _connection2+=connection2[counter]+"|";
    for(counter=0; counter<actions.length; counter++){
        for(var counter2=0; counter2<actions[counter].length; counter2++)
            _actions+=actions[counter][counter2]+"|";
        _actions+=";";
    }
    _actions = _actions.replace(/Larger /g, "L");
    _actions = _actions.replace(/Smaller /g, "S");
    _actions = _actions.replace(/Equals /g, "E");

    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            console.log(return_data);
            /*if(return_data!="")
            {
                BootstrapDialog.show({
                    title: "Error while saving!",
                    message: return_data,
                    buttons: [
                        {
                            label: 'Ok',
                            action: function(dialogItself){
                                dialogItself.close();
                            }
                        }
                    ]
                });
            }*/
        }
    };
// Send the data to PHP now... and wait for response to update the status div
    hr.send("x_box="+_x_box+
        "&y_box="+_y_box+
        "&type="+_type+
        "&cate="+_cate+
        "&connection1="+_connection1+
        "&connection2="+_connection2+
        "&actions="+_actions+
        "&x_boxl="+x_box.length+
        "&y_boxl="+y_box.length+
        "&typel="+type.length+
        "&catel="+cate.length+
        "&connection1l="+connection1.length+
        "&connection2l="+connection2.length+
        "&actionsl="+actions.length+
        "&user="+USERNAME
    ); // Actually execute the request
}

function postCallback(response, caller){
    if (response != "") {
        switch (caller) {
            case 1:
                x_box = response.split("|");
                x_box.pop();
                for (var counter = 0; counter < x_box.length; counter++)
                    x_box[counter] = parseInt(x_box[counter]);
                break;
            case 2:
                y_box = response.split("|");
                y_box.pop();
                for (counter = 0; counter < y_box.length; counter++)
                    y_box[counter] = parseInt(y_box[counter]);
                break;
            case 3:
                type = response.split("|");
                type.pop();
                break;
            case 4:
                cate = response.split("|");
                cate.pop();
                break;
            case 5:
                connection1 = response.split("|");
                connection1.pop();
                break;
            case 6:
                connection2 = response.split("|");
                connection2.pop();
                break;
            case 7:
                response = response.replace(/L/g, "Larger ");
                response = response.replace(/S/g, "Smaller ");
                response = response.replace(/E/g, "Equals ");
                actions = response.split(";");
                actions.pop();
                for(counter=0; counter<actions.length; counter++) {
                    actions[counter] = actions[counter].split("|");
                    actions[counter].pop();
                }
                break;
        }
    }
    else{
        updateBoxes();
        updateLines();
    }
}

function readFile(caller){
    var hr = new XMLHttpRequest();
    var url = "save/openfile.php";

    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function(){
        if(hr.readyState == 4 && hr.status == 200) {
            postCallback(hr.responseText, caller);
        }
    };
    hr.send("var="+caller);

}

function openFile(){
    for(var counter=1; counter<=8; counter++){
        readFile(counter);
    }

}
