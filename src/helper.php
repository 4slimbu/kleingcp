<?php

function env($key, $default = null)
{
    return $_ENV[$key] ?? $default;
}

function config($key, $default = null)
{
    // Load the config array
    $config = require ROOT_DIR . '/src/config.php';

    // Split the key by '.' to navigate through the array
    $keys = explode('.', $key);
    $value = $config;

    // Traverse the array according to the keys
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default; // Return default if key doesn't exist
        }
    }

    return $value; // Return the found value
}


function getRequestPath()
{
    // Parse the URL and get the path component
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Trim any leading or trailing slashes
    return trim($urlPath, '/');
}

function serveStaticFiles($requestPath)
{
    // Define an array of file extensions to exclude
    $excludedExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg'];

    // Get the request extension
    $extension = pathinfo($requestPath, PATHINFO_EXTENSION);

    // Check if the request is for an excluded file type
    if (empty($requestPath) || !in_array($extension, $excludedExtensions)) {
    } else {
        // Serve static files directly
        // This can include using `readfile()` or serving files based on your directory structure
        $filePath = ROOT_DIR . '/public_html/' . $requestPath;

        if (file_exists($filePath)) {
            // Set appropriate headers for the file type
            switch ($extension) {
                case 'css':
                    header('Content-Type: text/css');
                    break;
                case 'js':
                    header('Content-Type: application/javascript');
                    break;
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'svg':
                    header('Content-Type: image/' . $extension);
                    break;
            }

            // Serve the file
            readfile($filePath);
            exit; // Stop further processing
        } else {
            // Handle 404 Not Found
            header("Location: /not_found");
        }
    }
}

function process($path)
{
    require ROOT_DIR . $path;
}

function render($path, $opts = [])
{
    $title = isset($opts['title']) ? $opts['title'] . ' | ' . config('app_name') : config('app_name');
    $favicon_path = isset($opts['favicon_path']) ? $opts['favicon_path'] : null;
    $extra_css_path = isset($opts['extra_css_path']) ? $opts['extra_css_path'] : null;
    $header_path = isset($opts['header_path']) ? ROOT_DIR . $opts['header_path'] : ROOT_DIR . '/templates/header.php';
    $content_path = ROOT_DIR . $path;
    $footer_path = isset($opts['footer_path']) ? ROOT_DIR . $opts['footer_path'] : ROOT_DIR . '/templates/footer.php';
    $hide_header = isset($opts['hide_header']) ? $opts['hide_header'] : false;
    $hide_footer = isset($opts['hide_footer']) ? $opts['hide_footer'] : false;

    require ROOT_DIR . '/templates/main.php';
}
