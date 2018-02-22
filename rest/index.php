<?php
require 'vendor/autoload.php';

// Prepare env
if(file_exists('../.env')) {
  $dotenv = new Dotenv\Dotenv('../');
  $dotenv->load();
}

// function to test if the number is prime or not
function checkPrime($n)
{
  for ($x = 2; $x <= $n/2; $x++) 
  {
    if ($n % $x == 0)
    {
      return false;
    }
  }
  
  return true;
}

// Create new app
$app = new \Slim\App(
  [
    'settings' => [
        'displayErrorDetails' => true
    ]
  ]
);

// Add some basic authentication
// In real world this should be replaced with something more secure
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
  "secure" => true,
  "relaxed" => ["localhost"], // no https in localhost
  "users" => [
    "restuser@example.com" => getenv('USER_PASS')
  ],
  "environment" => "REDIRECT_HTTP_AUTHORIZATION",
  "error" => function ($request, $response, $arguments) {
    $data = [];
    $data["status"] = "error";
    $data["message"] = $arguments["message"];
    return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
  }
]));

/**
 * This method gets a numbers sums them up add returns if the
 * number calculated is a prime number
 * @param String $numbers - sequence of numbers
 *
 */
$app->get('/sumandcheck/{numbers}', function ($request, $response) {
  
  $numbers = $request->getAttribute("numbers");
  if(strlen($numbers) > 0 && preg_match('/^\d(?:,\d)*$/', $numbers)) 
  {
    $num_array = explode(',', $numbers);
    $sum = array_sum($num_array);
    $is_prime = checkPrime($sum);
    
    return $response->withJson(array('result' => $sum, 'isPrime' => $is_prime), 200);
  }
  else 
  {
    return $response->withJson(array('error' => 'Invalid input'), 400);
  }
});

/**
 * This method gets a number and checks if the number is a prime number
 * @param Int $number - number
 *
 */
$app->get('/check/{number}', function ($request, $response) {
  
  $number = $request->getAttribute("number");
  if(ctype_digit($number)) 
  {
    $is_prime = checkPrime($number);
    
    return $response->withJson(array('isPrime' => $is_prime), 200);
  }
  else 
  {
    return $response->withJson(array('error' => 'Invalid input'), 400);
  }
});

$app->run();