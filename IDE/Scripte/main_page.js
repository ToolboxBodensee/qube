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

var dragobjekt = null;

// Position, an der das Objekt angeklickt wurde.
var dragx = 0;
var dragy = 0;

// Mausposition
var posx = 0;
var posy = 0;



var x_box = [];
var y_box = [];
var type = [];
var cate = [];
var actions = [[]];

var connection2x = [];
var connection2y = [];

var connection1 = [];
var connection2 = [];

var add_box;

var timer = null;
var clicked = false;
var targetID;

var lastKey = 0;

var fileName = "";

function getParentID(id){
    return document.getElementById(id).parentElement.id;
}

function init() {
    document.onmousemove = drag;
    document.onmouseup = dragstop;
    document.onkeydown = getKeyCode;
}


function actionAddClick(ereignis) {
    add_box = ereignis.id;
    switch(cate[ereignis.id]){
        case "Sensor":
            $('#dialog_sensor').modal();
            break;
        case "Aktor":
            $('#dialog_aktor').modal();
            break;
    }
}

function deleteQube(event){
    var parentid = getParentID(event.id);
    x_box.splice(parentid, 1);
    y_box.splice(parentid, 1);
    type.splice(parentid, 1);
    cate.splice(parentid, 1);
    actions.splice(parentid, 1);
    for(var counter=0; counter<connection1.length; counter++){
        if(parentid==getParentID(getParentID(connection1[counter]))){
            connection1.splice(counter,1);
            connection2.splice(counter,1);
        }
        else if(parentid==getParentID(getParentID(connection2[counter]))){
            connection1.splice(counter,1);
            connection2.splice(counter,1);
        }
    }
    updateBoxes();
    updateLines();
}

function deleteConnection(element){
    var element_id = element.id;
    element_id = element_id.slice(4);
    connection1.splice(element_id,1);
    connection2.splice(element_id,1);
    updateLines();
}

function addedClick(){
    switch(cate[add_box]){
        case "Sensor":
            var size = document.getElementById("size");
            actions[add_box].push(size.options[size.selectedIndex].value + ' ' + document.getElementById("switch_value").value);
            document.getElementById("formaddsen").reset();
            break;
        case "Aktor":
            actions[add_box].push(document.getElementById("state_value").value);
            document.getElementById("formaddakt").reset();
            break;
    }
    updateBoxes();
}

function addSensor(select) {
    x_box.push((type.length + 1) * 20 + 80);
    y_box.push((type.length + 1) * 20 + 80);
    type.push(select);
    cate.push("Sensor");
    actions.push([]);
    updateBoxes();
}

function addOutput(select){
    x_box.push((type.length + 1) * 20 + 80);
    y_box.push((type.length + 1) * 20 + 80);
    type.push(select);
    cate.push("Aktor");
    actions.push([]);
    updateBoxes();
}

function addLogic(select){
    x_box.push((type.length + 1) * 20 + 80);
    y_box.push((type.length + 1) * 20 + 80);
    type.push(select);
    cate.push("Logik");
    actions.push([]);
    updateBoxes();
}

function actionMark(element){
    BootstrapDialog.show({
        title: "Delete action",
        message: "Do you want to delete this action?",
        buttons: [
            {
                label: 'Delete',
                action: function(dialogItself){
                    dialogItself.close();
                    var element_id = element.id;
                    var pos,id;
                    var counter, action_counter;
                    pos = element_id.search("-");
                    id = element_id.slice(pos+1);
                    pos = id.search("-");
                    counter = id.slice(0, pos);
                    action_counter = id.slice(pos+1);
                    actions[counter].splice(action_counter,1);
                    for(var counter_conn=0; counter_conn<connection1.length; counter_conn++){
                        if(element_id==getParentID(connection1[counter_conn])){
                            connection1.splice(counter_conn,1);
                            connection2.splice(counter_conn,1);
                        }
                        else if(element_id==getParentID(connection2[counter_conn])){
                            connection1.splice(counter_conn,1);
                            connection2.splice(counter_conn,1);
                        }
                    }
                    updateBoxes();
                    updateLines();
                }
            },
            {
                label: 'Cancel',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }
        ]
    });

}

function connectedClick(ereignis, e) {
    if (!e) e = window.event;
    e.stopPropagation();

    if(timer!=null){
        targetID = ereignis.id;
        clicked = true;
    }
    else{
        var btn_id = ereignis.id;
        lastKey = 0;
        clicked = false;


        connection1.push(0);
        connection2.push(0);
        connection2x.push(0);
        connection2y.push(0);

        timer = window.setInterval(function () {
            connectionTimer(btn_id)
        }, 50);
    }
}

function connectionTimer(btn_id) {
    if (lastKey == 27) {
        window.clearInterval(timer);
        timer = null;

        connection1[connection1.length-1] = null;
        connection2x[connection2x.length-1] = null;
        connection2y[connection2y.length-1] = null;

    }
    else if(clicked){
        window.clearInterval(timer);
        timer = null;
        var pos1,pos2,id1,id2;
        pos1 = btn_id.search("-");
        id1 = btn_id.slice(0,pos1);
        pos2 = targetID.search("-");
        id2 = targetID.slice(0,pos2);
        if(cate[id1]!=cate[id2]) {
            connection2[connection2.length - 1] = targetID;
            connection2x[connection2x.length - 1] = null;
            connection2y[connection2y.length - 1] = null;
        }
        else{
            connection1[connection1.length-1] = null;
            connection2x[connection2x.length-1] = null;
            connection2y[connection2y.length-1] = null;
            BootstrapDialog.show({
                title: "That doesn't work!",
                message: "You can't connect to Qubes of the same type\nalways try to connect an input to an output.",
                    buttons: [
                       {
                        label: 'Ok',
                        action: function(dialogItself){
                            updateBoxes();
                            lastKey = 0;
                            dialogItself.close();
                        }
                       }
                    ]
            });
        }
    }
    else {
        connection1[connection1.length-1] = btn_id;
        connection2x[connection2x.length-1] = posx;
        connection2y[connection2y.length-1] = posy;

    }
    updateLines();
}

function getKeyCode(event) {
    lastKey = event.keyCode;
}
