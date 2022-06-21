<?php
require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<?php
$userModel = new \App\Models\User();
$getRouteData = explode('?', $_SERVER['REQUEST_URI']);
if (sizeof($getRouteData) > 1) {
    $user = $userModel->getSearchedUser($getRouteData[1]);
}
?>

<?php if (empty($this->params)): ?>
    <div class="jumbotron text-center" style="margin-top: 100px">
        <h1 class="display-3">No comments</h1>
        <p class="lead">This user hasn't posted any comments</p>
        <hr>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="/admin" role="button">Continue to Admin page</a>
        </p>
    </div>
<?php else: ?>
    <main role="main" class="container">

        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="media text-muted pt-3">
                <?php foreach ($this->params as $comment): ?>
                    <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">@<?php echo $userModel->getSearchedUser($comment['user_id'])['name'] ?></strong>

                        <?php echo $comment['comment'] ?>
                    <div style="float: right">
                        <form style="display: inline-block" action="/admin-comments-delete" method="post">
                            <input type="hidden" name="commentId" value="<?php echo $comment['id'] ?>">
                            <button>Delete comment</button>
                        </form>
                        <?php if ($comment['visible'] == 0): ?>
                            <form style="display: inline-block" action="/admin-comments-approve" method="post">
                                <input type="hidden" name="commentId" value="<?php echo $comment['id'] ?>">
                                <button>Approve comment</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    </p>

                <?php endforeach; ?>
            </div>
            <h6 class="border-bottom border-gray pb-2 mb-0">All updates</h6>
        </div>
        </div>
    </main>

<?php endif; ?>