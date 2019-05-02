<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<?php $product = $this->registry['product']; ?>

<h3 class="text-info"><?php echo $product['name'] ?></h3>
<p><strong>Код товару:</strong> <span class="text-muted"><?php echo $product['sku']; ?></span></p>
<p><strong>Ціна:</strong> <span class="lead text-danger"><?php echo $product['price']; ?></span> грн.</p>
<p><strong>Кількість:</strong> <span><?php echo $product['qty']; ?></span></p>

<hr>

<h4>Опис товару:</h4>

<?php echo htmlspecialchars_decode($product['description']); ?>


