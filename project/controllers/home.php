<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../errorlog.inc.php';
function homeController() {
    require __DIR__ . '/../views/home.view.php';
}