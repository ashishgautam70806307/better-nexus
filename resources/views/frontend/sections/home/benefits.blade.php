<section class="bn2-section bn2-soft bn5-benefits bn8-surface-0 bn-partnership" aria-labelledby="partnership-title">
<div class="bn2-container bn-partnership-layout">
<div class="bn-partnership-copy"><span class="bn2-eyebrow">WHY BETTER NEXUS</span><h2 id="partnership-title">More than support.<br><em>A working partnership.</em></h2><p>A team that understands your priorities, communicates clearly, and helps you move the work forward.</p><a class="bn2-button" href="{{ route('about') }}">Get to know us <span aria-hidden="true">↗</span></a></div>
<div class="bn-partnership-portrait"><div aria-hidden="true" class="bn-partnership-orbit"></div><img src="{{ asset('better-nexus/assets/bn5/connected-specialist.png') }}" alt="Specialist ready to support your business" width="1024" height="1280" loading="lazy" decoding="async"></div>
<div class="bn-partnership-points">
@foreach([
['01','Built around your priorities','Support shaped around your goals, timelines, and way of working.'],
['02','People who know their craft','Specialist skills, thoughtful work, and clear communication.'],
['03','Flexible as you grow','Adapt your support as your business and priorities evolve.'],
['04','Space for the bigger picture','Keep your focus on customers, decisions, and what comes next.']
] as [$number,$title,$description])
<article><span aria-hidden="true">{{ $number }}</span><div><h3>{{ $title }}</h3><p>{{ $description }}</p></div></article>
@endforeach
</div></div></section>
