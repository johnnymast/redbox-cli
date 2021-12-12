<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file updates coverage.json (used by README.md) to show the code coverage numbers
 * via img.shields.io.
 */

try {

    $badge = [
        "schemaVersion" => 1,
        "label" => "Code Coverage",
        "message" => "0%", // Will be updated by the code.
        "color" => "blue", // Again will be updated by the code.
        "namedLogo" => "github"
    ];

    $xml = simplexml_load_string(file_get_contents('clover.xml'));

    $coveredStatements = $xml->project->metrics['coveredstatements'];
    $totalStatements = $xml->project->metrics['statements'];
    $percentage = round(min(1, $coveredStatements / $totalStatements) * 100);

    $percentageString = $percentage . '%';


    $badge["message"] = $percentageString;
    $badge["color"] = ($percentage > 90) ? "green" : "red";

    $json = json_encode($badge, JSON_THROW_ON_ERROR);

    file_put_contents('coverage.json', $json);

} catch (Exception $e) {
    print_r($e->getMessage());
}