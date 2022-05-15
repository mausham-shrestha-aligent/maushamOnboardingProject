<?php

namespace App\Models;

class User extends Model {
    public function create(string $name, string $email, string $password) : int {
        $stmt = $this->db->prepare(
            'Insert into users(name, email, password) Values (?, ? ,?)'
        );

        $stmt->execute([$name, $email, $password]);

        return  (int) $this->db->lastInsertId();
    }

    public function find(int $userId):array
    {
        $stmt = $this->db->prepare(
            'Select users.id, name, email
            from users where id = ?'
        );

        $stmt->execute([$userId]);

        $invoice = $stmt->fetch();
        var_dump($invoice);
        return $invoice ?: [];
    }
}