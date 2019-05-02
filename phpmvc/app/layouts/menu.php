<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <?php
            $menu = Helper::getMenu();
            foreach ($menu as $item)  :
                ?>
                <li>
                    <?php echo Helper::simpleLink($item['path'], $item['name']); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php $customerFullName = Helper::getCustomer()['last_name'] . ' ' . Helper::getCustomer()['first_name']; ?>

        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="<?php echo Route::getBP(); ?>/cart/list/">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Корзина <span class="badge">
                        <?php echo Helper::cartItemsCount(); ?>
                    </span>
                </a>
            </li>
            <?php if (empty($_SESSION['id'])) : ?>
                <li>
                    <a href="<?php echo Route::getBP(); ?>/customer/register/">
                        <span class="glyphicon glyphicon-user"></span> Реєстрація
                    </a>
                </li>
                <li>
                    <a href="<?php echo Route::getBP(); ?>/customer/login/">
                        <span class="glyphicon glyphicon-log-in"></span> Вхід
                    </a>
                </li>
            <?php else : ?>
                <li>
                    <a href="#">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $customerFullName; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Route::getBP(); ?>/customer/logout/">
                        <span class="glyphicon glyphicon-log-in"></span> Logout
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>