<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day

}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
}
 $a = rand(1,4);
 $b = rand(4,9); 
 $c = rand(1,10);
 $array = array("id" => $c,"question"=>$a."x" .$b, "correct_answer"=> $a*$b,"incorrect_answers"=>[$a-$b , $a+$b , $a+$b+$b ]);
// echo "<pre>";
// print_r($array);
// echo "<pre>";
array_push($array['incorrect_answers'],$array['correct_answer']=$a*$b);
 $JSON = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
echo "<pre>";
echo $JSON;
echo "<pre>";


?>