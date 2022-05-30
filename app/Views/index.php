<?php
require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>
<?php
$postModel = new \App\Models\Post();
?>


<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">Share your Story</h1>
        <p class="lead font-weight-normal">You can view the posts below. For sharing the story, you must have an account. Click on get started to create an account if you haven't already but if you have an account, start your blogging</p>
        <a class="btn btn-outline-secondary" href="/posts">Get Started</a>
    </div>
    <div class="product-device box-shadow d-none d-md-block"></div>
    <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
</div>


<?php foreach ($this->params as $post): ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-left row">
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <div class="bg-white p-2">
                        <div class="d-flex flex-column justify-content-start ml-2"><span
                                    class="d-block font-weight-bold name"><?= $post['name'] ?></span><span
                                    class="date text-black-50">Shared <?= $post['postCreated'] ?> </span></div>
                        <div>
                            <img src="<?= $post['imageUrl']?>">
                        </div>
                        <div class="mt-2">
                            <p class="comment-text"><?= $post['body'] ?></p>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="d-flex flex-row fs-12">
                            <?php $id = strval($post['id']) ?>
                            <div class="like p-2 cursor"><button class="btn btn-primary pull-right"><i class="fa fa-thumbs-o-up"></i><span class="ml-1"> Like</span></button>
                            </div>
                            <div class="like p-2 cursor">
                                <button onclick="showCommentSection(<?= $id ?>)" class="btn btn-primary pull-right"><i class="fa fa-commenting-o"></i><span class="ml-1"> Comment</span></button></div>
                        </div>
                        <?php foreach ($postModel->getCommentPosts($post['postId']) as $comment): ?>

                            <div class="card">
                                <div class="card-body">
                                    <img class="rounded-circle" src="<?php echo $comment['userProfilePic'] ?>" width="40">
                                    <p><i><?php echo  $comment['comment']; ?></i></p>
                                </div>
                            </div>

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


