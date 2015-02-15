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
    require_once("config.php");
    $email = mysql_real_escape_string($_POST["email"]);
    $password = mysql_real_escape_string(md5($_POST["password"]));
    $password2 = mysql_real_escape_string(md5($_POST["password2"]));
    $code = mysql_real_escape_string($_POST["code"]);

    //Check Passwort####################################
    $db= mysqli_connect ($sql_host,
        $sql_user, $sql_pass, $sql_name)
    or die ("keine Verbindung möglich.
         Benutzername oder Passwort sind falsch");

    $codedb = mysqli_query($db, 'SELECT Code FROM code WHERE Code="'.$code .'"');
    $maildb = mysqli_query($db, 'SELECT user FROM login WHERE user="'.$email.'"');

    if($password != $password2)
        die("Passwords aren't identical!");
    else if(mysqli_num_rows($codedb) == 0)
        die("Wrong code");
    else if(mysqli_num_rows($maildb)>0)
        die("Email already in use!");
    else{

        mysqli_query($db, 'DELETE FROM code WHERE code="'.$code.'"');
        mysqli_query($db, 'INSERT INTO login VALUES ("'.$email.'","'.$password.'")');


        include("index.php");
    }

?>