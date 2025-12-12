@props([
    'title',
    'description',
])

<div class="text-center py-4 mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
    <p class="text-gray-600">{{ $description }}</p>
</div>
