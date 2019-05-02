<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<?php

if ($this->invalidPassword === 1) {

    Helper::displayAlert('danger', false, 'Користувача з таким email-ом і паролем не існує!');

}

Helper::displayAlert();

?>

<form method="POST" action="">
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group <?php Helper::displayError('email', 'empty|email', true); ?>">
                <label class="control-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                <?php Helper::displayError('email', 'empty|email'); ?>
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
    </div>
    <button type="submit" class="btn btn-default">Увійти</button>
</form>