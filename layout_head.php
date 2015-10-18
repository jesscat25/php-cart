<?php
// connect to database
include 'config/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?> - LIVE DEMO</title>
 
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
 
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
 
</head>
<body>
 
    <?php include 'navigation.php'; ?>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?></h1>
        </div>
