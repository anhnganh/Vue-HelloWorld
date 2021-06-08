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
        // $q = new stdClass();
        // $a = rand(2, 10);
        // $b = rand(2, 10);
        // $q->questId = count($data);
        // $q->questContent = "$a x $b";
        // $answers = [$a * $b, ($a - 1) * ($b - 1), ($a + 1) * ($b + 1), $a + $b];
        // shuffle($answers);
        // $q->answers = $answers;
        // echo json_encode([$q]);
        // $q->trueAnswer = $a * $b;
        // $data[$q->questId] = $q;
        // file_put_contents('./data.json', json_encode($data));
        list($quest,$trueAnswer) = new_random_question(count($data));
        echo json_encode([$quest]);
         $data[$quest->questId] = $trueAnswer;
        file_put_contents('./data.json', json_encode($data));
        } else if ($url == "/answer" && $method == "POST") {
        $req = json_decode(file_get_contents('php://input'));
        $res = new stdClass();
        $res->ok = ($data[$req->questId] == $req->content);
        echo json_encode($res);
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
    // $quest->trueAnswer=$trueAnswer;
    $trueAnswer = $answers[0];
    shuffle($answers);
    $quest->answers = $answers;
    return [$quest, $trueAnswer];
    }
