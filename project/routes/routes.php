<?php

//require_once __DIR__ . '/../controllers/createTicket.php';
require_once __DIR__ . '/../middlewares/middleware.php'; 

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/project'; // Change this to your project folder name
$uri = str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    '/newTicket' => ['handler' => './controllers/createTicket.php@showPostForm', 'middleware' => ['authMiddleware']],  // No middleware for viewing form
    '/newTicket/post' => ['handler' => './controllers/createTicket.php@storePost', 'middleware' => ['authMiddleware']] ,// Middleware applied
    '/adminTicket' => ['handler' => './controllers/createTicket.php@showAdminForm', 'middleware' => ['authMiddleware','authRoleAdmin']],  // No middleware for viewing form
    '/adminTicket/post' => ['handler' => './controllers/createTicket.php@storePost', 'middleware' => ['authMiddleware','authRoleAdmin']] ,
    '/tickets' => ['handler' => './controllers/tickets.php@ticketsController', 'middleware' => ['authMiddleware','authRoleAdmin']] ,
    '/errorlog' => ['handler' => './controllers/errorLogs.php@ticketsController', 'middleware' => ['authMiddleware','authRoleAdmin']] ,
    '/register'  => ['handler' => './controllers/register.php@showPostForm', 'middleware' => []], 
    '/register/post'  => ['handler' => './controllers/register.php@storePost', 'middleware' => []], 
    '/login'  => ['handler' => './controllers/login.php@showPostForm', 'middleware' => []], 
    '/login/post'  => ['handler' => './controllers/login.php@storePost', 'middleware' => []], 
    '/forgotPassword'  => ['handler' => './controllers/forgotpassword.php@showPostForm', 'middleware' => []], 
    '/forgotPassword/post'  => ['handler' => './controllers/forgotpassword.php@storePost', 'middleware' => []], 
    '/resetPassword'  => ['handler' => './controllers/resetpassword.php@showPostForm', 'middleware' => []], 
    '/resetPassword/post'  => ['handler' => './controllers/resetpassword.php@storePost', 'middleware' => []],
    '/'  => ['handler' => './controllers/home.php@homeController', 'middleware' => []], 
    '/home'  => ['handler' => './controllers/home.php@homeController', 'middleware' => []], 
    '/logout'  => ['handler' => './controllers/logout.php@logoutController', 'middleware' => []], 
    '/knowledgeBase'  => ['handler' => './controllers/kbpage.php@kbController', 'middleware' => []], 
    '/myTickets'  => ['handler' => './controllers/myTickets.php@myTicketsController', 'middleware' => ['authMiddleware']], 
    '/profile'  => ['handler' => './controllers/profile.php@showPostForm', 'middleware' => ['authMiddleware']], 
    '/profile/post'  => ['handler' => './controllers/profile.php@storePostProfile', 'middleware' => ['authMiddleware']], 
    '/profile/password/post'  => ['handler' => './controllers/profile.php@storePostPass', 'middleware' => ['authMiddleware']], 
    '/clientTicket'=> ['handler' => './controllers/ticket.php@ticketController', 'middleware' => ['authMiddleware','checkTicketOwnership']],
];

if (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];
    if (isset($_GET['id'])) {
        $ticket_id = $_GET['id'];
    } else {
        $ticket_id = null; // Handle the case where ticket_id isn't provided
    }

    // Run middlewares
    foreach ($route['middleware'] as $middleware) {
        if (function_exists($middleware)) {
            if ($middleware === 'checkTicketOwnership') {
                
                require_once __DIR__ . '/../database/db.php'; 
                call_user_func($middleware, $ticket_id, $conn); // Pass ticket_id and conn
            } else {
                call_user_func($middleware);
            }
        } else {
            http_response_code(500);
            echo "500 - Internal Server Error: Middleware function not found.";
            exit;
        }
    }

    // Split handler into file and function if it contains '@'
    if (strpos($route['handler'], '@') !== false) {
        list($file, $function) = explode('@', $route['handler']);

        // Ensure file exists
        if (file_exists($file)) {
            require_once $file;

            // Ensure function exists before calling it
            if (function_exists($function)) {
                call_user_func($function);
                exit;
            } else {
                http_response_code(500);
                echo "500 - Internal Server Error: Handler function '$function' not found in '$file'.";
                exit;
            }
        } else {
            http_response_code(500);
            echo "500 - Internal Server Error: Handler file '$file' not found.";
            exit;
        }
    } else {
        // If the handler is just a file, include it directly
        if (file_exists($route['handler'])) {
            require_once $route['handler'];
            exit;
        } else {
            http_response_code(500);
            echo "500 - Internal Server Error: Handler file not found.";
            echo $uri;
            exit;
        }
    }
} else {
    http_response_code(404);
    echo "404 - Page Not Found";
}