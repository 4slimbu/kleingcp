<header class="bg-light shadow-sm">
    <div class="container-xxxl">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="/"><?php echo config('app_name'); ?></a>

            <div class="ms-auto">
                <!-- Check if user is logged in -->
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="d-flex align-items-center">
                        <span class="me-3">Hello, <?php echo $_SESSION['username']; ?></span>
                        <a href="/logout" class="btn btn-outline-secondary">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<div class="container-xxxl mt-2">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>
