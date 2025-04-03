<!DOCTYPE html>
<html lang="en">
<head>   
    <meta charset="UTF-8">
    <!--Setting the viewport to make your website look good on all devices:-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./images/favicon.png" />
    <title>HelpDesk</title>
    <link rel="stylesheet" href="/project/views/css/style.css"/>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.min.css"
      integrity="sha512-rSWTr6dChYCbhpHaT1hg2tf4re2jUxBWTuZbujxKg96+T87KQJriMzBzW5aqcb8jmzBhhNSx4XYGA6/Y+ok1vQ=="
      crossorigin="anonymous"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous"
        defer
    />

</head>
<body>
    <header class='flexc'>
        <!-- home submit ticket knowledgebase mytickets MyProfile(logout and dashboard) lan:in registered user -->
         <div >
            <div class='logo nav'>HelpDesk</div>
         </div>
         <?php 
         if (!isset($_SESSION['jwt_token'] ) || empty($_SESSION['jwt_token'] )) { ?>
         <div class='nav flexc'>
            <a href='home'><div class='hea'>Home </div></a>
            <a href='newTicket'><div class='hea'>Submit Ticket </div></a>
            <a href='knowledgeBase'><div class='hea'>Knowledgebase </div></a>
            <a href='login'><div class='hea'>Login</div></a>
         </div>
         <?php
        }else if($_SESSION["role"] === 'admin') {?>
         <div class='nav flexc'>
            <a href='home'><div class='hea'>Home </div></a>
            <a href='adminTicket'><div class='hea'>Submit Ticket </div></a>
            <a href='knowledgeBase'><div class='hea'>Knowledgebase </div></a>
            <a href='tickets'><div class='hea'>Tickets </div></a>
            <a href='errorlog'><div class='hea'>Error Log </div></a>
            <a href='profile'><div class='hea'>My Profile</div></a><!-- (logout and dashboard) -->
            <a href='logout'><div class='hea'>Logout</div></a>
         </div>
         <?php
         }else{?>
         <div class='nav flexc'>
            <a href='home'><div class='hea'>Home </div></a>
            <a href='newTicket'><div class='hea'>Submit Ticket </div></a>
            <a href='knowledgeBase'><div class='hea'>Knowledgebase </div></a>
            <a href='myTickets'><div class='hea'>My Tickets </div></a>
            <a href='profile'><div class='hea'>My Profile</div></a>
            <a href='logout'><div class='hea'>Logout</div></a>
         </div>
        <?php
        } 
         ?>
    </header>
    <div class = 'breaker'>&nbsp;</div>