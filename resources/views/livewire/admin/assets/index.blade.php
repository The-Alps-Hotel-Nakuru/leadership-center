<div>
    <x-slot name="header">All Assets</x-slot>

    <div class="container-fluid">
        @if (count($assets))
            <div class="accordion" id="accordionExample">
                @foreach (App\Models\Department::all() as $department)
                    @if (count($department->assets) > 0)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="accordion{{ $department->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $department->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $department->id }}">
                                    {{ $department->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $department->id }}" class="accordion-collapse collapse"
                                aria-labelledby="accordion{{ $department->id }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($department->assets as $asset)
                                        <div class="col-md-3 col-6">
                                            <div class="card bg-dark text-white" style="height: 250px; width:250px">
                                              <img class="card-img" src="{{ $asset->image_url }}" alt="Title">
                                              <div class="card-img-overlay">
                                                <h4 class="card-title">{{ $asset->title }}</h4>
                                                <h5 class="card-text">{{ $asset->asset_category->title }}</h5>
                                                <h6 class="card-text ">{{ $asset->asset_subcategory->title }}</h6>
                                                <p class="card-text mt-3">{{ $asset->description }}</p>
                                                <p class="card-text">Qty:{{ $asset->quantity }}</p>
                                                <p class="card-text">Unit Cost:{{ $asset->unit_cost_kes }}</p>
                                              </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        @else

        <div class="container m-auto">
            <h1 class="my-auto">No Assets Stored</h1>
        </div>

        @endif
    </div>
</div>
