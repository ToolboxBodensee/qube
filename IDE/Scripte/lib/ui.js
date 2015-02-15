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

function updateBoxes() {

    var box_div_text = "";
    var action_text = "";
    for (var counter = 0; counter < x_box.length; counter++) {
        action_text = "";
        if (cate[counter] != "Logik") {
            for (var action_counter = 0; action_counter < actions[counter].length; action_counter++) {
                action_text += '<div onclick="actionMark(this)" id="action_element-' + counter + '-' + action_counter + '" class="action_element well" width="100%">'
                + actions[counter][action_counter] +
                '<button class="btn btn-default" aria-label="Left Align" id="' + counter + '-' + action_counter + 'id' +
                '" onclick="connectedClick(this, event)" style="float: right;">Connect</button>'+
                '</div>';
            }
        }

        box_div_text += '<div class="qube" onmousedown="dragstart(this)" id="' + counter +
        '" style="left:' + x_box[counter] +
        'px; top:' + y_box[counter] +
        'px"><h2 style="display: inline">' + type[counter] + '</h2>\
         <span class="glyphicon glyphicon-remove" aria-hidden="true" style="float: right; width=32px; height:32px" onclick="deleteQube(this)" id="delete'+counter+'"></span>';


        switch (cate[counter]) {
            case "Sensor":
                    box_div_text += action_text + '\
                    <div style="margin: 3px" >\
                    <button class="btn btn-primary btn-block" aria-label="Left Align" type="button" id="' + counter +
                    '" onClick="actionAddClick(this)" >Add Trigger</button>\
                   </div>';
                break;
            case "Aktor":
                box_div_text += action_text + '\
                    <div style="margin: 3px" >\
                    <button class="btn btn-primary btn-block" aria-label="Left Align" type="button" id="' + counter +
                '" onClick="actionAddClick(this)" >Add Action</button>\
               </div>';
                break;
            case "Logik":
                box_div_text += '<div style="margin: 3px" width="100%">' +
                    '<button class="btn btn-primary btn-block" aria-label="Left Align" type="button" id="' + counter +
                    'lo" onclick="connectedClick(this)">Connect</button></div>';
                break;

        }
        box_div_text += '</div>';
    }
    document.getElementById("new_qube").innerHTML = box_div_text;
}

function updateLines(){
    var text = "";
    var scrollTop,scrollLeft, element, rect;
    var elementLeft1, elementTop1;
    var elementLeft2, elementTop2;
    var delta_x, delta_y;
    for(var counter=0; counter<connection1.length; counter++){
        if (connection1[counter] != null) {
            element = document.getElementById(connection1[counter]);
            rect = element.getBoundingClientRect();

            scrollTop = document.documentElement.scrollTop ?
                document.documentElement.scrollTop : document.body.scrollTop;
            scrollLeft = document.documentElement.scrollLeft ?
                document.documentElement.scrollLeft : document.body.scrollLeft;
            elementTop1 = rect.top + scrollTop + 20;
            elementLeft1 = rect.left + scrollLeft;

            if (connection2x[counter] != null) {
                elementLeft2 = connection2x[counter];
                elementTop2 = connection2y[counter];

            }
            else {
                element = document.getElementById(connection2[counter]);
                rect = element.getBoundingClientRect();

                scrollTop = document.documentElement.scrollTop ?
                    document.documentElement.scrollTop : document.body.scrollTop;
                scrollLeft = document.documentElement.scrollLeft ?
                    document.documentElement.scrollLeft : document.body.scrollLeft;
                elementTop2 = rect.top + scrollTop + 15;
                elementLeft2 = rect.left + scrollLeft;
            }



            delta_x = ((elementLeft2-elementLeft1)/2);
            delta_y = (elementTop2-elementTop1);

            text+='<span class="glyphicon glyphicon-remove" aria-hidden="true" style="float: left; width=32px; height:32px; position:absolute;top:'+
            + (elementTop1+delta_y/2-8) + 'px;left:'+
            + (elementLeft1+delta_x-8) + 'px;"' +
            'onclick="deleteConnection(this)" id="conn'+counter+'"></span>';


            var alpha_x, alpha_y;
            if(delta_y<0)
                alpha_y = -90;
            else
                alpha_y = 90;

            if(delta_x<0) {
                alpha_x = 180;
                text+='<span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="float: left; position:absolute;top:'+
                + (elementTop1-8) + 'px;left:'+
                + (elementLeft1+(delta_x/2)-8) + 'px;"></span>';
                text+='<span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="float: left; position:absolute;top:'+
                + (elementTop2-8) + 'px;left:'+
                + (elementLeft2-(delta_x/2)-8) + 'px;"></span>';
            }
            else{
                alpha_x = 0;
                text+='<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="float: left; position:absolute;top:'+
                + (elementTop1-8) + 'px;left:'+
                + (elementLeft1+(delta_x/2)-8) + 'px;"></span>';
                text+='<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="float: left; position:absolute;top:'+
                + (elementTop2-8) + 'px;left:'+
                + (elementLeft2-(delta_x/2)-8) + 'px;"></span>';
            }


            text += "<div id='" + (counter+1) + "' style='height:1px;" +
            "width:"+(Math.abs(delta_x))+"px;background-color:black;position:absolute;top:"
            + (elementTop1) + "px;left:"
            + (elementLeft1) + "px;+" +
            "transform:rotate("
            + alpha_x + "deg);-ms-transform:rotate("
            + alpha_x + "deg);transform-origin:0% 0%;-moz-transform:rotate("
            + alpha_x + "deg);-moz-transform-origin:0% 0%;-webkit-transform:rotate("
            + alpha_x + "deg);-webkit-transform-origin:0% 0%;-o-transform:rotate("
            + alpha_x + "deg);-o-transform-origin:0% 0%;'></div>";

            text += "<div id='" + (counter+1) + "' style='height:1px;" +
            "width:"+Math.abs(delta_y)+"px;background-color:black;position:absolute;top:"
            + (elementTop1) + "px;left:"
            + (elementLeft1+delta_x) + "px;+" +
            "transform:rotate("
            + alpha_y + "deg);-ms-transform:rotate("
            + alpha_y + "deg);transform-origin:0% 0%;-moz-transform:rotate("
            + alpha_y + "deg);-moz-transform-origin:0% 0%;-webkit-transform:rotate("
            + alpha_y + "deg);-webkit-transform-origin:0% 0%;-o-transform:rotate("
            + alpha_y + "deg);-o-transform-origin:0% 0%;'></div>";

            text += "<div id='" + (counter+1) + "' style='height:1px;" +
            "width:"+(Math.abs(delta_x))+"px;background-color:black;position:absolute;top:"
            + (elementTop2) + "px;left:"
            + (elementLeft1+delta_x) + "px;+" +
            "transform:rotate("
            + alpha_x + "deg);-ms-transform:rotate("
            + alpha_x + "deg);transform-origin:0% 0%;-moz-transform:rotate("
            + alpha_x + "deg);-moz-transform-origin:0% 0%;-webkit-transform:rotate("
            + alpha_x + "deg);-webkit-transform-origin:0% 0%;-o-transform:rotate("
            + alpha_x + "deg);-o-transform-origin:0% 0%;'></div>";

        }
    }
    document.getElementById("line").innerHTML = text;
}
