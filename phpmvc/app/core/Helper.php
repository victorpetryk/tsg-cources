<?php

class Helper
{
    public static $errorMessage = [];

    public static function getModel($name)
    {
        $model = new $name();

        return $model;
    }

    public static function getMenu()
    {
        return self::getModel('menu')->initCollection()
                   ->sort(array('sort_order' => 'ASC'))->getCollection()->select();
    }

    public static function simpleLink($path, $name, $params = [], $btnStyle = 'btn-link')
    {
        if ( ! empty($params)) {
            $firts_key = array_keys($params)[0];
            foreach ($params as $key => $value) {
                $path .= ($key === $firts_key ? '?' : '&');
                $path .= "$key=$value";
            }
        }

        return '<a href="' . route::getBP() . $path . '" class="btn ' . $btnStyle . '">' . $name . '</a>';
    }

    public static function redirect($path)
    {
        $server_host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        $url         = $server_host . route::getBP() . $path;
        header("Location: $url");
    }

    /**
     * Редирект на скачування файлу
     *
     * @param $filePath
     */
    public static function redirectDownload($filePath)
    {
        $filePath = trim($filePath, '/');

        $pathChunks = explode('/', $filePath);

        $fileName      = $pathChunks[count($pathChunks) - 1];
        $fileExtension = substr($fileName, -1, 3);

        header('Content-Type: application/' . $fileExtension . '');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        readfile($filePath);
    }

    public static function getCustomer()
    {
        if ( ! empty($_SESSION['id'])) {
            return self::getModel('customer')->initCollection()
                       ->filter(array('customer_id' => $_SESSION['id']))
                       ->getCollection()
                       ->selectFirst();
        } else {
            return null;
        }

    }

    public static function isAdmin()
    {
        if ( ! empty($_SESSION['id'])) {
            $admin = self::getModel('customer')->initCollection()
                         ->filter(array(
                             'customer_id' => $_SESSION['id'],
                             'admin_role'  => 1
                         ))
                         ->getCollection()
                         ->selectFirst();

            if ($admin) {
                return true;
            }
        }

        return false;
    }

    /**
     * Валідація даних
     *
     * @param $values
     *
     * @return array|bool
     */
    public static function validate($values)
    {
        /*
         * Правила валідації полів
         *
         * 'string' - видаляє теги
         * 'html' - екранує HTML-символи
         * 'float' - дозволяє лише float
         * 'email' - перевіряє email на валідність
         * 'password' - перевіряє чи пароль містить не менше 8 символів з цифрами і латинськими буквами
         * 'password_confirm' - перевіряє співпадання паролів
         *
         * */
        $rules = [
            'sku'              => 'string',
            'name'             => 'string',
            'description'      => 'html',
            'price'            => 'float',
            'qty'              => 'float',
            'last_name'        => 'string',
            'first_name'       => 'string',
            'telephone'        => 'string',
            'city'             => 'string',
            'email'            => 'email',
            'password'         => 'password',
            'password_confirm' => 'password_confirm',
        ];

        $validatedValues = [];

        if ($_POST) {
            foreach ($values as $key => $value) {
                // Очищаємо від початкових і кінцевих пробілів
                $value = trim($value);

                if ($value === '') {
                    self::$errorMessage[$key]['empty'] = "Поле не може бути порожнім!";
                } else {

                    switch ($rules[$key]) {
                        // Фільтрація рядків
                        case 'string':
                            $validatedValues[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                            break;

                        // Фільтрація рядків, де дозволений HTML
                        case 'html':
                            $validatedValues[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                            break;

                        // Валідація float
                        case 'float':
                            if (filter_var($value, FILTER_VALIDATE_FLOAT)) {
                                $validatedValues[$key] = $value;
                            } else {
                                self::$errorMessage[$key]['float'] = "Поле повинно бути типу float!";
                            }
                            break;

                        // Фільтрація та валідація email
                        case 'email':
                            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $validatedValues[$key] = $value;
                            } else {
                                self::$errorMessage[$key]['email'] = "Email введений невірно!";
                            }
                            break;

                        // Валідація поля з паролем
                        case 'password':
                            $password = $value;

                            if (preg_match('/^(?!\d*$|[a-z]*$)([a-z\d]+){8,}$/i', $password)) {
                                $validatedValues[$key] = md5($password);
                            } else {
                                self::$errorMessage[$key]['password'] = "Поле повинно містити не менше 8 символів з цифрами та англійськими буквами.";
                            }
                            break;

                        // Валідація підтвердження пароля
                        case 'password_confirm':
                            $password         = isset($password) ? $password : null;
                            $password_confirm = $value;

                            if ($password !== $password_confirm) {
                                self::$errorMessage[$key]['password_confirm'] = "Паролі не співпадають";
                            }
                            break;
                    }

                }

            }
        }

        if (self::$errorMessage) {
            return false;
        }

        return $validatedValues;
    }


    /**
     * Відображення помилок валідації полів форми
     *
     * @param $field - ім'я поля форми
     * @param $types - типи помилок (empty|float)
     * @param bool $class - використовується для відображення необхідних класів bootstrap
     */
    public static function displayError($field, $types, $class = false)
    {
        if (isset($_POST)) {

            $types = explode('|', $types);

            foreach ($types as $type) {
                if (isset(self::$errorMessage[$field][$type])) {
                    if ($class) {
                        echo 'has-error';
                    } else {
                        echo '<span class="help-block">' . self::$errorMessage[$field][$type] . '</span>';
                    }
                }
            }
        }
    }

    /**
     * Відображення повідомлень
     *
     * @param string $type
     * @param bool $session
     * @param string $message
     */
    public static function displayAlert($type = 'success', $session = true, $message = '')
    {
        if ($session) {
            if ( ! empty($_SESSION[$type])) {
                echo "<p class=\"alert alert-success\" role=\"alert\">$_SESSION[$type]</p>";
                $_SESSION[$type] = '';
            }
        } else {
            echo "<p class=\"alert alert-$type\" role=\"alert\">$message</p>";
        }
    }

    /**
     * Повертаємо ідентифікатор корзини
     *
     * @return mixed
     */
    public static function getCartID()
    {
        // Вибираємо з бази корзину, яка відповідає
        // сесійному ідентифікатору відвідувача
        $cart = self::getModel('cart')->initCollection()
                    ->filter(['visitor_id' => session_id()])->getCollection()->selectFirst();

        // Якщо корзини з таким відвідувачем не існує,
        // то записуємо сесійний ідентифікатор в таблицю корзини
        // та рекурсивно запускаємо отримання ідентифікатора корзини
        if ( ! $cart) {
            self::getModel('cart')->addItem(['visitor_id' => session_id()]);
            self::getCartID();
        }

        return $cart['cart_id'];
    }

    /**
     * Повертаємо кількість товарів у корзині
     *
     * @return int
     */
    public static function cartItemsCount()
    {
        $cartID = self::getCartID();

        // Отримуємо товари, що знаходяться в корзині
        $cartItems = self::getModel('CartItem')->getCartItems($cartID);

        $cartItemCount = 0;

        // Перебираємо товари з корзини, та сумуємо їх кількість
        foreach ($cartItems as $cartItem) {
            $cartItemCount += (int)$cartItem['qty'];
        }

        return $cartItemCount;
    }
}