<?php require_once ROOT_PATH . '/../app/Views/inc/header.php'; ?>
<form action="/posts/submit" method="post">
    <div class="form-outline mb-4">
        <label class="form-label" for="form4Example1">Title</label>
        <input type="text" id="form4Example1" class="form-control" name="title"/>
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="form4Example3">Content of your posts goes here</label>
        <textarea class="form-control" id="form4Example3" rows="4" name="body"></textarea>
    </div>
    <div class="form-outline mb-4">
        <label class="form-label" for="form4Example3">Enter Image URL</label>
        <input type="text" id="form4Example1" class="form-control" name="imageUrl"/>
    </div>
    <button type="submit" class="btn btn-primary btn-block mb-4">Post</button>
</form>
<?php require_once ROOT_PATH . '/../app/Views/inc/footer.php'; ?>
