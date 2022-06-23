<?php

namespace App\Models;

use App\Views\View;
use Exception;

class Post extends Model
{
    /**
     * Helps get all the post
     * @return array|false
     */
    public function getPosts()
    {
        $stmt = $this->db->prepare(
            'SELECT * , posts.id as postId, users.id as userId,
            posts.created_at as postCreated, users.created_at as userCreated
            from posts inner join users
            on posts.user_id = users.id
            order by posts.created_at DESC'
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Submit the new post.. If failed throws Exception
     * @throws Exception
     */
    public function submitPost(array $data)
    {
        try {
            $stmt = $this->db->prepare(
                'Insert into posts(user_id, title, body,imageUrl) values (?, ?, ?,?)'
            );
            $stmt->execute([$data['user_id'], $data['title'], $data['body'], $data['imageUrl']]);
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $params = [
                'error' => "Cannot post because the blog body has more than 75 characters"
            ];
            echo View::make('exceptionsViews/blogBodyLimitError', $params);
        }
    }

    /**
     * This function deletes post
     * @param int $postId
     * @return void
     * @throws Exception
     */
    public function deletePost(int $postId)
    {
        if ($this->checkIfBeingHacked($postId)) {
            throw new Exception('Cannot Delete post');
        }

        $_stmt = $this->db->prepare('insert into deletePosts select * from posts where id = ?');
        $_stmt->execute([$postId]);
        $__stmt = $this->db->prepare('insert into deletedComments select * from comments where post_id = ?');
        $__stmt->execute([$postId]);

        $stmt = $this->db->prepare('DELETE FROM posts where id = ?');
        $stmt->execute([$postId]);

        $_SESSION['session_msg'] = 'The post has been deleted';
        header('location:' . 'http://localhost:8000/posts');
    }

    /**
     * This function send the helps present the editable version of their published post
     * @param $postId
     * @return View
     */
    public function editPost($postId): View
    {
        $stmt = $this->db->prepare(
            'Select id, title, body, imageUrl from posts where id=?'
        );
        $stmt->execute([$postId]);


        $result = $stmt->fetch();

        return View::make('posts/edit', $result);
    }

    /**
     * This will update post
     * @param $postId
     * @return void
     * @throws Exception
     */
    public function updatePost($postId)
    {
        if ($this->checkIfBeingHacked($postId)) {
            throw new Exception('Cannot update post');
        }
        $stmt = $this->db->prepare(
            'UPDATE posts SET title=?, body=?, imageUrl = ? where id=?'
        );
        $stmt->execute([$_POST['title'], $_POST['body'], $_POST['imageUrl'], $postId]);
        $_SESSION['session_msg'] = "The post has been updated";
        header('location: ' . 'http://localhost:8000/posts');

    }

    /**
     * This function is for commenting on posts
     * @param array $array
     * @return void
     */
    public function commentPost(array $array)
    {
        try {
            $stmt = $this->db->prepare(
                'Insert into comments(comment, user_id, post_id) values (?,?,?)'
            );
            $stmt->execute([$array[0], $array[1], $array[2]]);
            $_SESSION['session_msg'] = "The comment has been posted";
            header('location: ' . 'http://localhost:8000/');
        } catch (Exception $e) {
            $params = [
                'error' => $e->getMessage()
            ];
            echo View::make('exceptionsViews/commentLimitError', $params);
        }

    }

    /**
     * This function gets single post so that users can comment
     * @param $postId
     * @return mixed
     */
    public function getSinglePosts($postId)
    {
        $stmt = $this->db->prepare(
            'select posts.id as postId, users.id as userId,
       body, title, posts.created_at as postCreated,users.created_at as userCreated, imageUrl, userProfilePic, name
from posts inner join users on posts.user_id = users.id where posts.id = ?'
        );
        $stmt->execute([$postId]);
        return $stmt->fetch();
    }

    /**
     * This function helps to get all the comments for the particular posts
     * @param $postId
     * @return array|false
     */
    public function getCommentPosts($postId)
    {
        $stmt = $this->db->prepare(
            'Select * from comments inner join users on users.id = comments.user_id where post_id = ?'
        );
        $stmt->execute([$postId]);
        $results = $stmt->fetchAll();
        return $results = is_bool($results) ? [] : $results;
    }

    /**
     * This is for preventing SQL injection where user can edit someone else posts
     * @param $postId
     * @return bool
     */
    public function checkIfBeingHacked($postId): bool
    {
        $stmt = $this->db->prepare('SELECT user_id from posts where id=?');
        $stmt->execute([$postId]);
        $userId = $stmt->fetch()['user_id'];
        if (!isAdmin() && $userId != getUserId()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function helps to return comments from all the users or particular users
     * @return bool|array
     */
    public function getAllCommentsOrSingleComments(): bool|array
    {
        $getRouteData = explode('?', $_SERVER['REQUEST_URI']);
        if (sizeof($getRouteData) > 1) {
            $stmt = $this->db->prepare('SELECT * from comments where user_id = ?');
            $stmt->execute([$getRouteData[1]]);
        } else {
            $stmt = $this->db->prepare('SELECT * from comments');
            $stmt->execute();
        }
        $results = $stmt->fetchAll();
        return is_bool($results) ? [] : $results;
    }

    /**
     * This function helps to retrieve all the deleted comments from the database
     * @param mixed $commentId
     * @return bool
     */
    public function deleteComments(mixed $commentId): bool
    {
        $_stmt = $this->db->prepare('insert into deletedComments select * from comments where id = ?');
        $_stmt->execute([$commentId]);
        $stmt = $this->db->prepare('DELETE FROM comments where id = ?');
        $stmt->execute([$commentId]);
        return true;
    }

    /**
     * This function helps admin approve the comments from the users
     * @param mixed $commentId
     * @return bool
     */
    public function approveComments(mixed $commentId): bool
    {
        $stmt = $this->db->prepare('UPDATE comments set visible = 1 where id = ?');
        $stmt->execute([$commentId]);
        return true;
    }

    /** Gets the post from single user */
    public function getSingleUserPosts($userId): bool|array
    {
        $stmt = $this->db->prepare('SELECT * from posts where user_id = ?');
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll();
        return is_bool($results) ? [] : $results;
    }

    /** gets all the deleted posts */
    public function getDeletedPosts(): bool|array
    {
        $stmt = $this->db->prepare('SELECT * from deletePosts');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return is_bool($result) ? [] : $result;
    }

    /** Get all the deleted comments */
    public function getDeletedComments()
    {
        $stmt = $this->db->prepare('SELECT * from deletedComments');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return is_bool($result) ? [] : $result;
    }

    /** Deletes the post of a particular user
     * Used only for test purpose
     */
    public function deletePostByUserId(int $userId)
    {
        $stmt = $this->db->prepare('DELETE * from POSTS where user_id = ?');
        $stmt->execute([$userId]);
    }

}