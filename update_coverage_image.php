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
 * This file downloads the coverage badges and puts it in the
 * docs/badges folder. This will be used by the README.md file.
 */
try {
    $file = "coverage.json";
    $branch = $argv[1];
    $json = file_get_contents($file);
    $endpoint = "https://github.com/johnnymast/redbox-cli/blob/{$branch}/{$file}";
    $imageUrl = "https://img.shields.io/endpoint?url={$endpoint}";
    $outFile = "docs/badges/coverage.svg";


    $content = file_get_contents($imageUrl);

    echo "Full URL: {$imageUrl}\n";

    file_put_contents($outFile, $content);


} catch (Exception $e) {
    print_r($e->getMessage());
}
