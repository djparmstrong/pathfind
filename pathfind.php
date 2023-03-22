<?php

namespace DAVIDA\Test;

// Include autoloader.
require __DIR__ . '/vendor/autoload.php';

use JMGQ\AStar\AStar;

// Set the grid layout.
// - 1 = passable cell
// - 999 = blocked cell
$gridLayout = new GridLayout([
    [1, 1, 1, 1, 1],
    [1, 999, 999, 999, 1],
    [1, 1, 1, 1, 1],
    [1, 1, 1, 1, 1],
    [1, 1, 1, 1, 1],
]);

// Set the positions for the start and goal cells.
$start = new Position(0, 1);
$goal = new Position(3, 2);

// Initialise the path logic objects and Astar algorithm.
$domainLogic = new PathLogic($gridLayout);
$aStar = new AStar($domainLogic);

// Calculate the route solution.
$solution = $aStar->run($start, $goal);

// Build the grid layout to show the result.
$emptyValue = str_pad('-', 3, ' ', STR_PAD_LEFT);
$emptyRow = array_fill(0, $gridLayout->getTotalColumns(), $emptyValue);
$board = array_fill(0, $gridLayout->getTotalRows(), $emptyRow);
$step = 0;
foreach ($solution as $position) {
    $stepText = (string) $step;
    $board[$position->getRow()][$position->getColumn()] = str_pad($stepText, 3, ' ', STR_PAD_LEFT);
    $step++;
}

// Output the grid result.
$output = [];
echo 'Steps: ' . ($step - 1) . PHP_EOL;
foreach ($board as $row) {
    $output[] = implode('', $row);
}
echo implode("\n", $output);
echo PHP_EOL;
