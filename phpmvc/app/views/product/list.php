<form class="form-inline" method="POST" action="">
    <select class="form-control" name='sortfirst'>
        <option <?php echo $this->registry['sort']['price'] === 'price_ASC' ? 'selected' : ''; ?>
                value="price_ASC">від дешевших до дорожчих
        </option>
        <option <?php echo $this->registry['sort']['price'] === 'price_DESC' ? 'selected' : ''; ?>
                value="price_DESC">від дорожчих до дешевших
        </option>
    </select>
    <select class="form-control" name='sortsecond'>
        <option <?php echo $this->registry['sort']['qty'] === 'qty_ASC' ? 'selected' : ''; ?> value="qty_ASC">по
            зростанню кількості
        </option>
        <option <?php echo $this->registry['sort']['qty'] === 'qty_DESC' ? 'selected' : ''; ?> value="qty_DESC">
            по спаданню кількості
        </option>
    </select>
    <input class="btn btn-default" type="submit" value="Submit">
</form>

<?php
if (Helper::isAdmin()) {
    echo Helper::simpleLink('/product/add', 'Додати товар', [], 'btn-primary') . " " .
         Helper::simpleLink('/product/export', 'Експорт', [], 'btn-warning');
}
?>

<hr>

<?php Helper::displayAlert(); ?>

<div class="row">

    <?php
    $products = $this->registry['products'];
    foreach ($products as $product)  :
        ?>
        <div class="col-md-4">
            <div class="product-card panel panel-default">
                <div class="panel-body">
                    <h3>
                        <a href="<?php echo Route::getBP() . '/product/card?id=' . $product['id']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </h3>
                    <p>Код: <strong class="text-muted"><?php echo $product['sku']; ?></strong></p>
                    <p>Ціна: <span class="lead text-danger"><?php echo $product['price']; ?></span> грн.</p>
                    <p>Кількість:
                        <strong><?php echo ($product['qty'] > 0 || $product['qty'] != 0) ? $product['qty'] : "Нема в наявності"; ?></strong>
                    </p>

                    <a href="<?php echo Route::getBP() . '/cart/add?id=' . $product['id']; ?>" class="btn btn-info">
                        Додати в корзину
                    </a>

                </div>

                <?php if (Helper::isAdmin()) : ?>

                    <div class="panel-footer">
                        <?php echo Helper::simpleLink('/product/edit', 'Редагувати', array('id' => $product['id']),
                            'btn-default btn-sm'); ?>

                        <a href="#" class="delete-button btn btn-danger btn-sm"
                           data-product-id="<?php echo $product['id']; ?>" data-toggle="modal"
                           data-target="#deleteProductModal">
                            Видалити
                        </a>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<!-- Модальне вікно для підтвердження видалення товару -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрити"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Видалення товару</h4>
            </div>
            <div class="modal-body">
                <p>Ви дійсно бажаєте видалити товар?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ні</button>
                <a href="" id="modalDeleteButton" class="btn btn-danger">Видалити</a>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteButton = $('.delete-button');

    deleteButton.on('click', function () {
        var productID = $(this).data('product-id'),
            url = '<?php echo Route::getBP(); ?>' + '/product/delete?id=';

        url += productID;

        $('#modalDeleteButton').attr('href', url);
    });
</script>
