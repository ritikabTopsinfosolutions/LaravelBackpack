<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\ProductRequest;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
        CRUD::field([
            'name' => 'name',
            'label' => 'Product name',
          ]);
        CRUD::field([
            'name' => 'price',
            'type' => 'number',
            'label' => 'Product price',
            'prefix' => '$',
          ]);
        CRUD::field('image')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'uploads', // the path inside the disk where file will be stored
            ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'image', // The db column name
            'label' => "Product Image", // Table column heading
            'type' => 'image',
            'prefix' => '/uploads/',
            'disk' => 'public', 
            'height' => '50px',
            'width' => '50px',
          ]);
          CRUD::column('name')->label("Product Name");
          CRUD::column('sku')->label("Product SKU");
          CRUD::column('category')->label("Product category");
          CRUD::column('category')->wrapper([
            'href' => function($crud, $column, $entry){
                return backpack_url(path: 'category/' . $entry->id. '/show');
            },
          ]);
          CRUD::column('in_stock')->label("Is Product in Stock");
          CRUD::addColumn([
            'name'    => 'description',
            'label'   => 'Description',
            'type'    => 'text',
            'escaped' => false, // Allows HTML to render
        ]);
          CRUD::column('in_stock')->wrapper([
            'class' => function($crud, $column, $entry){
                return match ($entry->in_stock) {
                    'No' => 'badge bg-warning',
                    'Yes' => 'badge bg-success', 
                };
            },
          ]);
      
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
       // CRUD::setFromDb(); // set fields from db columns.
        CRUD::setValidation(ProductRequest::class);
        CRUD::field("name");
        CRUD::field("sku");
        CRUD::field("price");
        CRUD::field("image")
            ->type("upload")
            ->lable("Image")
            ->withFiles([
                "disk" => "public",
            ]);
        CRUD::field("product_type");
        CRUD::field("category");
        CRUD::field("in_stock");
        CRUD::field([
            'name'  => 'description', // the db column name
            'label' => 'description',
            'type'  => 'textarea', // set as a simple textarea initially
        ]);
        // dd($this->crud->fields());
        // CRUD::field([
        //     'name' => 'description',
        //     'type' => 'ckeditor',
        //     'custom_build' => [
        //         resource_path('assets/ckeditor/ckeditor.js'),
        //         resource_path('assets/ckeditor/ckeditor-init.js'),
        //     ],
        // ]);
        // CRUD::addColumn([  
        //         'label'     => "Category",
        //         'type'      => 'select',
        //         'name'      => 'category_id', // The column in the products table
        //         'entity'    => 'category', // The relationship method name
        //         'model'     => "App\Models\Category", 
        //         'attribute' => 'name', // Column in the related table (categories)
        //         'options'   => (function ($query) {
        //             return $query->orderBy('name', 'ASC')->get();
        //         }),
        //     ]);
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        // CRUD::column("name")
        //     ->tab("Content")
        //     ->label("Product Name");
        // CRUD::column("description")
        //     ->tab("Content")
        //     ->label("Product Description");
        
        // CRUD::column('in_stock')
        // ->tab("General");
    }
}
