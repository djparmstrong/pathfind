<?php

namespace DAVIDA\Test;

/**
 * Class to contain the grid layout.
 */
class GridLayout {

    /**
     * Default cost value given to cells.
     * 
     * @var int
     */
    public const DEFAULT = 99999;

    /**
     * The multi-dimensinal array defining the grid layout.
     * 
     * @var int[][]
     * */
    private array $gridLayout;

    /**
     * Object contructor.
     * 
     * @param int[][] $gridLayout
     *   Multi-dimensional array with the grid layout and cell costs.
     *
     * @throws \InvalidArgumentException
     *   If the grid layout array is not formatted correctly.
     */
    public function __construct(array $gridLayout) {
        // Validate the terrrain cost array is set.
        if (self::isEmpty($gridLayout)) {
            throw new \InvalidArgumentException('The grid layout array is empty');
        }

        // Validate the terran cost array is rectangular/square.
        if (!self::isRectangular($gridLayout)) {
            throw new \InvalidArgumentException('The grid layout array is not rectangular');
        }

        // Ensure a numeric key structure to the grid layout array.
        $gridLayout = self::convertToNumericArray($gridLayout);

        // Valiate the grid layout values for each cell.
        $this->gridLayout = self::validateTerrainCosts($gridLayout);
    }

    /**
     * Get the got value for a given cell in the grid.
     * 
     * @return int
     *   Cell cost value.
     * 
     * @throws \InvalidArgumentException
     *   If the row/column does not exist in the grid.
     */
    public function getCost(int $row, int $column): int {
        // Check the row/column exists in the grid.
        if (!isset($this->gridLayout[$row][$column])) {
            throw new \InvalidArgumentException("Invalid tile: $row, $column");
        }

        return $this->gridLayout[$row][$column];
    }

    /**
     * Get the total number of rows in the grid.
     * 
     * @return int
     *   Number of rows.
     */
    public function getTotalRows(): int {
        return count($this->gridLayout);
    }

    /**
     * Get the total number of columns in the grid.
     * 
     * @return int
     *   Number of columns.
     */
    public function getTotalColumns(): int {
        return count($this->gridLayout[0]);
    }

    /**
     * Check if the provided grid array in empty.
     * 
     * @param int[][] $gridLayout
     *   Multi-dimensional array for the grid layout.
     * 
     * @return bool
     *   Whether the grid is valid.
     */
    private static function isEmpty(array $gridLayout): bool {
        // Check the array is not empty.
        if (!empty($gridLayout)) {
            // Check a row is defined.
            $firstRow = reset($gridLayout);

            return empty($firstRow);
        }

        return true;
    }

    /**
     * Validate the grid array has valid cost values.
     * 
     * @param mixed[][] $grid
     *   Multi-dimensional array defining the grid layout.
     * 
     * @return int[][]
     *   Multi-dimensional array with formated cost value as integers.
     * 
     * @throws \InvalidArgumentException
     *   One of the cost values is invalid.
     */
    private static function validateTerrainCosts(array $grid): array {
        $validTerrain = [];

        // Loop the grid array to check cost values.
        foreach ($grid as $row => $rowValues) {
            foreach ($rowValues as $column => $value) {
                // Validate the cost value is an integer.
                $integerValue = filter_var($value, FILTER_VALIDATE_INT);

                if ($integerValue === false) {
                    throw new \InvalidArgumentException('Invalid grid layout: ' . print_r($value, true));
                }

                $validTerrain[$row][$column] = $integerValue;
            }
        }

        return $validTerrain;
    }

    /**
     * Convert an associative grid array to numeric.
     * 
     * @param int[][] $associativeArray
     *   Multi-dimensional array defining the grid layout.
     * 
     * @return int[][]
     *   Multi-dimensional array formatted with numeric keys.
     */
    private static function convertToNumericArray(array $associativeArray): array {
        $numericArray = [];

        foreach ($associativeArray as $row) {
            $numericArray[] = array_values($row);
        }

        return $numericArray;
    }

    /**
     * Validate the grid array defines a grid structure.
     * 
     * @param int[][] $grid
     *   Multi-dimensional array defining the grid layout.
     * 
     * @return bool
     *   Whether the grid is defnined correctly.
     */
    private static function isRectangular(array $grid): bool {
        $numberOfColumnsInFirstRow = count(reset($grid));

        foreach ($grid as $row) {
            if (count($row) !== $numberOfColumnsInFirstRow) {
                return false;
            }
        }

        return true;
    }
}
