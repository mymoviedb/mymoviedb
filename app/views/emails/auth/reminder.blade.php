<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset Notification</h2>

		<div>
		{{ $firstname }} {{ $lastname }},
		<br><br>

		<!-- To reset your password, complete this form -->
		You have requested to reset the login password for your {{ $username }} MyMovieDB account.
		You will need to click the following URL to activate your new password before attempting to log in 
		using it for the first time.
		<br><br>

		If you did not request that your password be reset, please ignore this email message and your password
		will retain its previous value.
		<br><br>

		Your new temporary login password is: <br>
		<b>{{ $password }}</b>
		<br><br>

		Activate the new password by clicking the following link<br><br>
		{{ $link }}

		<br><br>

		Thanks, 
		<br>
		MyMovieDB Support Team

		</div>
	</body>
</html>
