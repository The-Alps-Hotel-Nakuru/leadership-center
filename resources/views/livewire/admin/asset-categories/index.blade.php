<div>
    <x-slot name="header">Asset Categories & Subcategories</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex">
                <h4>List of Asset Categories</h4>
                <div class="flex-col ms-auto">
                    <a wire:ignore href="{{ route('admin.asset_categories.create') }}" class="btn btn-primary">
                        <i data-feather="user-plus"></i>
                    </a>
                </div>
            </div>
            <div class=" card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Creator</th>
                            <th>Sub-categories</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asset_categories as $category)
                            <tr class="">
                                <td scope="row">{{ $category->id }}</td>
                                <td>{{ $category->title }}</td>
                                <td class="text-wrap">{{ $category->description }}</td>
                                <td style="font-style:oblique">{{ $category->creator->name }} <br> ({{ $category->creator->role->title }})</td>
                                <td>
                                    @if (count($category->subCategories) > 0)
                                        <ul>
                                            @foreach ($category->subCategories as $sub)
                                                <li >
                                                    <a href="{{ route('admin.asset_subcategories.edit', $sub->id) }}">{{ $sub->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @else
                                        <span class="text-center text-uppercase">No Sub Categories </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('admin.asset_categories.edit', $category->id) }}"
                                                class="btn btn-xs btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        @if (auth()->user()->id != $category->id)
                                            <div class="flex-col  m-2">
                                                <button class="btn btn-xs btn-danger"
                                                    onclick="confirm('Are you sure you want to Delete this Category?')||event.stopImmediatePropagation()"
                                                    wire:click='delete({{ $category->id }})'>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $asset_categories->links() }}
            </div>
        </div>
    </div>
</div>
