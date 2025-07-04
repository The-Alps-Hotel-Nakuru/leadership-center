<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body p-0 d-flex" style="min-height: 220px;">
                    <div class="flex-grow-1 p-4">
                        <h3 class="mb-0">{{ $employee->user->name }}</h3>
                        <p class="text-muted mb-1">{{ $employee->designation->title ?? 'Designation'  }}</p>
                        <span class="badge bg-primary">{{ $employee->department->title ?? "DePartment" }}</span>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Age:</div>
                            <div class="col-sm-8">{{ Carbon\Carbon::parse($employee->birth_date)->age }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Email:</div>
                            <div class="col-sm-8">{{ $employee->user->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Phone:</div>
                            <div class="col-sm-8">{{ $employee->phone_number ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Address:</div>
                            <div class="col-sm-8">{{ $employee->address ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Joined:</div>
                            <div class="col-sm-8">{{ $employee->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-stretch">
                        <img src="{{ $employee->user->profile_photo_url }}" alt="Profile Photo"
                             style="height:100%; width:auto; object-fit:cover; border-top-right-radius: .5rem; border-bottom-right-radius: .5rem;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
