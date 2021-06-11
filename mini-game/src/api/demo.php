<?php
// allow cors, see https://stackoverflow.com/questions/52479618/nginx-php-api-cors for more information
if (isset($_SERVER['HTTP_ORIGIN'])) {
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400'); // cache for 1 day
}
    $url = isset($_GET['url']) ? $_GET['url'] : "";
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('./data.json'), true);
    if ($url == "/quest" && $method == "GET") {
        list($quest,$trueAnswer) = new_random_question(count($data));
        // echo json_encode([$quest]);
        $data[$quest->questId] = $quest;
        $quest->trueAnswer = $trueAnswer;
        echo json_encode([$quest]);
        $questId = insertQuest($quest);
        $current = json_encode($data);
        file_put_contents('./data.json', $current);
        } else if ($url == "/answer" && $method == "POST") {
        $req = json_decode(file_get_contents('php://input'));
        $response = new stdClass();
        $response->ok = ($data[$req->questId]['trueAnswer'] == $req->content);
        echo json_encode($response);
        }
        function insertQuest(object $quest){
            $conn= new mysqli("localhost","root","","test");
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            $answer = json_encode($quest->answers);
            $query =$conn -> prepare("INSERT INTO quest (questContent,answers,trueAnswer) VALUES (?,?,?)");
            $query->bind_param("sss",$quest->questContent, $answer, $quest->trueAnswer);
           if( !$query->execute()){
               echo "error";
           }
           return mysqli_insert_id($conn);
        }
    function new_random_question($qid) {
        $quest = new stdClass();
        $quest->questId = $qid;
        $a = rand(2, 11);
        $b = rand(2, 11);
        $answers = [];
    switch (rand(0, 2)) {
        case 0:
            $quest->questContent = "$a x $b";
            $answers = [$a * $b, ($a - 1) * ($b - 1), ($a + 1) * ($b + 1), $a + $b];
        break;
        case 1:
            $quest->questContent = "$a + $b";
            $answers = [$a + $b, ($a - 1) * ($b - 1), ($a + 1) * ($b + 1), $a * $b];
        break;
        case 2:
            $quest->questContent = "$a - $b";
            $answers = [$a - $b, ($a - 1) * ($b - 1), ($a + 1) * ($b + 1), $a * $b];
        break;
        default:
        break;
    }
    $trueAnswer = $answers[0];
    shuffle($answers);
    $quest->answers = $answers;
    return [$quest, $trueAnswer];
    }
