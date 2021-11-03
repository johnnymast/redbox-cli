<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Terminal;

use Redbox\Cli\Router\Attributes\Route;
use Redbox\Cli\Output\OutputBuffer;

/**
 * @internal
 */
class Table
{

    /**
     * Output a table to the screen.
     *
     * @param \Redbox\Cli\Output\OutputBuffer     $outputBuffer The output buffer to write to.
     * @param \Redbox\Cli\Router\Attributes\Route $route        The current route.
     * @param array                               $data         Information for the table.
     *
     * @throws \Exception
     */
    #[Route('table')]
    public function table(OutputBuffer $outputBuffer, Route $route, array $data = []): void
    {
        echo "HI @ my table\n";

        // TODO: Check if the has table headers or now

        if (count($data) > 0) {
            $headers = array_keys($data[0]);

            /**
             * Let's check if all the array's have the same
             * amount of keys. If not we throw an error.
             */
            $count = count($headers);

            foreach ($data as $row) {
                $cnt = count(array_keys($row));
                echo "{$cnt} vs {$count}\n";
                if (count(array_keys($row)) !== $count) {
                    throw new \Exception("The number of items are not of the same size.");
                }
            }


            print_r($headers);
        }
    }
}