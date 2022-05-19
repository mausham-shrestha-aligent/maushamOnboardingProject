<?php
require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>
<?php
$postModel = new \App\Models\Post();
?>

<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
        <h1 class="display-4 font-italic">Create a blog.</h1>
        <p class="lead my-3">
            Share your story with the world.
        </p>
        <button><a href="/posts">Get Started</a></button>
    </div>
</div>

<h3 class="pb-3 mb-4 font-italic border-bottom">
    Recent Posts
</h3>


<?php foreach ($this->params as $post): ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-left row">
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <div class="bg-white p-2">
                        <div class="d-flex flex-column justify-content-start ml-2"><span
                                    class="d-block font-weight-bold name"><?= $post['name'] ?></span><span
                                    class="date text-black-50">Shared <?= $post['postCreated'] ?> </span></div>
                        <div class="mt-2">
                            <p class="comment-text"><?= $post['body'] ?></p>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="d-flex flex-row fs-12">
                            <?php $id = strval($post['id']) ?>
                            <div class="like p-2 cursor"><i class="fa fa-thumbs-o-up"></i><span class="ml-1">Like</span>
                            </div>
                            <div class="like p-2 cursor">
                                <button onclick="showCommentSection(<?= $id ?>)"
                                "><i class="fa fa-commenting-o"></i><span class="ml-1">Comment</span></button></div>
                        </div>
                        <?php foreach ($postModel->getCommentPosts($post['postId']) as $comment): ?>
                            <p><i><?php echo '****     ' . $comment['comment']; ?></i></p>
                        <?php endforeach; ?>
                    </div>
                    <form method="post" action="/comments">
                        <div class="bg-light p-2" style="display: none" id="<?= $post['id'] ?>">
                            <input type="hidden" name="postId" value="<?= $post['postId'] ?>">
                            <div class="d-flex flex-row align-items-start"><textarea
                                        class="form-control ml-1 shadow-none textarea" name="comment"></textarea></div>
                            <div class="mt-2 text-right">
                                <button class="btn btn-primary btn-sm shadow-none" type="submit">Post comment</button>
                                <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"
                                        onclick="cancelCommentSection(<?= $id ?>)">Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php require_once ROOT_PATH . '/../app/Views/inc/footer.php'; ?>


