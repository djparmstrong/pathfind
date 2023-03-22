<?php

namespace DAVIDA\Test;

use JMGQ\AStar\Node\NodeIdentifierInterface;

/**
 * Class to contain a grid cell position.
 */
class Position implements NodeIdentifierInterface {
    /**
     * The row position in the grid for the cell.
     * 
     * @var int
     */
    private int $row;

    /**
     * The column position in the grid for the cell.
     * 
     * @var int
     */
    private int $column;

    /**
     * Object constructor.
     * 
     * @param int $row
     *   Row position in the grid.
     * @param int $column
     *   Column position in the grid.
     */
    public function __construct(int $row, int $column) {
        // Validate the row/column are positive integers.
        $this->validateNonNegativeInteger($row);
        $this->validateNonNegativeInteger($column);

        $this->row = $row;
        $this->column = $column;
    }

    /**
     * Get the row value.
     * 
     * @return int
     *   Row value.
     */
    public function getRow(): int {
        return $this->row;
    }

    /**
     * Get the column value.
     * 
     * @return int
     *   Column value.
     */
    public function getColumn(): int {
        return $this->column;
    }

    /**
     * Check if the position matches with another position object.
     * 
     * @return bool
     *   Whether this position matches with another position object.
     */
    public function isEqualTo(Position $other): bool {
        return $this->getRow() === $other->getRow() && $this->getColumn() === $other->getColumn();
    }

    /**
     * Check if the position is adjacent to another another position object.
     * 
     * @return bool
     *   Whether this position is adjacent to another another position object.
     */
    public function isAdjacentTo(Position $other): bool {
        return abs($this->getRow() - $other->getRow()) <= 1 && abs($this->getColumn() - $other->getColumn()) <= 1;
    }

    /**
     * Get the string representation for the grid position.
     * 
     * @return string
     *   Grid poistion in string format.
     */
    public function getUniqueNodeId(): string {
        return $this->row . 'x' . $this->column;
    }

    /**
     * Validate if a value is a position integer.
     * 
     * @return void
     * 
     * @throws \InvalidArgumentException
     *   When the parameter is not an integer.
     */
    private function validateNonNegativeInteger(int $integer): void {
        if ($integer < 0) {
            throw new \InvalidArgumentException("Invalid non negative integer: $integer");
        }
    }
}
