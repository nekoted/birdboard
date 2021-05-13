<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a project</title>
</head>

<body>
    <form action="/projects" method="post">
        @csrf
        <input type="text" name="title">
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <button type="submit">Create !</button>
    </form>
</body>

</html>
