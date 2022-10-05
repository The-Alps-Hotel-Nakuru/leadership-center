<div>
    <x-slot name="header"> Designation Responsibilities</x-slot>


    <div class="accordion" id="responsibilities">
        @foreach (App\Models\Designation::all() as $designation)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $designation->id }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $designation->id }}" aria-expanded="false"
                        aria-controls="collapse{{ $designation->id }}">
                        {{ $designation->title }}


                    </button>
                </h2>
                <div id="collapse{{ $designation->id }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $designation->id }}" data-bs-parent="#responsibilities">
                    <div class="accordion-body ">
                        @foreach ($designation->responsibilities as $responsibility)
                            <div class="d-flex flex-row align-items-center">
                                <li class="my-1">{{ $responsibility->responsibility }}</li>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.responsibilities.edit', $responsibility->id) }}"
                                        class="m-2 btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                                    <button
                                        onclick="confirm('Are You Sure you want to delete this responsibility? {{ $responsibility->responsibility }}')|| event.stopImmediatePropagation()"
                                        wire:click="delete({{ $responsibility->id }})" class="m-2 btn btn-xs btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ route('admin.responsibilities.create', $designation) }}"
                            class="my-3 btn btn-dark text-uppercase">Create new</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
