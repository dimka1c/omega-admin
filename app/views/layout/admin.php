<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Необходимые Мета-теги всегда на первом месте -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-param" content="_csrf">
    <meta name="csrf-token" content="<?= $this->token ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <?php
    foreach ($this->scriptStyleSheet as $styles) {
        foreach ($styles as $style) {
            echo $style;
        }
    }
    ?>
</head>
<body>
<div class="container">
    <div class="row">
        <nav class="navbar navbar-light bg-faded" style="background-color: #e3f2fd;">
            <a class="navbar-brand" href="#">Панель Администратора</a>
            <div><?= $user ?></div>
            <a href="/admin/logout">Выход</a>
        </nav>

    </div>

    <?= $content ?>

</div>
<!-- jQuery первый, затем Tether, затем Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
<?php
foreach ($this->scriptsTemplate as $scripts) {
    foreach ($scripts as $script) {
        echo $script;
    }
}
?>
</body>
</html>