<?php

namespace RalucaAdam\MyDailyPlanner\models;

class User extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    // Register a new user
    public function register()
    {
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (:name, :email, :password, :created_at)";
        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => password_hash($this->password, PASSWORD_BCRYPT),
            ':created_at' => $this->created_at
        ];
        return $this->query($sql, $params);
    }

    public function findByEmail()
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        return $this->fetchOne($sql, [':email' => $this->email]);
    }

    public function findById()
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->fetchOne($sql, [':id' => $this->id]);
    }

    public function findByUsernameAndEmail($username, $email)
    {
        $sql = "SELECT * FROM users WHERE name = :username AND email = :email LIMIT 1";
        return $this->fetchOne($sql, [':username' => $username, ':email' => $email]);
    }

    public function updatePassword()
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        return $this->query($sql, [':password' => $this->password, ':id' => $this->id]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
?>