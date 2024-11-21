<?php

namespace App\Http\Livewire;

use App\Models\Service; // Use 'Service' directly if you prefer
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $add, $edit, $delete, $search;
    public $name, $duration, $price, $service_id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'name' => 'required',
            'duration' => 'required|min:1|numeric',
            'price' => 'required|min:30|numeric',
        ];
    }

    public function showAddForm()
    {
        $this->add = true;
    }

    public function store()
    {
        $this->validate();

        Service::create([
            'name' => $this->name,
            'duration' => $this->duration,
            'price' => $this->price,
        ]);

        session()->flash('success', 'Data has been saved successfully.');
        $this->resetForm();
    }

    public function showEditForm(Service $service)
    {
        $this->edit = true;
        $this->service_id = $service->id;
        $this->price = $service->price;
        $this->name = $service->name;
        $this->duration = $service->duration;
    }

    public function update()
    {
        $this->validate();

        Service::whereId($this->service_id)->update([
            'name' => $this->name,
            'duration' => $this->duration,
            'price' => $this->price,
        ]);

        session()->flash('success', 'Data has been updated successfully.');
        $this->resetForm();
    }

    public function showDeleteForm(Service $service)
    {
        $this->delete = true;
        $this->service_id = $service->id;
        $this->name = $service->name;
    }

    public function destroy()
    {
        // Find the service instance by service_id
        $service = Service::find($this->service_id);

        // Check if the service has any related transactions
        if ($service && $service->transactions()->exists()) {
            session()->flash('error', 'Cannot delete this service because it has existing transactions.');
        } else {
            // If no related transactions, proceed to delete the service
            $service->delete();
            session()->flash('success', 'Data has been deleted successfully.');
        }

        $this->updatingSearch();
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->add = false;
        $this->edit = false;
        $this->delete = false;
        unset($this->name, $this->duration, $this->price, $this->service_id);
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function render()
    {
        if ($this->search) {
            $services = Service::where('name', 'like', '%' . $this->search . '%')->paginate(5);
        } else {
            $services = Service::paginate(5);
        }

        return view('livewire.services', compact('services'));
    }
}
