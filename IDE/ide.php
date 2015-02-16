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

<!DOCTYPE html>
<html>
	<head>
		<title>Qube-IDE</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, height=device-height initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- Optional theme -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">-->
		<!--<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">-->
		<link href="css/bootstrap-dialog.min.css" rel="stylesheet">
	</head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script type="text/javascript" src="Scripte/main_page.js"></script>
	<script type="text/javascript" src="Scripte/lib/draganddrop.js"></script>
	<script type="text/javascript" src="Scripte/lib/ui.js"></script>
	<script type="text/javascript" src="Scripte/save.js"></script>

	<body onload="init()" >
		<?php
		require_once("config.php");
		if(!isset($_POST["email"])||!isset($_POST["password"]))
			exit();
		$email = mysql_real_escape_string($_POST["email"]);
		$password = mysql_real_escape_string(md5($_POST["password"]));

		$db= mysqli_connect ($sql_host,
			$sql_user, $sql_pass, $sql_name)
		or die ("keine Verbindung möglich.
		 Benutzername oder Passwort sind falsch");

		$sollpass = mysqli_fetch_array(mysqli_query($db, 'SELECT pass FROM login WHERE user="'.$email . '"'));

		if($sollpass[0]!=$password)
		{

			echo('<div class="alert alert-danger alert-dismissible" role="alert">');
			echo('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
			echo('Wrong Password or username');
			echo('</div>');

			include("index.php");
			exit();
		}

		echo("<script>const USERNAME='".$email."';</script>")
		?>
		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Qube-IDE</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">File<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li onClick="openFile()"><a href="#">Open</a></li>
								<li onClick="saveFile()"><a href="#">Save</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Input<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li onclick="addSensor('Touch')"><a href="#">Touch</a></li>
								<li onclick="addSensor('Distance')"><a href="#">Distance</a></li>
								<li onclick="addSensor('Brightness')"><a href="#">Brightness</a></li>
								<li onclick="addSensor('Sound')"><a href="#">Sound</a></li>
								<li onclick="addSensor('Humidity')"><a href="#">Humidity</a></li>

							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Output<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li onclick="addOutput('Motor')"><a href="#">Motor</a></li>
								<li onclick="addOutput('LED')"><a href="#">LED</a></li>
								<li onclick="addOutput('Display')"><a href="#">Display</a></li>
								<li onclick="addOutput('Speaker')"><a href="#">Speaker</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logic Gates<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li onclick="addLogic('AND')"><a href="#">AND</a></li>
								<li onclick="addLogic('OR')"><a href="#">OR</a></li>
								<li onclick="addLogic('XOR')"><a href="#">XOR</a></li>
								<li onclick="addLogic('NOT')"><a href="#">NOT</a></li>
							</ul>
						</li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php">Logout</a></li>
								<li><a onclick="$('#dialog_help').modal()">Help</a></li>
								<li class="divider"></li>
								<li><a onclick="$('#dialog_sett').modal()">Settings</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>

		<div class="modal fade" id="dialog_sensor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Trigger</h4>
					</div>
					<div class="modal-body">
						<form id="formaddsen" onsubmit="return false">
							<div class="form-group">
								<label for="size">The Sensor should be:</label>
								<select class="form-control" id="size">
									<option>Larger</option>
									<option>Smaller</option>
									<option>Equals</option>
								</select>
							</div>
							<div class="input-group">
								<input type="number" class="form-control" placeholder="Value" aria-describedby="basic-addon" id="switch_value" min="0" max="100">
								<span class="input-group-addon" id="basic-addon">%</span>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="addedClick()" data-dismiss="modal">Add Trigger</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="dialog_aktor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Action</h4>
					</div>
					<div class="modal-body">
						<form id="formaddakt" onsubmit="return false">
							<label>The Output should be:</label>
							<div class="input-group">
								<input type="number" class="form-control" placeholder="Value" aria-describedby="basic-addon" id="state_value" min="0" max="100">
								<span class="input-group-addon" id="basic-addon">%</span>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="addedClick()" data-dismiss="modal">Add Action</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="dialog_help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" >

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Help</h4>
					</div>
					<div class="modal-body">
						<?php
							include("dialogs/help.htm");
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="dialog_sett" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" >

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Help</h4>
					</div>
					<div class="modal-body">
						<?php
						include("dialogs/settings.php");
						?>
					</div>
				</div>
			</div>
		</div>


		<p id="new_qube"></p>
		<p id="line"></p>
		<p id="status"></p>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script src="js/bootstrap-dialog.min.js"></script>
	</body>
</html>