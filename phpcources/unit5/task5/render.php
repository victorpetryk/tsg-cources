<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=price&order=0">Від дешевших до дорожчих</a>
<br>
<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=price&order=1">Від дорожчих до дешевших</a>
<hr>
<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=discount&order=1">З найбільшою знижкою</a>
<br>
<a href="<?php $_SERVER['PHP_SELF']; ?>?sort=discount&order=0">З найменшою знижкою</a>

<?php
if ( isset( $_GET['sort'] ) ) {
	$sort = $_GET['sort'];
} else {
	//$sort = "name";

	/*
	 * Оскільки в PHP 7.1 і вище виникає
	 * Warning: A non-numeric value encountered
	 * прийшлося змінити сортування за замовчуванням
	 * по прайсу (можна і по іншому полю, що являється числом)
	 *
	 * Якщо все таки треба буде сортувати товари і по імені,
	 * то, напевно, прийдеться використати array_multisort
	 * */
	$sort = "price";
}
if ( isset( $_GET['order'] ) ) {
	$order = $_GET['order'];
} else {
	$order = 0;
}

// Сортування

usort( $products, function ( $a, $b ) use ( $sort, $order ) {
	if ( $sort == 'price' ) {
		$a = $a['price'] - ( $a['price'] * $a['discount'] / 100 );
		$b = $b['price'] - ( $b['price'] * $b['discount'] / 100 );
	} else {
		$a = $a[$sort];
		$b = $b[$sort];
	}

	if ( $order == 0 ) {
		return $a - $b;
	} else {
		return $b - $a;
	}
} );

foreach ( $products as $product )  :

	$priceWithDiscount = $product['price'] - ( $product['price'] * $product['discount'] / 100 );

	?>
    <div class="product">
        <p class="sku">Код: <?php echo $product['sku'] ?></p>
        <h4><?php echo $product['name'] ?>
            <h4>
                <p>Ціна: <span class="price"><s><?php echo $product['price'] ?></s> <?php echo $priceWithDiscount ?></span>
                    грн.</p>
                <p>Знижка: <span class="discount"><?php echo $product['discount'] ?></span> %</p>
                <p>
                    <?php if ( ! $product['qty'] > 0 ) {
						echo 'Нема в наявності';
					}
					?>
                </p>
    </div>
<?php endforeach; ?>
