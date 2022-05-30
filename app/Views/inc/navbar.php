<nav class="navbar site-header sticky-top py-1 bg-dark">
    <div class="container d-flex flex-column flex-md-row justify-content-between text-white">
        <?php if (!getUserId()) : ?>
            <a class="nav-link text-white" href="/">Home</a>
            <a class="nav-link text-white" href="/login">Login</a>
            <a class="nav-link text-white" href="/register">Register</a>
            <a class="nav-link text-white" href="/posts">Feeds</a>
        <?php else : ?>

            <a class="nav-link" href="/logout">Log Out</a>
        <?php endif; ?>
    </div>
</nav>


