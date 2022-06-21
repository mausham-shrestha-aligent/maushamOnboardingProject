<?php require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<div style="align-items: center">
    <form action="/posts/update" method="post">
        <h1>Edit Post Page</h1>
        <div class="col-lg-6 offset-lg-3 col-md-4 offset-md-3">
            <div class="row justify-content-center">
                <div class="form-outline mb-4">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form4Example1">Title</label>
                        <input type="text" id="form4Example1" class="form-control" name="title"
                               value="<?php echo $this->params['title'] ?>"/>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form4Example3">Content of your posts goes here</label>
                        <textarea class="form-control" id="form4Example3" rows="4"
                                  name="body"><?php echo $this->params['body'] ?></textarea>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form4Example1">Title</label>
                        <input type="text" id="form4Example1" class="form-control" name="imageUrl"
                               value="<?php echo $this->params['imageUrl'] ?>"/>
                    </div>
                    <input type="hidden" name="post" value="<?= $this->params['id'] ?>"/>

                    <button type="submit" class="btn btn-primary btn-block mb-4">Confirm Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require_once ROOT_PATH . '/../app/Views/template/footer.php'; ?>
