<?php require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>

<div class="container">
    <?php if (count(explode('?', $_SERVER['REQUEST_URI'])) > 1): ?>
        <div class="row">
            <h1>Post has been deleted</h1>
            <p>Go to Posts <a href="/posts"> click here</a></p>
        </div>

    <?php endif; ?>

    <div class="container">
        <?= getSessionMsg() ?? '' ?>


        <div style="position: relative;bottom: 0;right: 0;padding: 50px;" >
            <a href="/posts/add" class="btn btn-round btn-info" style="height: 100px;width: 100px"><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
                <div class="container blog-page">
                    <div class="row clearfix">
                        <?php foreach ($this->params as $post): ?>
                        <div class="col-lg-4 col-md-12" >
                            <div class="card single_post">
                                <div class="body">
                                    <h3 class="m-t-0 m-b-5"><a><?= $post['title'] ?></a></h3>
                                </div>
                                <div class="body" style="margin: auto;align-content: center"">
                                    <img style="width: 350px;height: 300px;" src="<?= $post['imageUrl'] ?>" alt="Awesome Image">
                                    <?php if (getUserId() == $post['id'] || isAdmin()): ?>
                                    <div>  <p><?= $post['body'] ?></p></div>
                                        <form action="/posts/delete" method="POST">
                                            <input type="hidden" name="post" value=<?= $post['postId'] ?>>
                                                <button href="/singlepost?<?= $post['postId'] ?>" title="read more">Do More</button>
                                                <button type="submit">
                                                    Delete
                                                </button>
                                                <button
                                                   href="/posts/edit?<?= $post['postId'] ?>">Edit</button>
                                        </form>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>


        </div>
    </div>

    <?php require_once ROOT_PATH . '/../app/Views/inc/footer.php'; ?>
