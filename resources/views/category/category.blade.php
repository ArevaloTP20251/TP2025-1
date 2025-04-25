@extends('include.master') <!-- Herada plantilla base -->

<!-- Contenido visual que se usan en el master.blade.php -->
@section('title','Inventory | Categorías')

@section('page-title','Lista de categorías')

<!-- Lo que se vera en pantalla -->
@section('content')

<div class="row clearfix"> 
    <!-- Laravel + Vue esta integrado por eso en vez de escribir HTML -->
    <!-- Usa el componente que vive en  resources/assets/js/components/CreateCategory.vue -->
    <create-category></create-category> 
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <!-- Abre el modal definido en crea -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-category">
                        Nueva categoría
                    </button>
                </h2>
            </div>

            <view-category></view-category>

        </div>
    </div>
</div>

@endsection

@push('script')

<!-- Archivo adicional que puede tener funciones para manejo de eventos, modales o conexión con Vue. -->
<script type="text/javascript" src="{{ url('public/js/category.js') }}"></script>

@endpush