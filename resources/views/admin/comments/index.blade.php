@extends('layouts.admin')

@section('title', 'COMMENTAIRES DU BLOG - THE ELOM TOURS')

@section('content')
<div class="px-4">
	<div class="flex items-center justify-between mt-4 mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-900">Commentaires du blog</h1>
			<p class="text-sm text-gray-500 mt-1">Modérez les commentaires laissés sur les articles</p>
		</div>
	</div>

	<!-- Filtres -->
	<div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
		<form method="GET" action="{{ route('admin.comments.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3">
			<div class="md:col-span-3">
				<label for="status" class="block text-xs font-medium text-gray-600 mb-1">Statut</label>
				<select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
					<option value="">Tous</option>
					<option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>En attente</option>
					<option value="approved" {{ request('status')==='approved' ? 'selected' : '' }}>Approuvés</option>
				</select>
			</div>
			<div class="md:col-span-6">
				<label for="search" class="block text-xs font-medium text-gray-600 mb-1">Recherche</label>
				<div class="relative">
					<span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-search"></i></span>
					<input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nom, email ou contenu" class="w-full border border-gray-300 rounded-md pl-9 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
				</div>
			</div>
			<div class="md:col-span-3 flex items-end space-x-2">
				<button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white text-sm font-medium hover:bg-green-700"><i class="fas fa-filter mr-2"></i>Filtrer</button>
				<a href="{{ route('admin.comments.index') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200"><i class="fas fa-undo mr-2"></i>Réinitialiser</a>
			</div>
		</form>
	</div>

	<!-- Liste des commentaires -->
	<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
		<div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
			<div class="col-span-2">Date</div>
			<div class="col-span-2">Nom</div>
			<div class="col-span-2">Email</div>
			<div class="col-span-2">Article</div>
			<div class="col-span-3">Contenu</div>
			<div class="col-span-1 text-right">Actions</div>
		</div>

		@forelse($comments as $comment)
			<div class="grid grid-cols-1 md:grid-cols-12 gap-3 px-4 py-4 border-b border-gray-100 items-start">
				<div class="md:col-span-2 text-gray-900 text-sm">{{ $comment->created_at?->format('d/m/Y H:i') ?? '-' }}</div>
				<div class="md:col-span-2 text-gray-900 text-sm font-medium">{{ $comment->name }}</div>
				<div class="md:col-span-2 text-gray-600 text-sm">{{ $comment->email }}</div>
				<div class="md:col-span-2 text-sm">
					@if($comment->blogPost)
						<a href="{{ route('blog.show', $comment->blogPost->slug) }}" target="_blank" class="text-green-700 hover:text-green-900">{{ Str::limit($comment->blogPost->title, 40) }}</a>
					@else
						<span class="text-gray-400">—</span>
					@endif
				</div>
				<div class="md:col-span-3 text-gray-700 text-sm">{{ Str::limit($comment->comment, 120) }}</div>
				<div class="md:col-span-1 flex md:justify-end space-x-2">
					@if(!$comment->is_approved)
						<form action="{{ route('admin.comments.approve', $comment) }}" method="POST" onsubmit="return confirm('Approuver ce commentaire ?')">
							@csrf
							@method('PATCH')
							<button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-green-600 text-white hover:bg-green-700" title="Approuver"><i class="fas fa-check mr-1"></i>Approuver</button>
						</form>
					@else
						<form action="{{ route('admin.comments.disapprove', $comment) }}" method="POST" onsubmit="return confirm('Mettre ce commentaire en attente ?')">
							@csrf
							@method('PATCH')
							<button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600" title="Mettre en attente"><i class="fas fa-ban mr-1"></i>En attente</button>
						</form>
					@endif
					<form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
						@csrf
						@method('DELETE')
						<button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-red-600 text-white hover:bg-red-700" title="Supprimer"><i class="fas fa-trash mr-1"></i>Supprimer</button>
					</form>
				</div>
				<div class="md:col-span-12 text-xs mt-1">
					<span class="px-2 py-0.5 rounded-full {{ $comment->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $comment->is_approved ? 'Approuvé' : 'En attente' }}</span>
				</div>
			</div>
		@empty
			<div class="p-6 text-center text-gray-500">Aucun commentaire trouvé.</div>
		@endforelse
	</div>

	<!-- Pagination -->
	<div class="flex justify-center mt-6">
		{{ $comments->links() }}
	</div>
</div>
@endsection
