<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<form method="POST" action="">
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('last_name', 'empty|string', true); ?>">
                <label class="control-label" for="last_name">Прізвище</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                       value="<?php echo $this->registry['values']['last_name']; ?>" placeholder="Прізвище">
                <?php Helper::displayError('last_name', 'empty|string'); ?>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('first_name', 'empty|string', true); ?>">
                <label class="control-label" for="first_name">Ім'я</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                       value="<?php echo $this->registry['values']['first_name']; ?>" placeholder="Ім'я">
                <?php Helper::displayError('first_name', 'empty|string'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('email', 'empty|email', true); ?>">
                <label class="control-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email"
                       value="<?php echo $this->registry['values']['email']; ?>"
                       placeholder="Email">
                <?php Helper::displayError('email', 'empty|email'); ?>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('telephone', 'empty|string', true); ?>">
                <label class="control-label" for="telephone">Телефон</label>
                <input type="text" class="form-control" id="telephone" name="telephone"
                       value="<?php echo $this->registry['values']['telephone']; ?>" placeholder="Телефон">
                <?php Helper::displayError('telephone', 'empty|string'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?php Helper::displayError('city', 'empty|string', true); ?>">
                <label class="control-label" for="city">Місто</label>
                <input type="text" class="form-control" id="city" name="city"
                       value="<?php echo $this->registry['values']['city']; ?>"
                       placeholder="Місто">
                <?php Helper::displayError('city', 'empty|string'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('password', 'empty|password', true); ?>">
                <label class="control-label" for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                <?php Helper::displayError('password', 'empty|password'); ?>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('password_confirm', 'empty|password_confirm', true); ?>">
                <label class="control-label" for="password_confirm">Підтвердіть пароль</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                       placeholder="Підтвердіть пароль">
                <?php Helper::displayError('password_confirm', 'empty|password_confirm'); ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Зареєструватися</button>
</form>