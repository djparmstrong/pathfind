<?php

namespace DAVIDA\Test;

use JMGQ\AStar\DomainLogicInterface;

/**
 * @implements DomainLogicInterface
 */
class PathLogic implements DomainLogicInterface {
    /**
     * Tarrain cost object defining the layout.
     * 
     * @var \DAVIDA\Test\GridLayout
     */
    private GridLayout $gridLayout;
    
    /**
     * Multi-dimensional array of Position representing the grid.
     * 
     * @var \DAVIDA\Test\Position[][]
     */
    private array $positions;

    /**
     * Object constructor.
     * 
     * @param \DAVIDA\Test\GridLayout $gridLayout
     *   Object defining the grid layout of the grid.
     */
    public function __construct(GridLayout $gridLayout) {
        $this->gridLayout = $gridLayout;

        // Generate any array of Position object representing the grid layout.
        $this->positions = $this->generatePositions($gridLayout);
    }

    /**
     * Get the adjacent cells to the current node.
     * - only in left, right, up, down directions.
     * 
     * @param Position $node
     *   Current cell position in the grid.
     * 
     * @return Position[]
     *   Array of Position objects for the adjacent cells.
     */
    public function getAdjacentNodes(mixed $node): iterable {
        $adjacentNodes = [];

        // Calcualtion the boundaries for the rows and columns to calculate the adjacent cells.
        [$startingRow, $endingRow, $startingColumn, $endingColumn] = $this->calculateAdjacentBoundaries($node);

        // Loop the boundaries in the grid the add adhacent cells.
        for ($row = $startingRow; $row <= $endingRow; $row++) {
            for ($column = $startingColumn; $column <= $endingColumn; $column++) {
                // Only add adjacent of on same row or column as current node.
                if ($node->getRow() == $row || $node->getColumn() == $column) {
                    $adjacentNode = $this->positions[$row][$column];

                    // Only add if the current node does not equal the adjacent node.
                    // - caters for where current node is min/max position for the row/column.
                    if (!$node->isEqualTo($adjacentNode)) {
                        $adjacentNodes[] = $adjacentNode;
                    }
                }
            }
        }

        return $adjacentNodes;
    }

    /**
     * Calculate cell cost of the adjacent cell.
     * 
     * @param Position $node
     *   Current cell postiion in the grid.
     * @param Position $adjacent
     *   Adjacent cell position in the grid.
     * 
     * @return float|int
     *   Cost value associated to the adjacent cell.
     */
    public function calculateRealCost(mixed $node, mixed $adjacent): float | int {
        // Confirm the adjacemt node, is actually next to the current node.
        if ($node->isAdjacentTo($adjacent)) {
            return $this->gridLayout->getCost($adjacent->getRow(), $adjacent->getColumn());
        }

        // Return the define constant for th default cost.
        return GridLayout::DEFAULT;
    }

    /**
     * Estimate the cost of moving between cells.
     * 
     * @param Position $fromNode
     *   Starting point cell in the grid.
     * @param Position $toNode
     *   Ending point cell in the grid.
     * 
     * @return float|int
     *   Cost value for moving between the cells.
     */
    public function calculateEstimatedCost(mixed $fromNode, mixed $toNode): float | int {
        return $this->euclideanDistance($fromNode, $toNode);
    }

    /**
     * Calculate distance using Euclidean formala.
     * - see: https://en.wikipedia.org/wiki/Euclidean_distance
     * 
     * @param Position $fromNode
     *   Starting point cell in the grid.
     * @param Position $toNode
     *   Ending point cell in the grid.
     * 
     * @return float
     *   Calculate distance between the two cells.
     */
    private function euclideanDistance(Position $a, Position $b): float {
        $rowFactor = ($a->getRow() - $b->getRow()) ** 2;
        $columnFactor = ($a->getColumn() - $b->getColumn()) ** 2;

        return sqrt($rowFactor + $columnFactor);
    }

    /**
     * Calculate the row and column boundaries to get adjacent cells.
     * 
     * @param Position $position
     *   The current cell in the grid.
     * 
     * @return int[]
     *   Array of intergets [topleft, bottomlegt, topright, bottomright]
     */
    private function calculateAdjacentBoundaries(Position $position): array {
        // Set top row boundary.
        if ($position->getRow() === 0) {
            $startingRow = 0;
        }
        else {
            $startingRow = $position->getRow() - 1;
        }

        // Set bottom row boundary.
        if ($position->getRow() === $this->gridLayout->getTotalRows() - 1) {
            $endingRow = $position->getRow();
        }
        else {
            $endingRow = $position->getRow() + 1;
        }

        // Set left column boundary.
        if ($position->getColumn() === 0) {
            $startingColumn = 0;
        }
        else {
            $startingColumn = $position->getColumn() - 1;
        }

        // Set right column boundary.
        if ($position->getColumn() === $this->gridLayout->getTotalColumns() - 1) {
            $endingColumn = $position->getColumn();
        }
        else {
            $endingColumn = $position->getColumn() + 1;
        }

        return [$startingRow, $endingRow, $startingColumn, $endingColumn];
    }

    /**
     * Generate position objects for each cell in the grid.
     * 
     * @param GridLayout $gridLayout
     *   The grid layout object with the layout definition.
     * 
     * @return Position[][]
     *   Multi-dimensional array of position objects for the grid.
     */
    private function generatePositions(GridLayout $gridLayout): array {
        $positions = [];

        // Loop grid array to generate the position objects.
        for ($row = 0; $row < $gridLayout->getTotalRows(); $row++) {
            for ($column = 0; $column < $gridLayout->getTotalColumns(); $column++) {
                $positions[$row][$column] = new Position($row, $column);
            }
        }

        return $positions;
    }
}
