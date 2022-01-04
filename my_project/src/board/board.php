<?php

$statsBuild = array(
    'damage' => 0,
    'gold' => 0,
    'cost' => 0,
    'image' => 0,
    'lvl' => 0,
    'build_time' => 0
);

class Building
{
    private $stats;

    function __construct(array $s)
    {
        $stats = $s;
    }
}

class Board
{
    private $case;

    private $size_x;
    private $size_y;

    function __construct(int $x = 10, int $y = 10)
    {
        $this->size_x = $x; 
        $this->size_y = $y;

        $this->case = array($this->size_y);

        for ($i=0; $i < $this->size_y; $i++) {
            $this->case[$i] = array($this->size_x);

            for ($j=0; $j < $this->size_x; $j++) { 
                $this->case[$i][$j] = "$i+$j";
            }
        }
    }

    public function printCase()
    {
        foreach ($this->case as $key => $value) {
            echo "{$key} => {$value} <br>";
            foreach ($value as $key1 => $value1) {
                echo "{$key1} => {$value1} | ";
            }
            echo "<br>";
        }
    }
}


?>