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

function dragstop() {
    //Wird aufgerufen, wenn ein Objekt nicht mehr bewegt werden soll.

    dragobjekt = null;
}


function drag(ereignis) {
    //Wird aufgerufen, wenn die Maus bewegt wird und bewegt bei Bedarf das Objekt.

    posx = document.all ? window.event.clientX : ereignis.pageX;
    posy = document.all ? window.event.clientY : ereignis.pageY;
    if (dragobjekt != null) {
        dragobjekt.style.left = (posx - dragx) + "px";
        dragobjekt.style.top = (posy - dragy) + "px";
        x_box[dragobjekt.id] = (posx - dragx);
        y_box[dragobjekt.id] = (posy - dragy);
        updateLines();
    }
    if(timer!=null)
        updateLines();
}
function dragstart(element) {
    //Wird aufgerufen, wenn ein Objekt bewegt werden soll.

    dragobjekt = element;
    dragx = posx - dragobjekt.offsetLeft;
    dragy = posy - dragobjekt.offsetTop;
}