<html>

	<head>
	</head>
	<body>
		<center>
		<form method="post" action="update_data" enctype="multipart/form-data">
			<label>Please Enter Contact No</label>
			<br><br>
			<input type="number" name="contact" required>
<br><br>
			<label>Please Enter your Auth Key</label>
			<br><br>
			<input type="text" name="auth_key" required>
<br><br>
			
			<input type="file" name="csv" required>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button type="submit">Submit now</button>
		</form>
		</center>
	</body>
</html>