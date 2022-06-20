<?php require_once ROOT_PATH . '/../app/Views/template/header.php'; ?>
<?php
$allData = [
    'posts' => (new \App\Models\Post())->getPosts(),
    'users' => (new \App\Models\User())->getAllUsers()
];
?>
<form action="/admin" method="post">
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Actions</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Enter User email to search"
               aria-label="Search" name="search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <input type="submit" value="submit"/>
            </li>
        </ul>
    </nav>
</form>


<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/posts">
                            <span data-feather="home"></span>
                            User Posts<span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file"></span>
                            Delete Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="shopping-cart"></span>
                            Monitor comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Update User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            TO DO
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
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Deleted Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Deleted Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Deleted Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            TO DO
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                require_once ROOT_PATH . '/../app/Views/Admin/singleUser.php';
            }
            ?>
            <h2>User Detail</h2>
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
                                <a href="<?php echo $user['userProfilePic'] ?>"><?php echo $user['userProfilePic'] ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>