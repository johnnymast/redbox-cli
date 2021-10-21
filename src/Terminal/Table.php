<?php

namespace Redbox\Cli\Terminal;

use Redbox\Cli\Attributes\Route;
use Redbox\Cli\Output\Output;

class Table
{

    /**
     * @throws \Exception
     */
    #[Route('table')]
    function table(Output $output, Route $info, array $data = [])
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

            foreach($data as $row) {
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