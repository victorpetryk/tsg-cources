<?php

class CustomerController extends Controller
{

    protected $invalidPassword = 0;
    protected $registered = 0;
    protected $registry = array();

    public function ListAction()
    {
        $this->setTitle('Клієнти');

        $this->registry['customers'] = $this->getModel('Customer')->initCollection()
                                            ->getCollection()->select();

        $this->setView();
        $this->renderLayout();
    }

    public function RegisterAction()
    {
        $this->setTitle("Реєстрація");
        $model = $this->getModel('Customer');

        $postValues = $model->getPostValues();
        $this->registry['values'] = $postValues;

        // Забираємо з масиву поле "admin_role"
        unset($postValues['admin_role']);

        // Додаємо в масив отриманих даних поле з підтвердженим паролем
        // щоб провести його валідацію
        $postValues['password_confirm'] = filter_input(INPUT_POST, 'password_confirm');

        $validatedValues = Helper::validate($postValues);

        if ($validatedValues) {
            $model->addItem($validatedValues);

            $_SESSION['success'] = 'Реєстрація пройшла успішно. Введіть дані для входу!';
            Helper::redirect('/customer/login');
        }

        $this->setView();
        $this->renderLayout();
    }

    public function LoginAction()
    {
        $this->setTitle("Вхід");
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $email    = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');

            // Якщо поле з паролем порожнє, то md5 не робимо
            $password = ($password === '') ? $password : md5($password);

            $params = array(
                'email'    => $email,
                'password' => $password
            );

            $validatedParams = Helper::validate($params);

            if ($validatedParams) {
                $customer = $this->getModel('customer')->initCollection()
                                 ->filter($params)
                                 ->getCollection()
                                 ->selectFirst();

                if ( ! empty($customer)) {
                    session_regenerate_id();

                    $_SESSION['id'] = $customer['customer_id'];
                    $this->invalidPassword = 0;

                    Helper::redirect('/index/index');
                } else {
                    $this->invalidPassword = 1;
                }
            }
        }

        $this->setView();
        $this->renderLayout();
    }

    public function LogoutAction()
    {
        $_SESSION = [];

        // expire cookie
        if ( ! empty($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 3600, "/");
        }

        session_destroy();
        Helper::redirect('/index/index');
    }
}