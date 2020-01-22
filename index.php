<?php
/**
 * Marcos Rivera
 * 01-22-2020
 * 328/food/index.php
 */

//Start a session
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ("vendor/autoload.php");

//Instantiate Fat-Free framework (F3)
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a breakfast route
$f3->route('GET /breakfast', function() {
    $view = new Template();
    echo $view->render('views/breakfast.html');
});

//Define a lunch route
$f3->route('GET /lunch', function() {
    $view = new Template();
    echo $view->render('views/lunch.html');
});

//Define an order route
$f3->route('GET /order', function() {
   $view = new Template();
   echo $view->render('views/form1.html');
});

//Define an order2 route
$f3->route('POST /order2', function() {
    //var_dump($_POST);
    $_SESSION['food'] = $_POST['food'];
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define an order2 route
$f3->route('POST /summary', function() {
    //var_dump($_POST);
    $_SESSION['meal'] = $_POST['meal'];
    $view = new Template();
    echo $view->render('views/results.html');
});

//Define a route that accepts a food parameter
$f3->route('GET /@item', function ($f3, $params) {
    var_dump($params);
    $item = $params['item'];
    echo"<p>You ordered $item</p>";

    $foodsWeServe = array("tacos", "pizza", "lumpia");
    if(!in_array($item, $foodsWeServe)) {
        echo"<p>Sorry... we don't serve $item</p>";
    }

    switch($item) {
        case 'tacos':
            echo "<p>We serve tacos on Tuesdays</p>";
            break;
        case 'pizza':
            echo "<p>Pepperoni or veggie?</p>";
            break;
        case 'bagel':
            $f3->reroute("/breakfast");
            break;
        default:
            $f3->error(404);
    }
});

$f3->run();