<?php

namespace App\Models;

class User extends Model {

    const ACCESS_LEVEL_ADMIN = 1;
    const ACCESS_LEVEL_READ_ONLY = 2;
    const ACCESS_LEVEL_NORMAL = 3;

    public function create(string $name, string $email, string $password, string $userProfilePic) : int {
        $stmt = $this->db->prepare(
            'Insert into users(name, email, password,userProfilePic) Values (?, ? ,?, ?)'
        );

        $stmt->execute([$name, $email, $password, $userProfilePic]);

        return  (int) $this->db->lastInsertId();
    }

    public function find(int $userId):array
    {
        $stmt = $this->db->prepare(
            'Select *
            from users where id = ?'
        );

        $stmt->execute([$userId]);


        $user = $stmt->fetch();

        return $user ?: [];
    }

    public function findUserByEmail(string $email):bool
    {
        $stmt= $this->db->prepare('SELECT * FROM users WHERE email = ?');

        $stmt->execute([$email]);
        $row = $stmt->rowCount();

        return $row > 0;
    }

    public function checkPassword(string $email, string $password)
    {
        $stmt = $this->db->prepare('SELECT * from users where email = ?');

        $stmt->execute([$email]);

        $userFetched = $stmt->fetch();

        if($userFetched['password'] == $password) {
            return $userFetched;
        }

        return [];

    }
}