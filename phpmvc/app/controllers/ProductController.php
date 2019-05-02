<?php

class ProductController extends Controller
{

    protected $registry = array();

    public function IndexAction()
    {
        $this->ListAction();
    }

    public function ListAction()
    {
        $this->setTitle("Товари");
        $this->registry['products'] = $this->getModel('Product')->initCollection()
                                           ->sort($this->getSortParams())->getCollection()->select();

        $this->setView();
        $this->renderLayout();
    }

    public function CardAction()
    {
        $this->setTitle("Карточка товара");
        $this->registry['product'] = $this->getModel('Product')->initCollection()
                                          ->filter(['id' => $this->getId()])->getCollection()->selectFirst();

        $this->setView();
        $this->renderLayout();
    }

    public function EditAction()
    {
        if (Helper::isAdmin()) {
            $this->setTitle("Редагування товару");
            $model = $this->getModel('Product');

            $this->registry['values'] = $model->getItem($this->getId());

            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            if ($id) {
                // Забираємо дані, що приходять через POST-запит
                $postValues = $model->getPostValues();

                // Формуємо масив даних для відобрадення в формі;
                // або дані з БД, або з POST-запиту
                foreach ($postValues as $key => $value) {
                    if ( ! empty($value)) {
                        $this->registry['values'][$key] = $value;
                    } else {
                        $this->registry['values'][$key] = '';
                    }
                }

                // Проводимо очитку і валідацію отриманих даних
                $validatedValues = Helper::validate($postValues);

                // Якщо дані пройшли валідацію, то зберігаємо їх в БД
                if ($validatedValues) {
                    // Зберігаємо дані в БД
                    $model->saveItem($id, $validatedValues);

                    // Записуємо в сесію повідомлення
                    $_SESSION['success'] = 'Товар успішно збережено!';
                }
            }

            $this->setView();
            $this->renderLayout();
        } else {
            Helper::redirect('/error/access');
        }
    }

    public function AddAction()
    {
        if (Helper::isAdmin()) {
            $this->setTitle("Додавання товару");
            $model = $this->getModel('Product');

            // Забираємо дані, що приходять через POST-запит
            $postValues = $model->getPostValues();

            // Записуємо POST-дані в масив для відображення в формі
            $this->registry['values'] = $postValues;

            // Проводимо очитку і валідацію отриманих даних
            $validatedValues = Helper::validate($postValues);

            // Якщо дані пройшли валідацію, то додаємо їх в БД
            if ($validatedValues) {
                // Додаємо дані в БД
                $model->addItem($validatedValues);

                // Отримуємо ID доданого товару
                $db = new DB();
                $id = $db->lastInsertID();

                // Записуємо в сесію повідомлення, щоб відобразити його
                // на сторінці редагування товару
                $_SESSION['success'] = 'Товар успішно додано!';

                // Перенаправляємо на сторінку редагування товару
                Helper::redirect("/product/edit?id=$id");
            }

            $this->setView();
            $this->renderLayout();
        } else {
            Helper::redirect('/error/access');
        }
    }

    public function DeleteAction()
    {
        if (Helper::isAdmin()) {
            $model = $this->getModel('Product');
            $model->deleteItem($this->getId());

            Helper::redirect('/product/list');
        } else {
            Helper::redirect('/error/access');
        }

    }

    public function getSortParams()
    {
        $params = [];

        $post = filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST';

        // Якщо був POST-запит, то використувуємо для сортування дані з форми,
        // інакше беремо дані з кукі, або використувуємо значення за замовчуванням
        if ($post) {

            $this->registry['sort']['price'] = filter_input(INPUT_POST, 'sortfirst');
            $this->registry['sort']['qty']   = filter_input(INPUT_POST, 'sortsecond');

        } elseif ( ! empty($_COOKIE['sort'])) {

            $this->registry['sort']['price'] = 'price_' . explode(',', $_COOKIE['sort'])[0];
            $this->registry['sort']['qty']   = 'qty_' . explode(',', $_COOKIE['sort'])[1];

        } else {

            $this->registry['sort']['price'] = "price_ASC";
            $this->registry['sort']['qty']   = "qty_ASC";

        }

        if ($this->registry['sort']['price'] === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }

        if ($this->registry['sort']['qty'] === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }

        // Якщо був POST-запит (натиснута кнопка сортування)
        // записуємо параметри сортування в кукі
        if ($post) {
            $sortCookie = implode(',', $params);
            setcookie('sort', $sortCookie, time() + 3600);
        }

        return $params;
    }

    public function getSortParams_old()
    {
        /*
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else 
        { 
            $sort = "name";
        }
         * 
         */
        $sort = filter_input(INPUT_GET, 'sort');
        if ( ! isset($sort)) {
            $sort = "name";
        }
        /*
        if (isset($_GET['order']) && $_GET['order'] == 1) {
            $order = "ASC";
        } else {
            $order = "DESC";
        }
         * 
         */
        if (filter_input(INPUT_GET, 'order') == 1) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }

        return array($sort, $order);
    }

    public function getId()
    {
        return filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Експорт товарів
     */
    public function ExportAction()
    {
        if (Helper::isAdmin()) {
            $products = $this->getModel('Product')->initCollection()
                             ->getCollection()->select();

            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><products/>');

            foreach ($products as $product) {
                $xmlProduct = $xml->addChild('product');
                $xmlProduct->addChild('id', $product['id']);
                $xmlProduct->addChild('sku', $product['sku']);
                $xmlProduct->addChild('name', $product['name']);
                $xmlProduct->addChild('price', $product['price']);
                $xmlProduct->addChild('qty', $product['qty']);
                $xmlProduct->addChild('description', $product['description']);
            }

            $dom                     = new DOMDocument("1.0");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput       = true;
            $dom->loadXML($xml->asXML());

            $filePath = ROOT . '/public/products.xml';

            $file = fopen($filePath, 'w');

            chmod($filePath, 0775);

            fwrite($file, $dom->saveXML());
            fclose($file);

            if ( ! file_exists($filePath)) {
                $_SESSION['alert'] = 'Виникла помилка експорту!';
                Helper::redirect('/product/list');
            } else {
                $_SESSION['success'] = 'Товари успішно експортовано! ' . Helper::simpleLink('/product/download',
                        'Скачати файл', [], 'btn-success');
                Helper::redirect('/product/list');
            }

        } else {
            Helper::redirect('/error/access');
        }
    }

    /**
     * Скачування файлу з експортованими товарами
     */
    public function DownloadAction()
    {
        if (Helper::isAdmin()) {
            Helper::redirectDownload(Route::getBP() . 'public/products.xml');
        } else {
            Helper::redirect('/error/access');
        }
    }

}