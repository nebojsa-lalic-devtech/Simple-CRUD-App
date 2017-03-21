<html>
<head>
    <title>Employee</title>
</head>
<body>
<p>------------------------------------------------------------</p>
<h1>***** Employee *****</h1>
<p>------------------------------------------------------------</p>
<div>
    {*<ul>*}
        {*<li>{$userDetails}</li>*}
        {*<br>*}
        {*<li>{$user2Details}</li>*}
        {*<br>*}
        {*<li>{$user3Details}</li>*}
    {*</ul>*}
    <ul>
        {foreach from=$employeeArray key=key item=i}
            <li><p><b>Name: </b>{$i.first_name} {$i.last_name}</p></li>
            <li><p><b>Email: </b>{$i.email}</p></li>
            <li><p><b>Job: </b>{$i.job}</p></li><br>
        {/foreach}
    </ul>
</div>
<p>------------------------------------------------------------</p>
</body>
</html>