<?php
include '../views/header.php';
?>
<div><a href="?">Начало</a> <a href="?p=login">Вход</a> </div>
<form action="?p=register" method="POST">
    <p><label for="email">Поща</label> <input type="text" name="email" id="email" />
        <?php
        if ($errors['email']) {
            echo 'Невалидна поща';
        }
        if ($errors['email_taken']) {
            echo 'Пощата е заета!';
        }
        ?>
    </p>
    <p><label for="pass">Парола</label> <input type="password" name="pass" id="pass" />
        <?php
        if ($errors['password_length']) {
            echo 'Паролата трябва да е минимум 5 символа';
        }
        ?>
    </p>
    <p><label for="pass2">Парола</label> <input type="password" name="pass2" id="pass2" />    
        <?php
        if ($errors['password_mach']) {
            echo 'Паролата не отговаря';
        }
        ?>
    </p>
    <p class="submit"><input type="submit" value="Регистрация" /></p>
</form> 

<?php
include '../views/footer.php';


