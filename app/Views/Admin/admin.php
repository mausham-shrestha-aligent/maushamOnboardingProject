<?php require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<?php
$allData = [
    'posts' => (new \App\Models\Post())->getPosts(),
    'users' => (new \App\Models\User())->getAllUsers()
];
?>



<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="position: fixed;">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" style="color: black" href="/posts">
                            <span data-feather="home"></span>
                            User Posts<span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black" href="/comments">
                            <span data-feather="shopping-cart"></span>
                            Monitor comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black" href="/admin#register_user">
                            <span data-feather="shopping-cart"></span>
                            Add Users
                        </a>
                    </li>

                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" style="color: black" href="/admin#all_users">
                            <span data-feather="file-text"></span>
                            All Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black""
                         href="/admin#deleted_comments">
                            <span data-feather="file-text"></span>
                            Deleted Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black" href="/admin#deleted_posts">
                            <span data-feather="file-text"></span>
                            Deleted Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black; " href="/admin#deleted_users">
                            <span data-feather="file-text"></span>
                            Deleted Users
                        </a>
                    </li>
                </ul>
            </div>
        </nav>


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

            <form action="/admin" method="post" class="form-inline"  style="float: right">
                <input  class="form-control mr-sm-2" type="email" id="email" placeholder="Enter email" name="search" width="100%">
                <button type="submit" class="btn btn-primary my-2 my-sm-0" value="submit" style="margin-right: 0px">Submit</button>
            </form>
            <?php
            $postModel = new \App\Models\Post();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                require_once ROOT_PATH . '/../app/Views/Admin/singleUser.php';
            }
            ?>
            <div id="all_user">
                <?php if ($_SESSION != null && array_key_exists('message', $_SESSION) && $_SESSION['message'] != ''): ?>
                    <p><?php echo $_SESSION['message'];
                        $_SESSION['message'] = ''; ?></p>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Created</th>
                            <th>Profile Pic Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($allData['users'] as $user): ?>
                            <tr>
                                <td><?php echo $user['id'] ?></td>
                                <td><?php echo $user['name'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $user['created_at'] ?></td>
                                <td>
                                    <a href="<?php echo $user['userProfilePic'] ?>" target="_blank">Click to view</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="deleted_posts">
                <h2>Deleted posts</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Post ID</th>
                            <th>User ID</th>
                            <th>Title</th>
                            <th>Body of Posts</th>
                            <th>Deleted On</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $deletedPosts = $postModel->getDeletedPosts();
                        ?>
                        <?php foreach ($deletedPosts as $deletedPost): ?>
                            <tr>
                                <td><?php echo $deletedPost['id'] ?></td>
                                <td><?php echo $deletedPost['user_id'] ?></td>
                                <td><?php echo $deletedPost['title'] ?></td>
                                <td><?php echo $deletedPost['body'] ?></td>
                                <td><?php echo $deletedPost['deleted_at'] ?></td>
                                <td>
                                    <a href="<?php echo $deletedPost['imageUrl'] ?>" target="_blank">Click to view</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="deleted_comments">
                <h2>Deleted Comments</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Comment ID</th>
                            <th>Comment</th>
                            <th>User ID</th>
                            <th>Post ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $deletedComments = $postModel->getDeletedComments();
                        ?>
                        <?php foreach ($deletedComments as $deletedComment): ?>
                            <tr>
                                <td><?php echo $deletedComment['id'] ?></td>
                                <td><?php echo $deletedComment['comment'] ?></td>
                                <td><?php echo $deletedComment['user_id'] ?></td>
                                <td><?php echo $deletedComment['post_id'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="deleted_users">
                <h2>Deleted Users</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Deleted On</th>
                            <th>Access Level</th>
                            <th>User Profile Pic</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $userModel = new \App\Models\User();
                        $deletedUsers = $userModel->getDeletedUsers();
                        ?>
                        <?php foreach ($deletedUsers as $deletedUser): ?>
                            <tr>
                                <td><?php echo $deletedUser['id'] ?></td>
                                <td><?php echo $deletedUser['name'] ?></td>
                                <td><?php echo $deletedUser['email'] ?></td>
                                <td><?php echo $deletedUser['deleted_at'] ?></td>
                                <td><?php $accessLevel = $deletedUser['accessLevel'] == 0 ? 'user' : 'Admin';
                                    echo $accessLevel ?></td>
                                <td><a href = "<?php echo $deletedUser['userProfilePic']?>" target="_blank">Click to view</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>
            <div id="register_user">
                <?php require_once ROOT_PATH . '/../app/Views/signupTemplate.php' ?>
            </div>
        </main>
    </div>
</div>
<?php require_once ROOT_PATH . '/../app/Views/template/footer.php'?>