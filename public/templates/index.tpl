<html>
<head>
    <title>Employee</title>
</head>
<body>
<p>------------------------------------------------------------</p>
<h1>***** Create Employee *****</h1>
<p>------------------------------------------------------------</p>
<form action="" method="post" name="form">
    <table width="25%" border="0">
        <tr>
            <td><b>FirstName</b></td>
            <td><input type="text" name="first_name"></td>
        </tr>
        <tr>
            <td><b>LastName</b></td>
            <td><input type="text" name="last_name"></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><input type="text" name="email"></td>
        </tr>
        <tr>
            <td><b>Job</b></td>
            <td><input type="text" name="job"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="Submit" value="Create Employee"></td>
        </tr>
    </table>
</form>
<p>------------------------------------------------------------</p>
<h1>***** List - All Employees *****</h1>
<p>------------------------------------------------------------</p>
<div>
    <ul>
        {foreach from=$employeeArray key=key item=i}
            <li><p><b>Id: </b>{$i.id}</p></li>
            <li><p><b>Name: </b>{$i.first_name} {$i.last_name}</p></li>
            <li><p><b>Email: </b>{$i.email}</p></li>
            <li><p><b>Job: </b>{$i.job}</p></li><br>
        {/foreach}
    </ul>
</div>
<p>------------------------------------------------------------</p>
</body>
</html>