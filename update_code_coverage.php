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

    $percentage = 5;

    $badge["message"] = $percentageString;
    $badge["color"] = match(true) {
        $percentage > 90 => "green",
        default => "red"
    };

    $json = json_encode($badge, JSON_THROW_ON_ERROR);

    file_put_contents('coverage.json', $json);

} catch (Exception $e) {
    print_r($e->getMessage());
}






return;


//$imageHeight = 20;
//$imageWidth = 170;
//$xMargin = 5;
//$font = 3;
//
//$image = imagecreate($imageWidth, $imageHeight);
//
//$backgroundColor = imagecolorallocate($image, 0, 20, 0);
//$foregroundColor = imagecolorallocate($image, 0, 245, 0);
//$borderColor = imagecolorallocate($image, 0, 190, 0);
//
//imagerectangle($image, 0, 0, $imageWidth - 1, $imageHeight - 1, $borderColor);
//
//imagestring($image, $font, $xMargin, 3, 'Pest Code Coverage:', $foregroundColor);
//
//$width = imagefontwidth($font) * strlen($percentageString);
//imagestring($image, $font,$imageWidth - $xMargin - $width, 3, $percentageString, $foregroundColor);
//
//imagepng($image, 'docs/code-coverage.png');
//
//imagedestroy($image);