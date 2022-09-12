<div>
    @if (auth()->user()->employee->department->title == 'housekeeping')
        <x-housekeeping></x-housekeeping>
    @endif
</div>
