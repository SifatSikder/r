<!doctype html>
<html lang="en">
<head>

</head>
<body>

<h3> A New Contact Message </h3>
<br><br>

<table>
    <tr>
        <td>Name:</td>
        <td>{{$input['name']}}</td>
    </tr>
    <tr>
        <td>Email:</td>
        <td>{{$input['email']}}</td>
    </tr>
    <tr>
        <td>Message:</td>
        <td>{!! nl2br($input['message']) !!}</td>
    </tr>
</table>

</body>
</html>
