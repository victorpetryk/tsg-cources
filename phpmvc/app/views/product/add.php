<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<form method="POST" action="">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?php Helper::displayError('name', 'empty', true); ?>">
                <label class="control-label" for="name">Назва товару</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?php echo $this->registry['values']['name']; ?>" placeholder="Назва товару">
                <?php Helper::displayError('name', 'empty'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('sku', 'empty', true); ?>">
                <label class="control-label" for="sku">Код товару</label>
                <input type="text" class="form-control" id="sku" name="sku"
                       value="<?php echo $this->registry['values']['sku']; ?>" placeholder="Код товару">
                <?php Helper::displayError('sku', 'empty'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('price', 'empty|float', true); ?>">
                <label class="control-label" for="price">Ціна</label>
                <input type="text" class="form-control" id="price" name="price"
                       value="<?php echo $this->registry['values']['price']; ?>" placeholder="Ціна">
                <?php Helper::displayError('price', 'empty|float'); ?>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('qty', 'empty|float', true); ?>">
                <label class="control-label" for="qty">Кількість</label>
                <input type="text" class="form-control" id="qty" name="qty"
                       value="<?php echo $this->registry['values']['qty']; ?>" placeholder="Кількість">
                <?php Helper::displayError('qty', 'empty|float'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?php Helper::displayError('description', 'empty', true); ?>">
                <label class="control-label" for="description">Опис товару</label>
                <textarea class="form-control" id="description" name="description"
                          rows="4"><?php echo $this->registry['values']['description']; ?></textarea>
                <?php Helper::displayError('description', 'empty'); ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Зберегти</button>
</form>