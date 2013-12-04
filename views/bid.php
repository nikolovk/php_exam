<?php
include '../views/header.php';
?>
<div>Здравей <?= $_SESSION['user_data']['email'] ?> <a href="?">Начало</a> <a href="?p=logout">Изход</a></div>
<p><?= $add_message ? $add_message : '' ?></p>
<p>
    <?php if (is_array($auction) && count($auction) > 0) { ?>
    <ul>
        <li>Име на търга (продукта) <?= $auction['action_title'] ?></li>
        <li>Описание на търга (продукта) <?= $auction['auction_desc'] ?></li>
        <li>Стартова цена <?= $auction['minimum_price'] ?></li>
        <li>Текуща цена <?= $auction['max_price'] == 0 ? $auction['minimum_price'] : $auction['max_price'] ?></li>
        <li>Потребител <?= $auction['email'] ?></li>
        <li>
            Предложение:
            <form action="?p=bid&auction_id=<?= $auction['auction_id'] ?>" method="POST">
                <input type="number" name="new_price">
                <input type="submit" value="Оферта" />
            </form>
        </li>
    </ul>

<?php } else { ?>
    <p>Не съществува търг</p>
    <?php
    }
    include '../views/footer.php';


    