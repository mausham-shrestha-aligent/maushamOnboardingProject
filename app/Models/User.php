<?php

namespace App\Models;

class User extends Model
{
    const ACCESS_LEVEL_ADMIN = 1;
    const ACCESS_LEVEL_READ_ONLY = 2;
    const ACCESS_LEVEL_NORMAL = 3;

    public function create(string $name, string $email, string $password, string $userProfilePic): int
    {
        $stmt = $this->db->prepare(
            'Insert into users(name, email, password,userProfilePic) Values (?, ? ,?, ?)'
        );

        $stmt->execute([$name, $email, $password, $userProfilePic]);

        return (int)$this->db->lastInsertId();
    }

    public function find(int $userId): array
    {
        $stmt = $this->db->prepare('Select * from users where id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: [];
    }

    public function findUserByEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');

        $stmt->execute([$email]);
        $row = $stmt->rowCount();

        return $row > 0;
    }

    public function checkPassword(string $email, string $password)
    {
        $stmt = $this->db->prepare('SELECT * from users where email = ?');
        $stmt->execute([$email]);
        $userFetched = $stmt->fetch();
        if ($userFetched['password'] == $password) {
            return $userFetched;
        }
        return [];
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare('SELECT * from users');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSearchedUser($userDetail)
    {
        $stmt = $this->db->prepare('SELECT * from users where id = ? or email = ?');
        $stmt->execute([$userDetail, $userDetail]);
        return $stmt->fetch();
    }

    public function updateUserByAdmin($userUpdatedDetails)
    {
        $stmt = $this->db->prepare('UPDATE users SET name = ?, email=?, password=?, accessLevel=?, userProfilePic=?, created_at = now() where id = ?');
        $stmt->execute([$userUpdatedDetails['name'], $userUpdatedDetails['email'],
            $userUpdatedDetails['password'], $userUpdatedDetails['accessLevel'], $userUpdatedDetails['userProfilePic'], $userUpdatedDetails['userId']]);
        header('location: ' . 'http://localhost:8000/admin');
    }

    public function deleteUserByAdmin($userId)
    {
        //Preserving users info for future reference
        $_stmt = $this->db->prepare('INSERT INTO deletedUsers SELECT * FROM users where id = ?');
        $_stmt->execute([$userId]);
        //Preserving post from deleted users
        $__stmt = $this->db->prepare('INSERT INTO deletePosts SELECT * from posts where user_id = ?');
        $__stmt->execute([$userId]);
        //Preserving comments from deleted users
        $___stmt = $this->db->prepare('INSERT INTO deletedComments SELECT * FROM comments where user_id = ?');
        $___stmt->execute([$userId]);
        //Deleting user
        $stmt = $this->db->prepare('DELETE FROM users where id = ?');
        $stmt->execute([$userId]);
        return true;
    }
}