<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=price&order=0">Від дешевших до дорожчих</a>
    <br>
<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=price&order=1">Від дорожчих до дешевших</a>


<?php
if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else 
        { 
            $sort = "name";
        }
if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = 0;
        } 

// Сортування

/*
 * В залежності від вибраного методу сортування
 * присвоюємо змінній $sortOrder необхідну константу,
 * яка буде використувуватися в функції array_multisort
 * */
if($order == 1) {
    $sortOrder = SORT_DESC;
} else {
    $sortOrder = SORT_ASC;
}

/*
 * Перебираємо масив товарів та на основі нього
 * створюємо ще один масив,
 * який буде складатися з ключів та значень поля,
 * по якому необхідно сортувати товари
 * */
foreach ($products as $key => $value) {
	$sortBy[$key] = $value[$sort];
}

// Сортуємо масив
array_multisort($sortBy, $sortOrder, $products);

   
foreach($products as $product)  :
?>
    <div class="product">
        <p class="sku">Код: <?php echo $product['sku']?></p>
        <h4><?php echo $product['name']?><h4>
        <p> Ціна: <span class="price"><?php echo $product['price']?></span> грн</p>
        <p><?php if(!$product['qty'] > 0) { echo 'Нема в наявності'; } ?></p>
    </div>
<?php endforeach; ?>
