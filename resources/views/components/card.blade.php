<div {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6']) }}>
    @if ($header)
        <div class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
            {{ $header }}
        </div>
    @endif

    {{ $body ?? $slot }}
</div>
