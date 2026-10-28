@php
$descriptions = [
'administrative-tasks'=>'An organised day. A clearer head. Support for calendars, inboxes and the details that keep work moving.',
'creative-services'=>'A distinctive visual voice, brought to life through thoughtful design and purposeful creative work.',
'customer-support-and-experience'=>'Helpful answers and considered follow-through, wherever your customers connect with you.',
'digital-marketing-services'=>'Bring content, search and social together around your audience and your business goals.',
'engineering-services'=>'Extend your capacity for technical drawings, documentation, design and project coordination.',
'finance-and-accounting'=>'More clarity across bookkeeping, invoices, reporting and everyday financial operations.',
'software-and-app-development'=>'Practical digital tools and applications designed around the people who use them.',
'website-revamp-and-optimization'=>'Clearer journeys, purposeful interfaces and websites that work across screens.'
];
@endphp
<section class="nx-section nx-capabilities"><div class="nx-wrap"><div class="nx-section-label"><span>02 / CONNECTED EXPERTISE</span><span>ONE PARTNER. MORE POSSIBILITIES.</span></div>
<div class="nx-heading-row" data-nx-reveal><h2>Less on your plate.<br><em>More in motion.</em></h2><p>From essential daily tasks to ambitious digital projects. Build the support your business needs, without the complexity.</p></div>
<div class="nx-services">@foreach($services as $slug => $service)<a class="nx-service" data-nx-reveal href="{{ route('services.show', ['slug'=>$slug]) }}"><span class="nx-service-index">{{ str_pad((string)$loop->iteration,2,'0',STR_PAD_LEFT) }}</span><div><h3>{{ $service['title'] }}</h3><p>{{ $descriptions[$slug] ?? 'Specialist support shaped around your business.' }}</p></div><span class="nx-round-arrow" aria-hidden="true">↗</span></a>@endforeach</div>
</div></section>