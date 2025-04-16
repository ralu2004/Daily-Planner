<?php

namespace RalucaAdam\MyDailyPlanner\models;

class Category extends Model
{
    public $id;
    public $name;

    public function getAll()
    {
        $sql = "SELECT * FROM categories";
        return $this->fetchAll($sql);
    }

    public function findByName($name)
    {
        $sql = "SELECT * FROM categories WHERE name = :name LIMIT 1";
        return $this->fetchOne($sql, [':name' => $name]);
    }

    public function create()
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $params = [':name' => $this->name];
        return $this->query($sql, $params);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
?>