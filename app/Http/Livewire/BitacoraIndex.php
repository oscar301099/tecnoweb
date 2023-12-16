<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bitacora;
use App\Models\User;

class BitacoraIndex extends Component
{

    public $search = '';

    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $bitacoras = Bitacora::where('id', 'LIKE' , '%' . $this->search . '%')->orwhere('ip','LIKE' , '%' . $this->search . '%')->orwhere('afectado','LIKE' , '%' . $this->search . '%')->orwhere('fecha_h','LIKE' , '%' . $this->search . '%')->orwhere('accion','LIKE' , '%' . $this->search . '%')->orwhere('apartado','LIKE' , '%' . $this->search . '%')->paginate(20);

        return view('livewire.bitacora-index', compact('bitacoras'));
    }
}
