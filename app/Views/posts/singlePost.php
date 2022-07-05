<?php
require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<?php
$postModel = new \App\Models\Post();
$post = $postModel->getSinglePosts(explode('?', $_SERVER['REQUEST_URI'])[1]);
?>
<div>
    <div class="container my-5">
        <div class="d-flex justify-content-left row">
            <div class="col-md-7">
                <div class="d-flex flex-column comment-section" style="align-content: center">
                    <div class="p-2">
                        <div class="d-flex flex-column justify-content-start ml-2"><span
                                    class="d-block font-weight-bold name"><?= $post['name'] ?></span><span
                                    class="date text-black-50">Shared <?= $post['postCreated'] ?> </span></div>
                        <div>
                            <img width="500px" height="250px" src="<?= $post['imageUrl'] ?>">
                        </div>
                        <div class="mt-2">
                            <p class="comment-text"><?= $post['body'] ?></p>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="d-flex flex-row fs-12">
                            <?php $id = strval($post['postId']) ?>
                            <div class="like p-2 cursor">
                                <button onclick="showCommentSection(<?= $id ?>)" class="btn btn-primary pull-right">
                                    <i
                                            class="fa fa-commenting-o"></i><span class="ml-1"> Comment</span>
                                </button>
                            </div>
                        </div>
                        <form method="post" action="/comments">
                            <div class="bg-light p-2" style="display: none" id="<?= $post['postId'] ?>">
                                <input type="hidden" name="postId" value="<?= $post['postId'] ?>">
                                <div class="d-flex flex-row align-items-start"><textarea
                                            class="form-control ml-1 shadow-none textarea"
                                            name="comment"></textarea>
                                </div>
                                <div class="mt-2 text-right">
                                    <button class="btn btn-primary btn-sm shadow-none" type="submit">Post comment
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button"
                                            onclick="cancelCommentSection(<?= $id ?>)">Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php if ($postModel->getCommentPosts($post['postId'])): ?>
                            <section class="gradient-custom">
                                <div class="container py-3">
                                    <div class="row d-flex justify-content-right">
                                        <div class="col-md-12 col-lg-10 col-xl-8">
                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <div class="row">
                                                        <?php foreach ($postModel->getCommentPosts($post['postId']) as $comment): ?>
                                                        <?php if ($comment['visible'] == 1): ?>
                                                        <div class="col" style="margin-top: 20px">
                                                            <div class="d-flex flex-start">
                                                                <img class="rounded-circle shadow-1-strong me-3"
                                                                     src="  <?php echo $comment['userProfilePic'] ?>"
                                                                     alt="avatar"
                                                                     width="45"
                                                                     height="45"/>
                                                                <div class="flex-grow-1 flex-shrink-1">
                                                                    <div>
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <strong>
                                                                                <p class="mb-1"><?php echo $comment['name'] ?></p>
                                                                            </strong>
                                                                        </div>
                                                                        <p class="small mb-0">
                                                                            <?php echo $comment['comment']; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php else: ?>
                                                            <div class="col" style="margin-top: 10px">
                                                                <div class="d-flex flex-start">
                                                                    <div class="flex-grow-1 flex-shrink-1">
                                                                        <div>
                                                                            <p class="small mb-0">
                                                                                ->This comment is under review, it will
                                                                                be shown once it gets approved from
                                                                                admin
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>


                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </section>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
