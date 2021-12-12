<?php
$tags = [
    'branch' => $argv[1],
];

$marker = '%';
$readme = "README.md";
$branchFile = 'branch.json';

$content = file_get_contents($readme);

foreach($tags as $tag => $value) {
    $content = str_replace($marker.$tag.$marker, $value, $content);
}

echo "Readme content {$content}\n";

file_put_contents($readme, $content);


$branch = [
  "branch" => $tags["branch"]
];

$json = json_encode($branch);

file_put_contents($branchFile, $json);
