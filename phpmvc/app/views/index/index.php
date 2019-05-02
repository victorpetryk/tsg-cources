<?php $customerFullName = Helper::getCustomer()['last_name'] . ' ' . Helper::getCustomer()['first_name']; ?>

<?php if (empty($_SESSION['id'])) : ?>
    <h3>Hello, unauthorized user!</h3>
<?php else : ?>
    <h3>Hello, <?php echo $customerFullName; ?>!</h3>
<?php endif; ?>




