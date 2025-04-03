<?php 
function logoutController() {
    session_destroy();
    header('location: /project/login');
}