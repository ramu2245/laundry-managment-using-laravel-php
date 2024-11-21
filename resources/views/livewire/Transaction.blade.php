<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h2>Transaction Page</h2>

            <!-- Flash Messages -->
            @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Form Fields -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input wire:model="name" type="text" class="form-control" id="name" placeholder="Full Name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model="email" type="email" class="form-control" id="email" placeholder="Email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input wire:model="phone" type="text" class="form-control" id="phone" placeholder="Phone">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea wire:model="address" class="form-control" id="address" placeholder="Address"></textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="service_name">Service</label>
                                <select wire:model="service_name" class="form-control" id="service_name">
                                    <option value="">Select Service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }} (Rp. {{ number_format($service->price) }})</option>
                                    @endforeach
                                </select>
                                @error('service_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input wire:model="weight" type="number" class="form-control" id="weight" min="1">
                                @error('weight') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="total_payment">Total Payment</label>
                                <input wire:model="total_payment" type="text" class="form-control" id="total_payment" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <label>Items</label>
                            @foreach($items as $key => $item)
                                <div class="input-group mb-2">
                                    <input wire:model="items.{{ $key }}" type="text" class="form-control" placeholder="Item name">
                                    <button wire:click="removeItem({{ $key }})" class="btn btn-danger btn-sm">x</button>
                                </div>
                            @endforeach
                            <button wire:click="addItem" class="btn btn-primary btn-sm">Add Item</button>
                        </div>
                    </div>

                    <button wire:click="store" class="btn btn-success mt-3">Save Transaction</button>
                </div>
            </div>
        </div>
    </div>
</div>
