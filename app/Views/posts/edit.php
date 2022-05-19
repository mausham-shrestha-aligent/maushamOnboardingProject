
<?php require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>
<div>
    <h1>Edit Post Page</h1>
    <form action="/posts/update" method="post">
        <div class="form-outline mb-4">
            <label class="form-label" for="form4Example1">Title</label>
            <input type="text" id="form4Example1" class="form-control" name="title" value="<?php echo $this->params['title']?>" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form4Example3" >Content of your posts goes here</label>
            <textarea class="form-control" id="form4Example3" rows="4" name="body"><?php echo $this->params['body']?></textarea>
        </div>
        <input type="hidden" name="post" value="<?= $this->params['id'] ?>"/>

        <button type="submit" class="btn btn-primary btn-block mb-4">Confirm Changes</button>
    </form>
</div>

<?php require_once ROOT_PATH . '/../app/Views/inc/footer.php'; ?>
