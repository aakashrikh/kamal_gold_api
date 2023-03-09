<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Login Alert</title>
</head>
<body>
Hello,
<br>
Your security is very important to us. This email address was used to access the Weazy Dine dashboard from a new IP address:
<br><br>
------------------------------------------<br>
Contact No: {{ $contact_no }}<br/>
Account Role: {{ $account_role }}<br/>
Time: {{ $time }}<br/>
IP address: {{ $ip_address}}<br/>
Agent:  {{ $browser }}<br/>
------------------------------------------
<br/><br/>

If you have any questions or concerns, you can also visit our Support portal at https://pos.myweazy.com/dashboard.
<br/><br/>
Thanks,
<br/>
The Weazy Dine Team
</body>
</html>
