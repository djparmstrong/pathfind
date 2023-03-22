# Oxbury Pathfind

Imagine representing a grid-shaped game map as a 2-dimensional array. Each value of this array is
boolean `true` or `false` representing whether that part of the map is passable (a floor) or blocked
(a wall).

Write a function that takes such a 2-dimensional array `A` and 2 vectors `P` and `Q`, with `0,0` being the top left corner of the map and returns the distance of the shortest path between those points, respecting the walls in the map.

eg. Given the map (where `.` is passable - `true`, and `#` is blocked - `false`)

```
. P . . .
. # # # .
. . . . .
. . Q . .
. . . . .
```

then `pathfind(A, P, Q)` should return `6`.

## What to do

1. Clone/Fork this repo or create your own
2. Implement the function described above
3. Provide unit tests for your submission
4. Fill in the section(s) below

## Comments Section

The implementation is based around the AStar algorithm for working out the shorted path between 2 points. Utilising the `jmgq/a-star` package, defining the `PathLogic` handler and `GridLayout` classes for calculating the cost of each move between cells. The `Position` class is utility for defining each cell within the grid.

The concept comes from using the value `1` to identify cells which can be passed and `999` for cells which can not be passed, this way the cost of a move through a blocked cell will too high for it to be considered the shortest route.

Steps to run:
- `composer install` to pull in the dependencies
- `php pathfind.php` to execute the script and see the solution output

### What I'm Pleased With

I am pleased with the concept of this solution and how neat it it, untilising an existing library for the algorithm and leveraging it to provide the require logic. 

### What I Would Have Done With More Time

With more time i would like to implement slightly more robust validation to prevent the ability to use a start and/or goal position that is blocked in the grid layout definition.
Also, to package this as usable library that could be added to any project with a service class that would take the grid definition array, start and goal cells as arrays. Then return the solution object, extended to include more functions for returning the path and number of steps. Instead of this being in the process script.
