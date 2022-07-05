
<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark" style="background: #17a2b8" >
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">
                    <i class="fa fa-home"></i>
                    Home
                    <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="/posts">
                    <i class="fa fa-bell">
                    </i>
                    Blog Feeds
                </a>
            </li>

        </ul>
        <div/>
        <div style="float: right; margin-right: 100px">
            <ul class="navbar-nav">
                <?php if (!getCurrentUserId()) : ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="/register">
                            <i class="fa-solid fa-address-card"></i>
                            Sign Up
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/login">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Login
                        </a>
                    </li>
                <?php else : ?>
                    <?php if(isAdmin()):?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/admin" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/comments">Monitor Comments</a>
                                <a class="dropdown-item" href="/admin">Admin Panel</a>
                                <a class="dropdown-item" href="/posts">User Posts</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/admin#register_user">Register User</a>
                            </div>
                        </li>
                    <?php endif?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout">Logout</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</nav>

