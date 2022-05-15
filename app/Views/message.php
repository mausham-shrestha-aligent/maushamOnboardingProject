<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
Home Page
<hr/>
<div>
    <?php if(!empty($userInfo)) : ?>
        Invoice ID: <?= $userInfo['id'] ?> <br />
        Invoice Amount: <?= $userInfo['name'] ?> <br />
        User: <?= $userInfo['email'] ?> <br/>
    <?php endif ?>
</div>
</body>
</html>
