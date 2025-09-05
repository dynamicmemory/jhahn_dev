<?php 
header("Content-Type: application/json");

$fragments = [
            ["title" => "Why agi will never happen", "body" => "Sam fraud bank..altman"],
            ["title" => "Controversial opinion", "body" => "This is my controversial"],
            ["title" => "Title of tiel ", "body" => "peter tiel? or epter tiel?"],
            ["title" => "Musk a scammer?", "body" => "elon van ge lone"]
];

echo json_encode($fragments);
?>
