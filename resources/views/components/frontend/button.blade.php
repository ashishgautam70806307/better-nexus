{{-- Example: <x-frontend.button :href="route('services.index')">Explore</x-frontend.button> --}}
@props(['href'])
<a href="{{ $href }}" {{ $attributes->class(['bn2-button']) }}>
    {{ $slot }}
</a>
