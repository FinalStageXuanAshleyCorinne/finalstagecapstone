<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Form to fetch database">
    <title>Using TheMovieDB</title>
    <meta name="author" content="Xuan Do">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="xuando_css/stylesheet.css" type="text/css" />
</head>
<body>
    <h1>Welcome</h1>
    <h2>How do you feel today?</h2>
    <form action="fetch_from_db.php" method="POST" enctype="multipart/form-data" id="form_id">
        <input type="radio" name="mood" value="happy" id="happy"> Happy<br>
        <input type="radio" name="mood" value="sad" id="sad"> Sad<br>
        <input type="radio" name="mood" value="anger" id="anger"> Anger<br>
        <input type="radio" name="mood" value="calm" id="calm"> Calm<br>
        <input type="radio" name="mood" value="romantic" id="romantic"> Romantic<br>
        <input type="radio" name="mood" value="playful" id="playful"> Playful<br>
        <input type="radio" name="mood" value="confident" id="confident"> Confident<br>
        <input type="radio" name="mood" value="focus" id="focus"> Focus<br>
        <input type="submit">
    </form>
</body>
</html>
