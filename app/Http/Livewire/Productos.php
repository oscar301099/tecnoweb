<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Livewire\WithPagination;
use Livewire\Component;

class Productos extends Component
{
    public $search = '';
    use WithPagination, WithoutModelEvents;
    public $idpedido;
    //public $accion; // Por defecto, agregar al carrito

   // public $cantidad;
   // public $productoId;
    // public function mount($pedido)
    public function mount()
    {
        //$this->pedido_id = $pedido->id;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        // $pedido = Pedido::where('id', $this->pedido_id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $productos = Producto::where('nombre', 'LIKE', '%' . $this->search . '%')->paginate(3);
        // return view('livewire.productos', compact('productos','pedido', 'categorias', 'marcas'));
        return view('livewire.productos', compact('productos', 'categorias', 'marcas'));
    }

    // public function agregarAlCarrito()
    // {
    //     $this->accion = 'carrito';
    // }

    // public function agregarADeseos()
    // {
    //     $this->accion = 'deseos';
    // }
    // // Componente Livewire
    // public function setAccion($accion)
    // {
    //     $this->accion = $accion;
    // }

    // Componente Livewire
    // public function storeC()
    // {
    //     //$formData = $this->get();

    //     // Ahora puedes acceder a $formData['cantidad'] u otros campos según sea necesario
    //     //  $cantidad = $formData['cantidad'];
    //     // Acceder a los datos del formulario
    //     $productoId = $this->productoId;
    //     $idpedido = $this->idpedido;
    //     $cantidad = $this->cantidad;
    //     $accion = $this->accion;
    //     dd("carrito: " . $this->accion .  $cantidad. $this->cantidad. $productoId);
    //     // Lógica para agregar a carrito o deseos...

    //     if ($this->accion == 'carrito') {
    //         // Lógica para agregar a carrito...

    //         // Redirección al controlador correspondiente
    //         return redirect()->route('carritoController'); // Reemplaza 'carritoController' con el nombre de tu controlador
    //     } elseif ($this->accion == 'deseos') {
    //         // Lógica para agregar a deseos...

    //         // Redirección al controlador correspondiente
    //         return redirect()->route('deseosController'); // Reemplaza 'deseosController' con el nombre de tu controlador
    //     }
    // }
}
