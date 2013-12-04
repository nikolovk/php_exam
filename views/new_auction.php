<?php
include '../views/header.php';
?>
<div>Здравей <?= $_SESSION['user_data']['email'] ?> <a href="?">Начало</a> <a href="?p=logout">Изход</a></div>

<form action="?p=new_auction" method="POST">
    <p class="success"><?= $success ? $success : '' ?></p>
    <p>
        <label for="name">Име на търга (продукта)</label> 
        <input type="text" name="name" id="name" />
        <span class="error"><?= $errors['name'] ? $errors['name'] : '' ?></span>
    </p> 
    <p>
        <label for="description">Описание на търга (продукта)</label> 
        <input type="text" name="description" id="description" />
        <span class="error"><?= $errors['description'] ? $errors['description'] : '' ?></span>
    </p> 
    <p>
        <label for="price">Цена на старт на търга (минимална цена)</label> 
        <input type="number" name="price" id="price" />
        <span class="error"><?= $errors['price'] ? $errors['price'] : '' ?></span>
    </p> 
    <p>
        <label for="date">Продължителност на търга – дата</label> 
        <input type="date" name="date" id="date" />
        <span class="error"><?= $errors['date'] ? $errors['date'] : '' ?></span>
    </p> 
    <p class="submit"><input type="submit" value="Нова обява" /></p>
</form> 

<?php
include '../views/footer.php';


