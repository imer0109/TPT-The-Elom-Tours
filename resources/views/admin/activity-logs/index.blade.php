@extends('layouts.admin')

@section('title', "JOURNAL D'ACTIVITÉS - THE ELOM TOURS")

@section('content')
<div class="px-4">
	<div class="flex items-center justify-between mt-4 mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-900">Journal d'activités</h1>
			<p class="text-sm text-gray-500 mt-1">Historique des actions système et utilisateurs</p>
		</div>
	</div>

	<!-- Toolbar / Filters (placeholder for future filters) -->
	<div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
			<div>
				<label class="block text-xs font-medium text-gray-600 mb-1">Recherche</label>
				<input type="text" placeholder="Rechercher dans la description..." class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" disabled>
			</div>
			<div>
				<label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
				<select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" disabled>
					<option>Toutes</option>
				</select>
			</div>
			<div>
				<label class="block text-xs font-medium text-gray-600 mb-1">Utilisateur</label>
				<select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" disabled>
					<option>Tous</option>
				</select>
			</div>
		</div>
	</div>

	<!-- Logs List -->
	<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
		<div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
			<div class="col-span-3">Date</div>
			<div class="col-span-2">Utilisateur</div>
			<div class="col-span-2">Action</div>
			<div class="col-span-3">Description</div>
			<div class="col-span-1">Type</div>
			<div class="col-span-1 text-right">Voir</div>
		</div>

		@forelse($logs as $log)
			<div class="grid grid-cols-1 md:grid-cols-12 gap-3 px-4 py-4 border-b border-gray-100 items-center">
				<div class="md:col-span-3 text-gray-900">
					<span class="font-medium">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
				</div>
				<div class="md:col-span-2 text-gray-700">
					<span class="inline-flex items-center">
						<i class="fas fa-user text-gray-400 mr-2"></i>
						{{ $log->user ? $log->user->name : 'Système' }}
					</span>
				</div>
				<div class="md:col-span-2">
					<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
						{{ strtolower($log->action) === 'create' ? 'bg-green-100 text-green-700' : '' }}
						{{ strtolower($log->action) === 'update' ? 'bg-yellow-100 text-yellow-700' : '' }}
						{{ strtolower($log->action) === 'delete' ? 'bg-red-100 text-red-700' : '' }}
						{{ !in_array(strtolower($log->action), ['create','update','delete']) ? 'bg-gray-100 text-gray-700' : '' }}">
						{{ ucfirst($log->action) }}
					</span>
				</div>
				<div class="md:col-span-3 text-gray-700">
					{{ $log->description }}
				</div>
				<div class="md:col-span-1 text-gray-600">
					{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}
				</div>
				<div class="md:col-span-1 flex md:justify-end">
					<a href="{{ route('admin.activity-logs.show', $log->id) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md bg-gray-800 text-white hover:bg-gray-700">
						<i class="fas fa-eye mr-1"></i> Voir
					</a>
				</div>
			</div>
		@empty
			<div class="p-6 text-center text-gray-500">Aucun log d'activité trouvé</div>
		@endforelse
	</div>

	<!-- Pagination -->
	<div class="flex justify-center mt-6">
		{{ $logs->links() }}
	</div>
</div>
@endsection
