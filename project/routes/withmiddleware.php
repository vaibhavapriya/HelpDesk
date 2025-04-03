<?php

require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../middlewares.php'; // Include middleware

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    '/post' => ['handler' => 'showPostForm', 'middleware' => []],  // No middleware for viewing form
    '/post/store' => ['handler' => 'storePost', 'middleware' => ['authMiddleware', 'csrfMiddleware']] // Middleware applied
];

// Check if route exists
if (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];

    // Run middlewares
    foreach ($route['middleware'] as $middleware) {
        call_user_func($middleware);
    }

    // Call controller function
    call_user_func($route['handler']);
} else {
    http_response_code(404);
    echo "404 - Page Not Found";
}


?>
<!-- //withoutcontroller -->

<?php

$routes = [
    '/ticket' => 'TicketController@showForm',   // Show ticket submission form
    '/ticket/submit' => 'TicketController@store' // Handle form submission
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($uri, $routes)) {
    list($controller, $method) = explode('@', $routes[$uri]);
    require_once __DIR__ . "/controllers/$controller.php"; // Include the required controller file
    call_user_func($method); // Call the function dynamically
} else {
    http_response_code(404);
    echo "404 - Page Not Found";
}
