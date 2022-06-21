<?php
require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<?php $postModel = new \App\Models\Post(); ?>


<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">Share your Story</h1>
        <p class="lead font-weight-normal">You can view the posts below. For sharing the story, you must have an
            account. Click on get started to create an account if you haven't already but if you have an account, start
            your blogging</p>
        <a class="btn btn-outline-secondary active" href="/posts" style="background-color: black">Get Started</a>
    </div>
    <div class="product-device box-shadow d-none d-md-block"></div>
    <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
</div>


<main class="container">
    <div class="row mb-2">
        <?php foreach ($this->params as $post): ?>
            <div class="col-md-6">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary"><?= $post['name'] ?></strong>
                        <div class="mb-1 text-muted"><?= $post['postCreated'] ?></div>
                        <h6 class="mb-0"><?= $post['title'] ?></h6>
                        <hr>
                        <p class="card-text mb-center">This is a wider card with supporting text below as a natural
                            lead-in to additional content.</p>
                        <a href="/singlepost?<?= $post['postId']?>" style="background-color: black">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img class="bd-placeholder-img" width="200" height="250" src="<?= $post['imageUrl'] ?>"
                             role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                             focusable="false"/>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                About this blog website
            </h3>

            <article class="blog-post">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Type of User</th>
                        <th>Their capabilities</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Admin</td>
                        <td>
                            Can Delete every posts<br>
                            Can Reset Password for all users accounts<br>
                            Can Assign users as admin
                        </td>
                    </tr>
                    <tr>
                        <td>Logged In users</td>
                        <td>
                            Can Delete their own posts<br>
                            Can Edit their own posts <br>
                            Can Post, Comment
                        </td>
                    </tr>
                    <tr>
                        <td>Guest Users</td>
                        <td>
                            Can create their account<br>
                            Can See the posts
                        </td>
                    </tr>
                    </tbody>
                </table>
            </article>

            <article class="blog-post">

        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4">
                    <h4>Find me on</h4>
                    <ol class="list-unstyled">
                        <li><a href="https://github.com/mausham02" target="_blank" style="color: black">GitHub</a></li>
                        <li><a href="https://twitter.com/mausham_01" target="_blank" style="color: black">Twitter</a></li>
                        <li><a href="https://linkedin.com/in/mausham161" target="_blank" style="color: black">LinkedIn</a></li>
                    </ol>
                </div>
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0">This is a blog website created by Mausham Shrestha as a part of his onboarding
                        project</p>
                </div>
            </div>
        </div>
    </div>

</main>


<?php require_once ROOT_PATH . '/../app/Views/template/footer.php'; ?>



