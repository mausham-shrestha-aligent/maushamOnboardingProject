<nav class="navbar site-header sticky-top py-1" style="background: #17a2b8">
    <div class="container d-flex flex-column flex-md-row justify-content-between text-white">
        <?php if (!getUserId()) : ?>
            <a class="nav-link text-white" href="/">Home</a>
            <a class="nav-link text-white" href="/login">Login</a>
            <a class="nav-link text-white" href="/register">Register</a>
        <?php else : ?>
        <?php if(isAdmin()):?>
            <a class="nav-link text-white" href="/admin">Admin</a>
        <?php endif?>
            <a class="nav-link text-white" href="/">Home</a>
            <a class="nav-link text-white" href="/posts">Feeds</a>
            <a class="nav-link" href="/logout">Log Out</a>
        <?php endif; ?>
    </div>
</nav>


