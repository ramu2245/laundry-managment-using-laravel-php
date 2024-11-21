<div class="container">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            @include('layouts/sidebar')
        </div>
        <div class="col-md-8 col-lg-9">
            <h2>Services Page</h2>

            @include('layouts/services/add')
            @include('layouts/services/edit')

            <!-- Delete Confirmation Modal -->
            @if ($delete)
                <div class="modal fade show" id="deleteModal" tabindex="-1" style="display: block;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Service</h5>
                                <button type="button" class="btn-close" wire:click="$set('delete', false)"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the service: <strong>{{ $name }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="$set('delete', false)">Cancel</button>
                                <button type="button" class="btn btn-danger" wire:click="destroy">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @include('layouts/flashdata')

            <div class="row">
                <div class="col-md-8">
                    <button wire:click="showAddForm" type="button" class="btn btn-primary btn-sm mb-3">
                        Add Service
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input wire:model="search" type="text" class="form-control" placeholder="Search">
                        <div class="input-group-prepend" style="cursor: pointer">
                            <div wire:click="resetSearch" class="input-group-text">x</div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="10%" scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Price</th>
                        <th width="10%" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->duration }} hours</td>
                            <td>Rp. {{ number_format($item->price) }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click="showEditForm({{ $item->id }})" type="button" class="btn btn-sm btn-primary mr-2">Edit</button>
                                    <button wire:click="showDeleteForm({{ $item->id }})" type="button" class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $services->links() }}
        </div>
    </div>
</div>
