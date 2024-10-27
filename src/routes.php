<?php

// Get the current request path
$requestPath = getRequestPath();

// ======= Serve static files ======= 
serveStaticFiles($requestPath);

// ======== Routes ======= 
switch ($requestPath) {
        // --------- Auth routes
    case '':
        render('/src/dashboard.php', ['title' => 'Dashboard']);
        break;
}
