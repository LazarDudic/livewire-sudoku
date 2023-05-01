<div>
    <table class="sudoku">
        @foreach ($grid as $row)
            <tr>
                @foreach ($row as $cell)
                    <td><input  @class(['error' => !$this->validNumber($loop->parent->index, $loop->index, $cell)]) 
                        type="text" 
                        value="{{ $cell }}"
                        wire:model="grid.{{ $loop->parent->index }}.{{ $loop->index }}"></td>
                @endforeach
            </tr>
        @endforeach
    </table>
    @if($this->isComplete())
    <div class="success-message">
        You have successfully solved a Sudoku puzzle!!!
    </div>
    @endif
    <div class="options">
        <button wire:click="freshGrid()">New</button>
        <select wire:model="numToHide">
            @foreach (\App\Enums\SudokuLevel::cases() as $case)
            <option value="{{$case}}">{{$case->name}}</option>
            @endforeach
           
        </select>
    </div>
</div>
