<?php require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<div style="min-width: 100%">
    <form action="/posts/submit" method="post" >
        <div class="col-lg-6 offset-lg-3 col-md-4 offset-md-3">
            <div class="row justify-content-center">
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
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Post</button><div class="row justify-content-center">
    </form>
</div>
