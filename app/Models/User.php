<?php

namespace App\Models;

use App\Exceptions\AdminSearchUserException;
use App\Exceptions\IdenticalUserException;
use App\Exceptions\PasswordIncorrectException;
use Exception;
use JetBrains\PhpStorm\Pure;

class User extends Model
{
    const ACCESS_LEVEL_ADMIN = 1;

    #[Pure] public function __construct()
    {
        parent::__construct();
    }

    /**
     * This function creates the new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $userProfilePic
     * @return int
     */
    public function create(string $name, string $email, string $password, string $userProfilePic): int
    {
        $stmt = $this->db->prepare(
            'Insert into users(name, email, password,userProfilePic) Values (?, ? ,?, ?)'
        );
        $stmt->execute([$name, $email, $password, $userProfilePic]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @throws IdenticalUserException
     */
    public function find(int $userId): array
    {
        try {
            $stmt = $this->db->prepare('Select * from users where id = ?');
            $stmt->execute([$userId]);
            return $stmt->fetch() ?: [];
        } catch (Exception $e) {
            throw new IdenticalUserException($e->getMessage());
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    public function findUserByEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->rowCount();

        return $row > 0;
    }

    /**
     * Checking if the password matched to the already stored password in the database
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws PasswordIncorrectException
     */
    public function checkPassword(string $email, string $password)
    {
        $stmt = $this->db->prepare('SELECT * from users where email = ?');
        $stmt->execute([$email]);
        $userFetched = $stmt->fetch();
        if ($userFetched['password'] == $password) {
            return $userFetched;
        } else {
            throw new PasswordIncorrectException("The password is incorrect, please try again");
        }
    }

    /**
     * @return array|false
     * Used in admin page to fetch all the users
     */
    public function getAllUsers(): bool|array
    {
        $stmt = $this->db->prepare('SELECT * from users');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @throws Exception
     * Used in admin page to fetch the user details based on the search id or email posted by the admin
     */
    public function getSearchedUser($userDetail)
    {
        $stmt = $this->db->prepare('SELECT * from users where id = ? or email = ?');
        $stmt->execute([$userDetail, $userDetail]);
        $result = $stmt->fetch();

        if (is_bool($result)) {
            throw new AdminSearchUserException('Couldn\'t find any user with that id');
        } else return $result;
    }

    /**
     * @param $userUpdatedDetails
     * @return void
     * Updating the user details posted by admin
     */
    public function updateUserByAdmin($userUpdatedDetails)
    {
        $stmt = $this->db->prepare('UPDATE users SET name = ?, email=?, password=?, accessLevel=?, userProfilePic=?, created_at = now() where id = ?');
        $stmt->execute([$userUpdatedDetails['name'], $userUpdatedDetails['email'],
            $userUpdatedDetails['password'], $userUpdatedDetails['accessLevel'], $userUpdatedDetails['userProfilePic'], $userUpdatedDetails['userId']]);
        header('location: ' . 'http://localhost:8000/admin');
    }

    /**
     * @param $userId
     * @return bool
     * Deleting the user by admin
     */
    public function deleteUserByAdmin($userId): bool
    {
        //Preserving users info for future reference
        $_stmt = $this->db->prepare('INSERT INTO deletedUsers(id, name, email, password, accessLevel, userProfilePic, deleted_at) 
                                        SELECT id, name, email, password, accessLevel, userProfilePic, Now() FROM users where id = ?');
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

    // Getting the deleted users to be displayed in the admin page
    public function getDeletedUsers()
    {
        $stmt = $this->db->prepare('SELECT * from deletedUsers');
        $stmt->execute();
        $results = $stmt->fetchAll();
        return is_bool($results) ? [] : $results;
    }

    /** only used for test purpose */
    public function deleteUserByEmail($email)
    {
        $stmt = $this->db->prepare('DELETE FROM users where email = ?');
        $stmt->execute([$email]);
    }
}