<?php
include '../views/header.php';
?>
<div><a href="?">Начало</a> <a href="?p=register">Регистрация</a> </div>

<form action="?p=login" method="POST">
    <p><label for="email">Поща</label> <input type="text" name="email" id="email" /></p>
    <p><label for="pass">Парола</label> <input type="password" name="pass" id="pass" /> </p>    
    <?php
    if ($errors) {
        echo '<p>Невалидни данни</p>';
        //var_dump($errors);
    }
    ?>
    <p class="submit"><input type="submit" value="Вход" /></p>
</form> 

<?php
include '../views/footer.php';


