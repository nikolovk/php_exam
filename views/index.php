<?php
include '../views/header.php';
if ($_SESSION['is_logged']) {
    echo '<div>Здравей ' . $_SESSION['user_data']['email'] . ' <a href="?p=new_auction">Нова обява</a> <a href="?p=logout">Изход</a></div>';
} else {
    echo '<div><a href="?p=login">Вход</a> <a href="?p=register">Регистрация</a> </div>';
}
?>
<p>
    <?php if ($auctions && count($auctions) > 0) { ?>

    <table>
        <tr>
            <th>Име на търга (продукта)</th>
            <th>Описание на търга (продукта)</th>
            <th>Дата на изтичане на търга (продукта)</th>
            <th>Най-високата предложена цена</th>
            <th>Публикувал</th>
            <?= $isLogged?'<th>Действие</th>':'' ?>
        </tr>
        <?php
        foreach ($auctions as $auction) {
            echo '<tr>';
            echo '<td>'.$auction['action_title'].'</td>';
            echo '<td>'.$auction['auction_desc'].'</td>';
            echo '<td>'.date("Y-m-d",$auction['date_end']).'</td>';
            echo '<td>'.$auction['minimum_price'].'</td>';
            echo '<td>'.$auction['email'].'</td>';
            if ($isLogged) {
                echo '<td><a href ="?p=bid&auction_id='.$auction['auction_id'].'">Наддавай</а></td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
<?php } ?>
</p>
<?php
include '../views/footer.php';


