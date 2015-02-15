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
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- Optional theme -->
		<!--<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">-->
		<link href="css/signin.css" rel="stylesheet">
	</head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<body>
		<div class="container">
			<form class="form-signin" action="ide.php" method="post">
				<h2 class="form-signin-heading">Please sign in</h2>
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="remember-me" id="check" checked="true"> Remember me
					</label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" onclick="cookieTest()">Sign in</button>
				<button class="btn btn-lg btn-default btn-block" type="button" data-toggle="modal" data-target="#modalregist">Register</button>
			</form>
		</div>


		<div class="modal fade" id="modalregist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="dialogs/register.php" method="post">
						<div class="modal-body">
							<h2 class="form-signin-heading">Register</h2>
							<label for="inputEmail" class="sr-only">Email address</label>
							<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
							<label for="inputPassword" class="sr-only">Password</label>
							<input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
							<label for="inputPassword" class="sr-only">Password (again)</label>
							<input type="password" id="inputPassword2" class="form-control" placeholder="Password (again)" required name="password2">
							<label for="inputPassword" class="sr-only">Qube-Code</label>
							<input type="text" id="inputcode" class="form-control" placeholder="Qube-Code" required name="code">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="Scripte/lib/cookie.js"></script>
		<script>
			if(getCookie("pass_login")!=null && getCookie("mail_login")!=null){
				document.getElementById("inputPassword").value = getCookie("pass_login");
				document.getElementById("inputEmail").value = getCookie("mail_login");
			}


			function cookieTest(){
				if(document.getElementById("check").checked){
					setCookie(document.getElementById("inputPassword").value,"pass_login");
					setCookie(document.getElementById("inputEmail").value,"mail_login");
				}
				else{
					deleteCookie("pass_login");
					deleteCookie("mail_login")
				}
			}
		</script>
	</body>
</html>