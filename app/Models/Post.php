<?php

namespace App\Models;

use App\Views\View;

class Post extends Model
{
    public function create(): int
    {
        return 0;
    }

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

    public function submitPost(array $data)
    {
        $stmt = $this->db->prepare(
            'Insert into posts(user_id, title, body,imageUrl) values (?, ?, ?,?)'
        );

        $stmt->execute([$data['user_id'], $data['title'], $data['body'], $data['imageUrl']]);

        header('location:' . 'http://localhost:8000/posts');
    }

    public function deletePost(int $postId)
    {
        if ($this->checkIfBeingHacked($postId)) {
            throw new \Exception('Cannot Delete post');
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

    public function editPost($postId): View
    {
        $stmt = $this->db->prepare(
            'Select id, title, body, imageUrl from posts where id=?'
        );
        $stmt->execute([$postId]);


        $result = $stmt->fetch();

        return View::make('posts/edit', $result);
    }

    public function updatePost($postId)
    {
        if ($this->checkIfBeingHacked($postId)) {
            throw new \Exception('Cannot update post');
        }
        $stmt = $this->db->prepare(
            'UPDATE posts SET title=?, body=?, imageUrl = ? where id=?'
        );
        $stmt->execute([$_POST['title'], $_POST['body'], $_POST['imageUrl'],$postId]);
        $_SESSION['session_msg'] = "The post has been updated";
        header('location: ' . 'http://localhost:8000/posts');

    }

    public function commentPost(array $array)
    {
        $stmt = $this->db->prepare(
            'Insert into comments(comment, user_id, post_id) values (?,?,?)'
        );
        $stmt->execute([$array[0], $array[1], $array[2]]);
        $_SESSION['session_msg'] = "The comment has been posted";
        header('location: ' . 'http://localhost:8000/');
    }

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

    public function deleteComments(mixed $commentId): bool
    {
        $_stmt = $this->db->prepare('insert into deletedComments select * from comments where id = ?');
        $_stmt->execute([$commentId]);
        $stmt = $this->db->prepare('DELETE FROM comments where id = ?');
        $stmt->execute([$commentId]);
        return true;
    }

    public function approveComments(mixed $commentId): bool
    {
        $stmt = $this->db->prepare('UPDATE comments set visible = 1 where id = ?');
        $stmt->execute([$commentId]);
        return true;
    }

    public function getSingleUserPosts($userId)
    {
        $stmt = $this->db->prepare('SELECT * from posts where user_id = ?');
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll();
        return is_bool($results) ? [] : $results;
    }

    public function getDeletedPosts()
    {
        $stmt = $this->db->prepare('SELECT * from deletePosts');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return is_bool($result) ? [] : $result;
    }

    public function getDeletedComments()
    {
        $stmt = $this->db->prepare('SELECT * from deletedComments');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return is_bool($result) ? [] : $result;
    }

}