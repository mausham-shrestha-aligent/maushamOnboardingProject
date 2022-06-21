<?php require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>

<div class="container">
    <?php $urlInfo = explode('?', $_SERVER['REQUEST_URI']);
    if (count($urlInfo) > 1): ?>
    <?php $postModel = new \App\Models\Post();
    $posts = $postModel->getSingleUserPosts($urlInfo[1])
    ?>

    <div class="row">
        <div class="container blog-page">
            <div class="row clearfix d-flex justify-content-center ">
                <?php if (sizeof($posts) == 0): ?>
                    <div class="row">
                        <h1>This user hasn't posted yet</h1>
                    </div>
                <?php endif; ?>
                <?php foreach ($posts

                as $post): ?>

                <div class="col-lg-4 col-md-6 py-2">
                    <div class="card single_post ">
                        <div class="body">
                            <h3 class="m-t-0 m-b-5"><a><?= $post['title'] ?></a></h3>
                        </div>
                        <div class="body" style="margin: auto;align-content: center"

                        ">
                        <img style="width: 300px;height: 300px;" src="<?= $post['imageUrl'] ?>" alt="Awesome Image">
                        <?php if (getUserId() == $post['user_id'] || isAdmin()): ?>
                            <div><p><?= $post['body'] ?></p></div>
                            <form action="/posts/delete" method="POST">
                                <input type="hidden" name="post" value=<?= $post['id'] ?>>
                                <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"><a
                                            style="color: black;font-weight: bold" href="/singlepost?<?= $post['id'] ?>"
                                            title="read more" type="button">Do More</a></button>
                                <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"></a><a
                                            style="color: black;font-weight: bold"
                                            href="/posts/edit?<?= $post['id'] ?>">Edit</a></button>
                                <button type="submit" class="btn btn-danger btn-sm ml-1 shadow-none"
                                        style="font-weight: bold; float: right">
                                    Delete
                                </button>
                            </form>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php if (sizeof($this->params) > 1): ?>
    <div class="row">
        <h1>wanna see all posts?</h1>
        <p><a href="/posts"> click here</a></p>
    </div>
<?php endif; ?>



<?php else: ?>
    <?php if (sizeof($this->params) == 0): ?>
        <h1> Oops there are no posts posted yet. Click on Pencil icon to create new posts</h1>
    <?php endif; ?>

    <div class="container">
        <?= getSessionMsg() ?? '' ?>

        <div style="position: relative;bottom: 0;left: 0;margin: 5px">
            <a href="/posts/add" class="btn btn-info" style="height: 50px;width: 50px;align-content: center"><i
                        class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
        <div class="container blog-page">
            <div class="row clearfix d-flex justify-content-center ">
                <?php foreach ($this->params as $post): ?>
                <div class="col-lg-4 col-md-6 py-2">
                    <div class="card single_post ">
                        <div class="body">
                            <h3 class="m-t-0 m-b-5"><a><?= $post['title'] ?></a></h3>
                        </div>
                        <div class="body" style="margin: auto;align-content: center"
                        ">
                        <img style="width: 300px;height: 300px;" src="<?= $post['imageUrl'] ?>" alt="Awesome Image">
                        <form action="/posts/delete" method="POST">
                            <?php if (getUserId() == $post['id'] || isAdmin()): ?>
                                <div><p><?= $post['body'] ?></p></div>
                                <input type="hidden" name="post" value=<?= $post['postId'] ?>>

                                <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"><a
                                            style="color: black;font-weight: bold;text-decoration: none"
                                            href="/posts/edit?<?= $post['postId'] ?>">Edit</a></button>
                                <button class="btn btn-danger btn-sm ml-1 shadow-none" type="submit"
                                        style="font-weight: bold; float: right">
                                    Delete
                                </button>
                            <?php endif; ?>
                            <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"><a
                                        style="color: black;font-weight: bold;text-decoration: none"
                                        href="/singlepost?<?= $post['postId'] ?>"
                                        title="read more" type="button">Do More</a></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
<?php endif; ?>
</div>
