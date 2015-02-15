<!--
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
-->
<?php
$var = $_POST["var"];
//$user = $_POST["user"];

$root = simplexml_load_file('test.xml');

$conn = $root->{'Connections'};

switch($var){
    case 1:
        $length = $root->{'X-Value'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $root->{'X-Value'}->{'X'.$counter}."|";
        }
        break;
    case 2:
        $length = $root->{'Y-Value'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $root->{'Y-Value'}->{'Y'.$counter}."|";
        }
        break;
    case 3:
        $length = $root->{'Type'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $root->{'Type'}->{'Type'.$counter}."|";
        }
        break;
    case 4:
        $length = $root->{'Cate'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $root->{'Cate'}->{'Cate'.$counter}."|";
        }
        break;
    case 5:
        $length = $conn->{'Conn1'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $conn->{'Conn1'}->{'Conn1T'.$counter}."|";
        }
        break;
    case 6:
        $length = $conn->{'Conn2'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            echo $conn->{'Conn2'}->{'Conn2T'.$counter}."|";
        }
        break;
    case 7:
        $length = $root->{'Action'}->attributes();
        for($counter=0; $counter<$length; $counter++){
            if($root->{'Action'}->{'Action'.$counter}) {
                $innerlenght = $root->{'Action'}->{'Action'.$counter}->attributes();
                for ($innercounter = 0; $innercounter < $innerlenght; $innercounter++) {
                    echo $root->{'Action'}->{'Action' . $counter}->{'Action' . $counter . "-" . $innercounter}."|";
                }
                echo ";";
            }
        }
        break;
}