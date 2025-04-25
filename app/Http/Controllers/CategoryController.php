<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('category.category'); // Retorna la vista de categorias
  }

  public function CategoryList(Request $request) // Recibe obj request = datos enviados desde el navegador
  {
    $category = Category::orderBy('name', 'ASC'); // Construimos la consulta
    if ($request->name != '') { // Verfica que el campo name fue enviado en el request
      $category->where('name', 'LIKE', '%' . $request->name . '%'); // Agrega una condicion a la consulta para que filtre las categorias similares
    }
    $category = $category->paginate(10); // Devuelve los resultados de 10 en 10

    return $category; // Retorna el resultado (JSON) y esto se mostrara en el front
  }



  public function AllCategory()
  {
    $cat   = Category::all(); // Recupera todas las categorias en un array
    return $cat;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) // Almacena una nueva categoria
  {
    // Llamamos al validador integrado de Laravel
    $request->validate([
      'name' => 'required|unique:categories' // El campo name es obligatorio y que no exista en la tabla
    ]);

    try {
      $category = new Category; // Crea una nueva instancia del modelo Category

      $category->name = $request->name; // name = name ingresado por el user

      $category->save(); // Guardamos el obj en la db 

      return response()->json(['status' => 'success', 'message' => 'Categoría agregada']); 
    } catch (\Exception $e) {

      return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category) // Recibe automaticamente un obj Category
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category) // Recibe automaticamente un obj Category
  {
    // Laravel usa Route Model Binding, lo que significa que si en la ruta recibe un ID: 
      // Busca automaticamente el registro en la tabla categorias
      // Si lo encuentra, lo inyecta en categoria
      // Si no error 404
    return $category;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|unique:categories,name,' . $id,
    ]);

    try {
      $category = Category::find($id);
      $category->name = $request->name;
      $category->update();

      return response()->json(['status' => 'success', 'message' => 'Categoría actualizada']);
    } catch (\Exception $e) {

      return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $category = Category::find($id);
    $check = Product::where('category_id', '=', $category->id)->count();

    if ($check > 0) {

      return response()->json(['status' => 'error', 'message' => 'Esta categoría no esta vacía, debe eliminar primero los productos']);
    }
    try {

      $category->delete();

      return response()->json(['status' => 'success', 'message' => 'Categoría eliminada']);
    } catch (\Exception $e) {

      return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
    }
  }
}
