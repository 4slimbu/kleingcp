<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <?php if ($favicon_path): ?>
        <link rel="apple-touch-icon" href="<?php echo $favicon_path; ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="/style.css" />

    <?php if ($extra_css_path): ?>
        <link rel="stylesheet" href="<?php echo $extra_css_path; ?>" />
    <?php endif; ?>
</head>

<body>
    <div class="main-wrapper">
        <?php if (!$hide_header): ?>
            <?php include_once $header_path; ?>
        <?php endif; ?>

        <div class="container-xxxl main-content">
            <?php include_once $content_path; ?>
        </div>

        <?php if (!$hide_footer): ?>
            <?php include_once $footer_path; ?>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
