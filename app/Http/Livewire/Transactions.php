<?php

namespace App\Http\Livewire;

use App\Mail\TransactionMail;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction as ModelsTransaction;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Transactions extends Component
{
    public $name, $email, $phone, $address, $service_name, $weight, $total_payment, $items = [];

    public function mount()
    {
        // Initialize the items array with one empty string
        $this->items = [""];
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10', 'numeric'],
            'address' => 'required|string|max:500',
            'service_name' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:1',
            'items' => 'array',
            'items.*' => 'nullable|string|min:1|max:255', // Ensure items are strings with proper length
        ];
    }

    public function addItem()
    {
        $this->items[] = "";
    }

    public function removeItem($key)
    {
        unset($this->items[$key]);
        $this->items = array_values($this->items);
    }

    public function store()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Fetch the service and validate its existence
                $service = Service::findOrFail($this->service_name);

                // Create User
                $user = $this->createUser();

                // Create Customer
                $customer = $this->createCustomer($user->id);

                // Create Item
                $item = $this->createItem($user->id);

                // Create Item Details
                $this->createItemDetails($item);

                // Create Transaction
                $transaction = $this->createTransaction($item, $service);

                // Send Transaction Email
                $this->sendTransactionEmail($transaction);

                // Flash success message and redirect
                session()->flash('success', 'Transaction created successfully!');
                return redirect()->route('progress');
            });
        } catch (\Exception $e) {
            // Handle errors and log them
            logger()->error('Transaction creation failed: ' . $e->getMessage());
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function render()
    {
        if ($this->service_name && $this->weight) {
            $service = Service::find($this->service_name);
            $this->total_payment = $service ? $service->price * $this->weight : 0;
        } else {
            $this->total_payment = 0;
        }

        $services = Service::all();
        return view('livewire.transaction', compact('services'));
    }

    private function createUser()
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => 3,
        ]);
    }

    private function createCustomer($userId)
    {
        return Customer::create([
            'phone' => $this->phone,
            'address' => $this->address,
            'user_id' => $userId,
        ]);
    }

    private function createItem($userId)
    {
        return Item::create([
            'name' => 'Default Item Name',
            'weight' => $this->weight,
            'user_id' => $userId,
        ]);
    }

    private function createItemDetails($item)
    {
        foreach ($this->items as $itemName) {
            if (!empty($itemName)) {
                ItemDetail::create([
                    'item_id' => $item->id,
                    'name' => $itemName,
                ]);
            }
        }
    }

    private function createTransaction($item, $service)
    {
        return ModelsTransaction::create([
            'service_id' => $this->service_name,
            'item_id' => $item->id,
            'total_payment' => $service->price * $this->weight,
            'received_date' => now(),
            'pickup_date' => now()->addHours($service->duration),
            'status' => 0,
        ]);
    }

    private function sendTransactionEmail($transaction)
    {
        try {
            Mail::to($this->email)->send(new TransactionMail($transaction));
        } catch (\Exception $e) {
            logger()->error('Failed to send email: ' . $e->getMessage());
        }
    }
}
