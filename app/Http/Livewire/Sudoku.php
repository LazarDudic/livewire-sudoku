<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enums\SudokuLevel;
use Illuminate\View\View;
use Livewire\Component;

class Sudoku extends Component
{
    public array $grid = [];
    public array $finalGrid = [];
    public int $numToHide = SudokuLevel::EASY->value;

    public function mount(): void
    {
        $this->freshGrid();
    }

    protected function getValidNumbers($row, $col): array
    {
        $validNumbers = [];
        for ($num = 1; $num <= 9; $num++) {
            if ($this->isValid($row, $col, $num)) {
                $validNumbers[] = $num;
            }
        }
        return $validNumbers;
    }

    public function freshGrid(): void
    {
        for ($i = 0; $i < 9; $i++) {
            $this->finalGrid[$i] = [];
            for ($j = 0; $j < 9; $j++) {
                $this->finalGrid[$i][$j] = null;
            }
        }

        // Populate finalGrid with random numbers
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $validNumbers = $this->getValidNumbers($i, $j);
                if (empty($validNumbers)) {
                    // No valid numbers found, reset the grid and start over
                    $this->freshGrid();
                    return;
                }
                $num = $validNumbers[array_rand($validNumbers)];
                $this->finalGrid[$i][$j] = $num;
            }
        }

        $this->grid = $this->finalGrid;
        $this->hideNumbers();
    }

    protected function isValid($row, $col, $num): bool
    {
        for ($i = 0; $i < 9; $i++) {
            if ($this->finalGrid[$row][$i] == $num
                || $this->finalGrid[$i][$col] == $num
            ) {
                return false;
            }
        }

        $subRow = floor($row / 3) * 3;
        $subCol = floor($col / 3) * 3;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->finalGrid[$subRow + $i][$subCol + $j] == $num) {
                    return false;
                }
            }
        }
        return true;
    }

    protected function hideNumbers()
    {

        $numToHide = $this->numToHide;
        $cellPositions = [];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $cellPositions[] = [$i, $j];
            }
        }

        shuffle($cellPositions);
        for ($i = 0; $i < $numToHide; $i++) {
            $row = $cellPositions[$i][0];
            $col = $cellPositions[$i][1];
            $this->grid[$row][$col] = null;
        }
    }

    public function updatedNumToHide($value) : void
    {
        $this->freshGrid();
    }

    public function validNumber($row, $col, $num) : bool
    {
        return $this->finalGrid[$row][$col] == $num || empty($num);
    }

    public function isComplete() : bool
    {
        return $this->finalGrid === $this->grid;
    }

    protected function castGridValues() : void
    {
        for ($i = 0; $i < 9; $i++) {
            for ($x = 0; $x < 9; $x++) {
                if (!is_numeric($this->grid[$i][$x])) {
                    $this->grid[$i][$x] = null;
                    continue;
                }
                $this->grid[$i][$x] = (int) $this->grid[$i][$x];
            }
        }
    }

    public function render() : View
    {
        $this->castGridValues();
        return view('livewire.sudoku');
    }
}