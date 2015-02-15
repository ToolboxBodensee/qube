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
$p_x_box = $_POST["x_box"];
$p_y_box = $_POST["y_box"];
$p_type = $_POST["type"];
$p_cate = $_POST["cate"];
$p_connection1 = $_POST["connection1"];
$p_connection2 = $_POST["connection2"];
$p_actions = $_POST["actions"];
$user = $_POST["user"];


$root = simplexml_load_string('<qube></qube>');


$index=0;
$xBox = $root->addChild("X-Value");
$xBox->addAttribute("length",$_POST["x_boxl"]);
foreach(explode("|",$p_x_box, -1) as $value){
    $xBox->addChild("X".$index, $value);
    $index++;
}

$index=0;
$yBox = $root->addChild("Y-Value");
$yBox->addAttribute("length",$_POST["y_boxl"]);
foreach(explode("|",$p_y_box, -1) as $value){
    $yBox->addChild("Y".$index, $value);
    $index++;
}

$index=0;
$Type = $root->addChild("Type");
$Type->addAttribute("length",$_POST["typel"]);
foreach(explode("|",$p_type, -1) as $value){
    $Type->addChild("Type".$index, $value);
    $index++;
}

$index=0;
$Cate = $root->addChild("Cate");
$Cate->addAttribute("length",$_POST["catel"]);
foreach(explode("|",$p_cate, -1) as $value){
    $Cate->addChild("Cate".$index, $value);
    $index++;
}

$Conn = $root->addChild("Connections");

$index=0;
$Conn1 = $Conn->addChild("Conn1");
$Conn1->addAttribute("length",$_POST["connection1l"]);
foreach(explode("|",$p_connection1, -1) as $value){
    $Conn1->addChild("Conn1T".$index, $value);
    $index++;
}


$index=0;
$Conn2 = $Conn->addChild("Conn2");
$Conn2->addAttribute("length",$_POST["connection2l"]);
foreach(explode("|",$p_connection2, -1) as $value){
    $Conn2->addChild("Conn2T".$index, $value);
    $index++;
}

$index=array(0,0);
$Action = $root->addChild("Action");
$Action->addAttribute("length",$_POST["actionsl"]);
foreach(explode(";",$p_actions, -2) as $value){

    $inneraction = $Action->addChild("Action".$index[0]);
    $inneraction->addAttribute("length", sizeof(explode("|",$value, -1)));
    foreach(explode("|",$value, -1) as $innervalue){
        $inneraction->addChild("Action".$index[0]."-".$index[1], $innervalue);
        $index[1]++;
    }

    $index[0]++;
    $index[1]=0;
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($root->asXML());
$dom->save('test.xml');
