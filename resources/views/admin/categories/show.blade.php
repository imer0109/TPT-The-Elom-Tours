@extends('admin.layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de la catégorie</h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Modifier
            </a>
            <a href="{{ route('admin.categories.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la catégorie</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nom</th>
                                    <td>{{ $category->nom }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $category->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $category->description ?: 'Aucune description' }}</td>
                                </tr>
                                <tr>
                                    <th>Statut</th>
                                    <td>
                                        @if($category->est_actif)
                                        <span class="badge badge-success">Actif</span>
                                        @else
                                        <span class="badge badge-danger">Inactif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date de création</th>
                                    <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Dernière modification</th>
                                    <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Circuits associés</h6>
                </div>
                <div class="card-body">
                    @if($category->circuits->count() > 0)
                    <ul class="list-group">
                        @foreach($category->circuits as $circuit)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.circuits.show', $circuit) }}">{{ $circuit->titre }}</a>
                            <span class="badge badge-primary badge-pill">{{ $circuit->prix }} €</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center">Aucun circuit associé à cette catégorie.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection