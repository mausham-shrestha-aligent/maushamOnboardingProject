<?php require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>

<div class="container">
    <?php if (count(explode('?', $_SERVER['REQUEST_URI'])) > 1): ?>
        <div class="row">
            <h1>Post has been deleted</h1>
            <p>Go to Posts <a href="/posts"> click here</a></p>
        </div>

    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>
        <div>
            <a href="/posts/add" class="btn btn-primary pull-right">Add Posts</a>
        </div>
    </div>
    <div class="container">
        <?= getSessionMsg() ?? '' ?>
        <div class="row">
            <?php foreach ($this->params as $post): ?>
                <div class="d-flex justify-content-center row">
                    <div class="col-md-8">
                        <div class="d-flex flex-column comment-section">
                            <div class="bg-white p-2">
                                <div class="d-flex flex-column justify-content-start ml-2"><span
                                            class="d-block font-weight-bold name"><?= $post['title'] ?></span><span
                                            class="date text-black-50"><?= $post['postCreated'] ?></span></div>
                            </div>
                            <div class="mt-2">
                                <p class="comment-text"><?= $post['body'] ?></p>
                            </div>
                        </div>
                        <?php if (getUserId() == $post['id'] || isAdmin()): ?>
                            <div class="bg-light p-2">
                                <form action="/posts/delete" method="POST">
                                    <input type="hidden" name="post" value=<?= $post['postId'] ?>>

                                    <div class="mt-2 text-right">
                                        <button class="btn btn-outline-danger btn-sm ml-1 shadow-none" type="submit">
                                            Delete
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-2 text-left">
                                    <a class="btn btn-primary btn-sm shadow-none"
                                       href="/posts/edit?<?= $post['postId'] ?>">Edit</a>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <?php require_once ROOT_PATH . '/../app/Views/inc/footer.php'; ?>
