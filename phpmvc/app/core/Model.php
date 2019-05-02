<?php

class Model
{

    protected $table_name;
    protected $id_column;
    protected $columns = [];
    protected $collection;
    protected $sql;
    protected $params = [];

    public function initCollection()
    {
        $columns   = implode(',', $this->getColumns());
        $this->sql = "select $columns from " . $this->table_name;

        return $this;
    }

    public function getColumns()
    {
        $db      = new DB();
        $sql     = "show columns from  $this->table_name;";
        $results = $db->query($sql);
        foreach ($results as $result) {
            array_push($this->columns, $result['Field']);
        }

        return $this->columns;
    }

    /**
     * Сортування
     *
     * @param $params
     *
     * @return $this
     */
    public function sort($params)
    {
        // Формуємо початок рядка,
        // який буде додаватися до
        // sql-запиту для вибору товарів
        // з врахуванням сортування
        $sqlOrderBy = ' ORDER BY ';

        // Перебираємо масив з параметрами сортування
        // та додаємо до рядку з сортуванням
        foreach ($params as $key => $value) {
            $sqlOrderBy .= $key . ' ' . $value;

            // Ставимо кому між полями сортування, крім останнього
            if (next($params)) {
                $sqlOrderBy .= ', ';
            }
        }

        // Додаємо до sql-запиту сортування по заданих полях
        $this->sql = $this->sql . $sqlOrderBy;

        return $this;
    }

    public function filter($params)
    {
        $sqlFilter = "";

        foreach ($params as $key => $value) {
            $sqlFilter .= "$key = :$key";

            if (next($params)) {
                $sqlFilter .= ' and ';
            }
        }

        $this->sql = $this->sql . " where " . $sqlFilter;
        $this->params = $params;

        return $this;
    }

    public function getCollection()
    {
        $db               = new DB();
        $this->sql        .= ";";
        $this->collection = $db->query($this->sql, $this->params);

        return $this;
    }

    public function select()
    {
        return $this->collection;
    }

    public function selectFirst()
    {
        return isset($this->collection[0]) ? $this->collection[0] : null;
    }

    public function getItem($id)
    {
        $sql    = "select * from $this->table_name where $this->id_column = ?;";
        $db     = new DB();
        $params = array($id);

        return $db->query($sql, $params)[0];
    }

    public function getPostValues()
    {
        $values  = [];
        $columns = $this->getColumns();

        foreach ($columns as $column) {
            $column_value = filter_input(INPUT_POST, $column);

            if ($column !== $this->id_column) {
                $values[$column] = $column_value;
            }

        }

        return $values;
    }


    /**
     * Додавання даних
     *
     * @param $validatedValues
     *
     * @return bool
     */
    public function addItem($validatedValues)
    {
        $columns = implode(',', array_keys($validatedValues));
        $values  = array_values($validatedValues);

        $sql = "insert into $this->table_name ($columns) values (" . rtrim(str_repeat('?,', count($values)),
                ',') . ");";

        $db  = new DB();
        $db->query($sql, $values);

        if ($db) {
            return true;
        }

        return false;
    }

    /**
     * Редагування даних
     *
     * @param $id
     * @param $validatedValues
     *
     * @return bool
     */
    public function saveItem($id, $validatedValues)
    {
        $columns = implode(' = ?, ', array_keys($validatedValues));
        $values  = array_values($validatedValues);

        array_push($values, $id);

        $sql = "update $this->table_name set " . $columns . " = ? where id = ?;";

        $db  = new DB();
        $db->query($sql, $values);

        if ($db) {
            return true;
        }

        return false;
    }

    public function deleteItem($id)
    {
        $values = [];
        array_push($values, $id);

        $sql = "delete from $this->table_name where id = ?";

        $db = new DB();
        $db->query($sql, $values);

        if ($db) {
            return true;
        }

        return false;
    }
}
