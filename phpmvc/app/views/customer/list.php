<h2><?php echo $this->getTitle(); ?></h2>

<hr>

<?php $customers = $this->registry['customers']; ?>

<?php if ( ! $customers) :

    Helper::displayAlert('danger', false, 'Вибачте, але жодного клієнта немає.');

else : ?>

    <table id="customers" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Прізвище</th>
            <th>Ім'я</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Місто</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($customers as $customer) : ?>
            <tr>
                <td><?php echo $customer['last_name']; ?></td>
                <td><?php echo $customer['first_name']; ?></td>
                <td><?php echo $customer['telephone']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['city']; ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>


