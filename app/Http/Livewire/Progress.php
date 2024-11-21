<?php
namespace App\Http\Livewire;

use App\Models\Transaction;  // Change from Transaksi to Transaction
use Livewire\Component;
use Livewire\WithPagination;

class Progress extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $received_date, $pickup_date, $confirmSaveFlag = false;  // Changed variable name

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function action(Transaction $transaction)
    {
        $transaction->update([
            'status' => $transaction->status + 1
        ]);
        session()->flash('success', 'Action executed successfully.');
    }

    public function payment($transaction_id)
    {
        session(['transaction_id' => $transaction_id]);
        return redirect('/payment');
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    // Renamed method to avoid conflict with property
    public function enableSaveConfirmation()
    {
        $this->confirmSaveFlag = true;  // Set the flag to true to proceed with saving the transaction
    }

    public function storeTransaction()
    {
        if ($this->confirmSaveFlag) {
            // Logic to store the transaction goes here
            // For example, create a new transaction record in the database.
            Transaction::create([
                'service_id' => $this->service_name,
                'item_id' => $this->item_id,
                'total_payment' => $this->total_payment,
                'status' => 'pending', // Assuming initial status is 'pending'
                'received_date' => $this->received_date,
                'pickup_date' => $this->pickup_date
            ]);

            session()->flash('success', 'Transaction saved successfully.');
        } else {
            session()->flash('error', 'Transaction not saved. Please confirm to save.');
        }
    }

    public function render()
    {
        if ($this->search || $this->received_date || $this->pickup_date) {
            $progress = Transaction::whereHas('item', function ($item) {
                $item->whereHas('user', function ($user) {
                    $user->where('name', 'like', '%' . $this->search . '%');
                });
            })
                ->where('received_date', 'like', '%' . $this->received_date . '%')
                ->where('pickup_date', 'like', '%' . $this->pickup_date . '%')
                ->latest()->paginate(5);
        } else {
            $progress = Transaction::latest()->paginate(5);
        }

        return view('livewire.progress', compact('progress'));
    }
}

