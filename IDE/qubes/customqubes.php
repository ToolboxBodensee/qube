<?php
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

function loadSensor(){
    $file = simplexml_load_file('qubes/qubes.xml');
    foreach ($file->{'sensor'} as $fname) {
        $fname = $fname->attributes();
        $sensor = simplexml_load_file('qubes/sensor/' . $fname);
        $name = $sensor->{'name'};
        echo '<li onclick="addSensor(\''.$name.'\')"><a href="#">'.$name.'</a></li>';
    }
}

function loadOutput(){
    $file = simplexml_load_file('qubes/qubes.xml');
    foreach ($file->{'actor'} as $fname) {
        $fname = $fname->attributes();
        $output = simplexml_load_file('qubes/output/' . $fname);
        $name = $output->{'name'};
        echo '<li onclick="addOutput(\''.$name.'\')"><a href="#">'.$name.'</a></li>';
    }
}

function loadValues(){
    echo
    'var VALUES = [];
    var MIN = [];
    var MAX = [];
    var OPTIONS = [[]];';

    $file = simplexml_load_file('qubes/qubes.xml');
    foreach ($file->{'actor'} as $fname) {
        $fname = $fname->attributes();
        $output = simplexml_load_file('qubes/output/' . $fname);
        $name = $output->{'name'};
        $type = $output->{'values'};
        echo 'VALUES["'.$name.'"]="'.($type->attributes()).'";';
        switch($type->attributes()){
            case 'number':
                    echo 'MIN["'.$name.'"]=parseInt('.$type->{'min'}.');';
                    echo 'MAX["'.$name.'"]=parseInt('.$type->{'max'}.');';
                break;
            case 'text':
                break;
            case 'options':
                echo 'OPTIONS["'.$name.'"] = [];';
                foreach($type->{'option'} as $option){
                    echo 'OPTIONS["'.$name.'"].push("'.$option.'");';
                }
                break;
        }

    }
}