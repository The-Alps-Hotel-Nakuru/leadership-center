<div>
    <x-slot name="header">Responsibilities for <u>{{ $designation->title }}</u> Staff</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Responsibilities</h5>
            </div>
            <div class="card-body">
                <ol class="d-flex flex-wrap flex-row">
                    @foreach ($designation->responsibilities as $responsibility)
                        <li class="flex-col col-2 p-3">
                            {{ $responsibility->responsibility }}
                            <button
                                onclick="confirm('Are You Sure you want to delete this responsibility?')|| event.stopImmediatePropagation()"
                                wire:click="delete({{ $responsibility->id }})" class="btn"><i
                                    class="bi bi-trash"></i></button>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="card my-5">
            <div class="card-header">
                <h5>Create a new Responsibility</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="responsibility" class="form-label">Responsibility Definition</label>
                    <textarea wire:model.live="responsibility.responsibility" class="form-control" name="responsibility" id="responsibility"
                        rows="3"></textarea>
                    @error('responsibility.responsibility')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
            </div>
        </div>
    </div>
</div>
