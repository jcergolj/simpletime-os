@props([
    'route',
    'icon',
    'title',
    'description',
])

<a href="{{ route($route) }}" class="flex items-center px-6 py-4">
    <div class="flex-shrink-0">
        @php
            $iconComponent = 'heroicon-o-' . $icon;
        @endphp
        <x-dynamic-component :component="$iconComponent" class="h-6 w-6 text-gray-400" />
    </div>
    <div class="ml-4 flex-1">
        <h3 class="text-sm font-medium text-gray-900">{{ $title }}</h3>
        <p class="text-sm text-gray-500">{{ $description }}</p>
    </div>
    <div class="flex-shrink-0">
        <x-heroicon-o-chevron-right class="h-5 w-5 text-gray-400" />
    </div>
</a>
