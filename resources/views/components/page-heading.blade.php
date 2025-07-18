@props(['title' => '', 'subtitle' => null])

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>

    <div>
        {{ $slot }}
    </div>
</div>
