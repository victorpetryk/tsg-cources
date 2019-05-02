<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<?php

$cartItems = $this->registry['cart-items'];
$total     = 0;

Helper::displayAlert();

?>

<?php if ( ! $cartItems) :
    Helper::displayAlert('warning', false, 'Ваша корзина порожня.');
else : ?>

    <table id="cartItems" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>SKU</th>
            <th>Назва</th>
            <th>Кількість</th>
            <th>Ціна</th>
            <th>Сума</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($cartItems as $cartItem) :
            $sum = (int)$cartItem['qty'] * $cartItem['price'];
            $total += $sum;
            ?>

            <tr>
                <td><?php echo $cartItem['sku']; ?></td>
                <td><?php echo $cartItem['name']; ?></td>
                <td><?php echo (int)$cartItem['qty']; ?></td>
                <td><?php echo $cartItem['price']; ?></td>
                <td>
                    <?php echo $sum; ?>
                </td>
                <td class="text-center">
                    <a href="<?php echo Route::getBP() . '/cart/delete?id=' . $cartItem['id']; ?>"
                       class="btn btn-danger" title="Видалити">
                        <i class="glyphicon glyphicon-remove
"></i>
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
        <tfoot>
        <tr>
            <td class="text-right" colspan="4"><strong>Загальна сума:</strong></td>
            <td colspan="2"><strong><?php echo $total; ?></strong></td>
        </tr>
        </tfoot>
    </table>

    <div class="clearfix">
        <a href="<?php Route::getBP(); ?>/cart/checkout" class="btn btn-lg btn-primary pull-right">
            Оформити замовлення
        </a>
    </div>

<?php endif; ?>
