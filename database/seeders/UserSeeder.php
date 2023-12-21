<?php

namespace Database\Seeders;

use App\Models\Carrito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Configuration;
use App\Models\Deseo;
use App\Models\detalle_pedido;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Promocion;
use App\Models\Proveedor;
use App\Models\Tipo_envio;
use App\Models\Tipo_pago;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Configuration::create([
            'razon_social' => 'Quality Store',
            'factura' => '123456789',
            'email' => 'QualityStore@gmail.com',
            'telefono' => '78416172',
            'whatsapp' => 'https://wa.me/59178416172',
            'direccion' => '4to anillo, Feria Barrio Lindo',
            'responsable' => 'Administrador'
        ]);

        $user1 = User::create([
            'name' => 'Edilson Ortiz Serrano',
            'email' => 'edilson@gmail.com',
            'password' => bcrypt('12345678'),
            'tipo' => 'Administrador'
        ])->assignRole('Admin');

        // Crear un carrito asociado al nuevo usuario
        Carrito::create([
            'cliente_id' => $user1->id,
            'total' => 0,
        ]);


        $user2 = User::create([
            'name' => 'Karla Meneses',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('12345678'),
            'tipo' => 'Empleado',
            'direccion' => 'Pampa de la Isla',
            'telefono' => '785958930',
            'ci' => '202020',
            'sueldo' => 2400,
            'cargo' => 'Encargado de Ventas'
        ])->assignRole('Empleado');

        // Crear un carrito asociado al nuevo usuario
        Carrito::create([
            'cliente_id' => $user2->id,
            'total' => 0,
        ]);



        $user3 = User::create([
            'name' => 'Oscar Oros',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('12345678'),
            'direccion' => 'Plan 3k',
            'telefono' => '785222930',
            'ci' => '2028590',
            'tipo' => 'Cliente'
        ])->assignRole('Cliente');

        // Crear un carrito asociado al nuevo usuario
        Carrito::create([
            'cliente_id' => $user3->id,
            'total' => 0,
        ]);
        Deseo::create([
            'cliente_id' => $user3->id,
            'total' => 0,
        ]);


        $user4 = User::create([
            'name' => 'Karla Meneses',
            'email' => 'dipomo5692@dpsols.com',
            'password' => bcrypt('12345678'),
            'direccion' => 'El Urubo',
            'telefono' => '67816051',
            'ci' => '9674845',
            'tipo' => 'Cliente'
        ])->assignRole('Cliente');

        // Crear un carrito asociado al nuevo usuario
        Carrito::create([
            'cliente_id' => $user4->id,
            'total' => 0,
        ]);


        // Categoria::create([
        //     'nombre' => 'Electrodomesticos'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Muebles'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Ropa'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Juguetes'
        // ]);


        // Categoria::create([
        //     'nombre' => 'Herramientas'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Limpieza'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Cocina'
        // ]);

        // Categoria::create([
        //     'nombre' => 'Bebidas'
        // ]);

        Categoria::create([
            'nombre' => 'Zapatos Deportivos',
        ]);

        Categoria::create([
            'nombre' => 'Zapatos Casuales',
        ]);

        Categoria::create([
            'nombre' => 'Zapatos Formales',
        ]);

        Categoria::create([
            'nombre' => 'Sandalias',
        ]);

        Categoria::create([
            'nombre' => 'Botas',
        ]);

        Categoria::create([
            'nombre' => 'Zapatillas',
        ]);

        Categoria::create([
            'nombre' => 'Zapatos de Tacón',
        ]);

        Categoria::create([
            'nombre' => 'Zapatos para Niños',
        ]);



        // Marca::create([
        //     'nombre' => 'Samsung'
        // ]);

        // Marca::create([
        //     'nombre' => 'LG'
        // ]);

        // Marca::create([
        //     'nombre' => 'Xiaomi'
        // ]);

        // Marca::create([
        //     'nombre' => 'Lego'
        // ]);

        // Marca::create([
        //     'nombre' => 'Toy House'
        // ]);

        // Marca::create([
        //     'nombre' => 'Arpel'
        // ]);


        // Marca::create([
        //     'nombre' => 'Nike'
        // ]);


        // Marca::create([
        //     'nombre' => 'Adidas'
        // ]);

        // Marca::create([
        //     'nombre' => 'Huggies'
        // ]);

        // Marca::create([
        //     'nombre' => 'Glad'
        // ]);

        // Marca::create([
        //     'nombre' => 'SRC'
        // ]);

        // Marca::create([
        //     'nombre' => 'Nailpolish'
        // ]);

        // Marca::create([
        //     'nombre' => 'Tramontina'
        // ]);

        // Marca::create([
        //     'nombre' => 'Puma'
        // ]);

        // Marca::create([
        //     'nombre' => 'Caterpillar'
        // ]);

        Marca::create([
            'nombre' => 'Nike',
        ]);

        Marca::create([
            'nombre' => 'Adidas',
        ]);

        Marca::create([
            'nombre' => 'Puma',
        ]);

        Marca::create([
            'nombre' => 'Reebok',
        ]);

        Marca::create([
            'nombre' => 'Converse',
        ]);

        Marca::create([
            'nombre' => 'Vans',
        ]);

        Marca::create([
            'nombre' => 'New Balance',
        ]);

        Marca::create([
            'nombre' => 'Skechers',
        ]);

        Marca::create([
            'nombre' => 'Clarks',
        ]);

        Marca::create([
            'nombre' => 'Dr. Martens',
        ]);

        Marca::create([
            'nombre' => 'Timberland',
        ]);

        Marca::create([
            'nombre' => 'Fila',
        ]);

        Marca::create([
            'nombre' => 'Asics',
        ]);

        Marca::create([
            'nombre' => 'Under Armour',
        ]);

        Marca::create([
            'nombre' => 'Salomon',
        ]);

        Marca::create([
            'nombre' => 'Crocs',
        ]);


        Proveedor::create([
            'nombre' => 'Juan Perez',
            'direccion' => 'Los Lotes',
            'telefono' => '745689258'
        ]);

        Proveedor::create([
            'nombre' => 'Luis Lopez',
            'direccion' => 'La cuchilla',
            'telefono' => '78024256'
        ]);

        Proveedor::create([
            'nombre' => 'Xoca Suarez',
            'direccion' => 'Las Palmas',
            'telefono' => '73024578'
        ]);

        Proveedor::create([
            'nombre' => 'Juana Barrios',
            'direccion' => 'El Quior',
            'telefono' => '78036987'
        ]);

        Proveedor::create([
            'nombre' => 'Lucas Gutierrez',
            'direccion' => 'Pampa de la Isla',
            'telefono' => '780245398'
        ]);

        Proveedor::create([
            'nombre' => 'Luiza Mendoza',
            'direccion' => 'Plan 3000',
            'telefono' => '78235896'
        ]);

        Proveedor::create([
            'nombre' => 'Julio Plata',
            'direccion' => 'Guapurú 1',
            'telefono' => '78023612'
        ]);

        Proveedor::create([
            'nombre' => 'Eduardo Castillo',
            'direccion' => 'Plan 4000',
            'telefono' => '780146325'
        ]);

        Proveedor::create([
            'nombre' => 'David Zeballos',
            'direccion' => '2do anillo',
            'telefono' => '78024269'
        ]);

        Proveedor::create([
            'nombre' => 'Felipe Gonzales',
            'direccion' => '6to anillo',
            'telefono' => '78025214'
        ]);

        Proveedor::create([
            'nombre' => 'Victoria Cruz',
            'direccion' => '4to anillo la feria',
            'telefono' => '78024532'
        ]);

        Proveedor::create([
            'nombre' => 'Antonio Sosa',
            'direccion' => '3er anillo externo',
            'telefono' => '78326111'
        ]);

        Proveedor::create([
            'nombre' => 'Jose Mamani',
            'direccion' => '3er anillo interno',
            'telefono' => '78302651'
        ]);

        Proveedor::create([
            'nombre' => 'Jhon Niuman',
            'direccion' => 'av.pirai',
            'telefono' => '78362489'
        ]);

        Proveedor::create([
            'nombre' => 'Oscar Oros',
            'direccion' => 'Pampa de la isla 6to anillo',
            'telefono' => '78065499'
        ]);

        Tipo_envio::create([
            'nombre' => 'Pedidos YA',
            'descripcion' => 'Delivery de color rojo'
        ]);

        Tipo_envio::create([
            'nombre' => 'Radio Movil Vallegrande',
            'descripcion' => 'radio movil ubicado en el Barrio Villa Warnes'
        ]);

        Tipo_envio::create([
            'nombre' => 'Yaigo',
            'descripcion' => 'Delivery de color lila'
        ]);


        Tipo_pago::create([
            'nombre' => 'Qr',
            'descripcion' => 'Pago billitera Movil Pago Facil'
        ]);

        Tipo_pago::create([
            'nombre' => 'Al contado',
            'descripcion' => 'Pago en mano, ese preciso momento'
        ]);

      
        // Promocion::create([
        //     'nombre' => 'Dia del Padre',
        //     'porcentaje' => 10
        // ]);

        // Promocion::create([
        //     'nombre' => 'Dia de la Madre',
        //     'porcentaje' => 10
        // ]);

        // Promocion::create([
        //     'nombre' => 'Dia del niño',
        //     'porcentaje' => 5
        // ]);

        // Promocion::create([
        //     'nombre' => 'Cumpleaños',
        //     'porcentaje' => 8
        // ]);






        Producto::create([
            'nombre' => 'Zapato femenino de vestir',
            'descripcion' => 'Zapato alto con taco ancho',
            'precio' =>  0.10,
            'stock' => 70,
            'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/BrownDressShoe/BrownDressShoe.spin',
            'categoria_id' => 3,
            'marca_id' => 7,
        ]);

        Producto::create([
            'nombre' => 'Tennis Nike rojo D455',
            'descripcion' => 'Tennis Nike rojo D455',
            'precio' =>  0.25,
            'stock' => 100,
            'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/NikeZoom/NikeZoom.spin',
            'categoria_id' => 3,
            'marca_id' => 7,
        ]);

        Producto::create([
            'nombre' => 'Tennis Puma morado L45',
            'descripcion' => 'Tennis Puma morado L45',
            'precio' =>  0.30,
            'stock' => 50,
            'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/PUMA/PUMA.spin',
            'categoria_id' => 3,
            'marca_id' => 14,
        ]);

        Producto::create([
            'nombre' => 'Tennis deportivo Gray',
            'descripcion' => 'Tennis deportivo Gray',
            'precio' =>  0.30,
            'stock' => 70,
            'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/RunnigShoe/RunnigShoe.spin',
            'categoria_id' => 3,
            'marca_id' => 7,
        ]);

        Producto::create([
            'nombre' => 'Zapato caterpillar f45',
            'descripcion' => 'Zapato caterpillar f45',
            'precio' => 0.50,
            'stock' => 100,
            'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/Timberland/Timberland.spin',
            'categoria_id' => 3,
            'marca_id' => 15,
        ]);

        Producto::create([
            'nombre' => 'Zapatilla colorful 38',
            'descripcion' => 'Zapatilla colorful 38',
            'precio' =>  0.32,
            'stock' => 50,
            'imagen' => 'https://rerroevi.sirv.com/Samples%20by%20Industry/Shoes/StarWarsShoe/StarWarsShoe.spin',
            'categoria_id' => 3,
            'marca_id' => 7,
        ]);



        // Producto::create([
        //     'nombre' => 'Tenis',
        //     'descripcion' => 'Zapatos deportivos',
        //     'precio' => 0.10,
        //     'stock' => 50,
        //     'imagen' => 'https://www.360-javascriptviewer.com/embed?presentation=eyJtYWluSW1hZ2VVcmwiOiJodHRwczovL2NkbjEuMzYwLWphdmFzY3JpcHR2aWV3ZXIuY29tL2ltYWdlcy9ibHVlLXNob2Utc21hbGwvMjAxODA5MDYtMDAxLWJsYXV3LmpwZyIsImxpY2Vuc2UiOiIiLCJzcGVlZCI6OTAsImltYWdlVXJsRm9ybWF0IjoiMjAxODA5MDYtMHh4LWJsYXV3LmpwZyIsImZpcnN0SW1hZ2VOdW1iZXIiOjEsImluZXJ0aWEiOjEyLCJyZXZlcnNlIjp0cnVlLCJ6b29tIjp0cnVlLCJpbWFnZVVybHMiOltdLCJ0b3RhbEZyYW1lcyI6NzIsInN0YXJ0RnJhbWVObyI6MSwiYXV0b1JvdGF0ZSI6MSwiYXV0b1JvdGF0ZVNwZWVkIjowLCJhdXRvUm90YXRlUmV2ZXJzZSI6ZmFsc2UsInN0b3BBdEVkZ2VzIjpmYWxzZSwiYXV0b0NETlJlc2l6ZXIiOnRydWUsIm5vdGlmaWNhdGlvbkNvbmZpZyI6eyJkcmFnVG9Sb3RhdGUiOnsic2hvd1N0YXJ0VG9Sb3RhdGVEZWZhdWx0Tm90aWZpY2F0aW9uIjp0cnVlLCJtYWluQ29sb3IiOiJyZ2JhKDAsMCwwLDAuMjApIiwidGV4dENvbG9yIjoicmdiYSgyNDMsMjM3LDIzNywwLjgwKSJ9fX0=',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Zapato femenino',
        //     'descripcion' => 'Zapato alto con taco ancho',
        //     'precio' => 0.15,
        //     'stock' => 50,
        //     'imagen' => 'https://360viewpro.com/360/Iconasys-Turntable/360%20View%20Pro/Sample/Woman%20Shoe/Woman-Shoe-View/iframe.html',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Reloj',
        //     'descripcion' => 'Hecho de plata',
        //     'precio' => 0.05,
        //     'stock' => 20,
        //     'imagen' => 'https://360viewpro.com/360/Iconasys-Turntable/360%20View%20Pro/Sample/Watch/Watch-View/iframe.html',
        //     'categoria_id' => 3,
        //     'marca_id' => 1,
        // ]);

        // Producto::create([
        //     'nombre' => 'Taco',
        //     'descripcion' => 'Zapato de taco alto y en punta',
        //     'precio' => 165,
        //     'stock' => 30,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Fashion/Pinkheel/Pinkheel.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Pañales',
        //     'descripcion' => 'Articulo de limpieza para las neceidades humanas',
        //     'precio' => 0.3,
        //     'stock' => 100,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/CPG/Diapers/Diapers.spin',
        //     'categoria_id' => 6,
        //     'marca_id' => 9,
        // ]);

        // Producto::create([
        //     'nombre' => 'Tappers',
        //     'descripcion' => 'Articulo para almacenar comida',
        //     'precio' => 26.5,
        //     'stock' => 60,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/CPG/Freezerware/Freezerware.spin',
        //     'categoria_id' => 7,
        //     'marca_id' => 10,
        // ]);

        // Producto::create([
        //     'nombre' => 'Taladro',
        //     'descripcion' => 'Articulo de Albañileria',
        //     'precio' => 250,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Industrial/Drill/Drill.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 3,
        // ]);

        // Producto::create([
        //     'nombre' => 'Vino',
        //     'descripcion' => 'Botella de vino tinto',
        //     'precio' => 30,
        //     'stock' => 100,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/CPG/Wine/Wine.spin',
        //     'categoria_id' => 8,
        //     'marca_id' => 11,
        // ]);

        // Producto::create([
        //     'nombre' => 'Pinta Uñas',
        //     'descripcion' => 'Pintura para uñas',
        //     'precio' => 5,
        //     'stock' => 50,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/CPG/Nailpolish/Nailpolish.spin',
        //     'categoria_id' => 6,
        //     'marca_id' => 12,
        // ]);

        // Producto::create([
        //     'nombre' => 'Alicate',
        //     'descripcion' => 'Herramienta de metal para electricidad',
        //     'precio' => 25,
        //     'stock' => 30,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Electrical/Klein%20Tools/Klein%20Tools.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Multimetro- tester',
        //     'descripcion' => 'Test de electricidad',
        //     'precio' => 200,
        //     'stock' => 10,
        //     'imagen' => ' https://rerroevi.sirv.com/Website/Electrical/Southwire/Southwire.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Medidor electrico',
        //     'descripcion' => 'Caja de medidor electrico',
        //     'precio' => 50,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Samples%20by%20Industry/Electrical/SiemensSwitch2/SiemensSwitch2.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Manometro',
        //     'descripcion' => 'Instrumento de medición para la presión',
        //     'precio' => 100,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Samples%20by%20Industry/Electrical/DwyerElectrical/DwyerElectrical.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Interruptor-palanca',
        //     'descripcion' => 'Palanca para caja electrica',
        //     'precio' => 35,
        //     'stock' => 25,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Electrical/CircuitBreaker/CircuitBreaker.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Reflector led',
        //     'descripcion' => 'Iluminacion LED de jardines',
        //     'precio' => 50,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Electrical/Cree/Cree.spin',
        //     'categoria_id' => 5,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Gafas',
        //     'descripcion' => 'Gafas de sol',
        //     'precio' => 100,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Fashion/Sunglasses/Sunglasses.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 5,
        // ]);

        // Producto::create([
        //     'nombre' => 'Camiseta',
        //     'descripcion' => 'Camiseta de mujer',
        //     'precio' => 120,
        //     'stock' => 50,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Fashion/Tanktop/Tanktop.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Cartera',
        //     'descripcion' => 'Cartera de mujer',
        //     'precio' => 200,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Fashion/Pinkpurse/Pinkpurse.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => ' Bolso',
        //     'descripcion' => 'Bolso rojo',
        //     'precio' => 150,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Fashion/Ebags/Ebags.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 8,
        // ]);

        // Producto::create([
        //     'nombre' => 'Zapato',
        //     'descripcion' => 'Zapato de vestir',
        //     'precio' => 200,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/BrownDressShoe/BrownDressShoe.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Tennis',
        //     'descripcion' => 'Tennis nike rojo D455',
        //     'precio' => 250,
        //     'stock' => 20,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/NikeZoom/NikeZoom.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Tennis',
        //     'descripcion' => 'Tennis puma morado L45',
        //     'precio' => 300,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/PUMA/PUMA.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 14,
        // ]);

        // Producto::create([
        //     'nombre' => 'Tennis',
        //     'descripcion' => 'Tennis deportivo Gray',
        //     'precio' => 300,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/RunnigShoe/RunnigShoe.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Zapato',
        //     'descripcion' => 'Zapato caterpillar f45',
        //     'precio' => 500,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Footwear/Timberland/Timberland.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 15,
        // ]);

        // Producto::create([
        //     'nombre' => 'Zapatilla',
        //     'descripcion' => ' Zapatilla colorful 38',
        //     'precio' => 320,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Samples%20by%20Industry/Shoes/StarWarsShoe/StarWarsShoe.spin',
        //     'categoria_id' => 3,
        //     'marca_id' => 7,
        // ]);

        // Producto::create([
        //     'nombre' => 'Licuadora',
        //     'descripcion' => 'Licuadora smarthouse',
        //     'precio' => 600,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Animations/InstantPot%20Blender/InstantPot%20Blender.spin',
        //     'categoria_id' => 1,
        //     'marca_id' => 1,
        // ]);

        // Producto::create([
        //     'nombre' => 'Freidora',
        //     'descripcion' => 'Freidora eléctrica mabe',
        //     'precio' => 300,
        //     'stock' => 15,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Animations/InstantPot%20Air%20Fryer/InstantPot%20Air%20Fryer.spin',
        //     'categoria_id' => 1,
        //     'marca_id' => 1,
        // ]);

        // Producto::create([
        //     'nombre' => 'Juego de ollas',
        //     'descripcion' => 'Juego de ollas rojas',
        //     'precio' => 100,
        //     'stock' => 25,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Home%20Goods/Pots/Pots.spin',
        //     'categoria_id' => 7,
        //     'marca_id' => 13,
        // ]);

        // Producto::create([
        //     'nombre' => 'Batidora eléctrica',
        //     'descripcion' => 'Batidora eléctrica roja',
        //     'precio' => 300,
        //     'stock' => 10,
        //     'imagen' => 'https://rerroevi.sirv.com/Website/Home%20Goods/Mixer/Mixer.spin',
        //     'categoria_id' => 1,
        //     'marca_id' => 2,
        // ]);
    }
}