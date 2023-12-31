<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Producto;
use Livewire\WithPagination;
use Livewire\Component;

class ProductosP extends Component
{
    public $search = '';
    use WithPagination;
    public $pedido_id;
    public $accion = 'carrito'; // Por defecto, agregar al carrito

    // public function mount($pedido)
    public function mount($pedido)
    {
        $this->pedido_id = $pedido->id;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function agregarAlCarrito()
    {
        $this->accion = 'carrito';
    }

    public function agregarADeseos()
    {
        $this->accion = 'deseos';
    }

// Componente Livewire
public function setAccion($accion)
{
    $this->accion = $accion;
}


    public function render()
    {
        $pedido = Pedido::where('id', $this->pedido_id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $productos = Producto::where('nombre', 'LIKE', '%' . $this->search . '%')->paginate(3);

        return view('livewire.productosP', compact('productos', 'pedido', 'categorias', 'marcas'));
    }
}
