@props(['services', 'showImages' => true])
@php
    $displayOrder = ['administrative-tasks', 'digital-marketing-services', 'customer-support-and-experience', 'website-revamp-and-optimization', 'creative-services', 'software-and-app-development', 'finance-and-accounting'];
    $orderedServices = [];
    foreach ($displayOrder as $serviceSlug) {
        if (array_key_exists($serviceSlug, $services)) $orderedServices[$serviceSlug] = $services[$serviceSlug];
    }
    foreach ($services as $serviceSlug => $item) {
        if (!array_key_exists($serviceSlug, $orderedServices)) $orderedServices[$serviceSlug] = $item;
    }
@endphp
<div class="va-cards va-service-grid {{ $showImages ? '' : 'bn-p3-text-only-grid' }}" data-bn-reveal-grid>
    @foreach($orderedServices as $serviceSlug => $item)
        <a class="va-card bn-experience-service-card bn-reveal {{ $showImages ? '' : 'bn-p3-text-only-card' }}" href="{{ route('services.show', ['slug' => $serviceSlug]) }}" aria-label="Explore {{ $item['title'] }}">
            @if($showImages)
            <div class="bn-experience-service-media">
                <img src="{{ asset($item['photo']) }}" width="900" height="560"
                     sizes="(max-width: 620px) 100vw, (max-width: 980px) 50vw, 25vw"
                     loading="lazy" decoding="async" alt="">
                <span class="bn-experience-service-number" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / SERVICE</span>
            </div>
            @endif
            <div class="va-card-body bn-experience-service-body">
                <div class="va-card-heading">
                    <h3>{{ $item['title'] }}</h3>
                    <span class="va-card-arrow" aria-hidden="true">↗</span>
                </div>
                <p>{{ $item['summary'] }}</p>
                <span class="bn-experience-service-link" aria-hidden="true">Explore service <span>→</span></span>
            </div>
        </a>
    @endforeach
</div>
