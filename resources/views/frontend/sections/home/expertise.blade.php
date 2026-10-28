<section class="bn-expertise-new" aria-labelledby="expertise-title"><div class="bn2-container"><div class="bn-expertise-heading"><div><span class="bn2-eyebrow">CONNECTED EXPERTISE</span><h2 id="expertise-title">One partner.<br><em>More possibilities.</em></h2></div><p>Bring the right capabilities together.<br>Choose the support your business needs today.</p><a href="{{ route('services.index') }}">Explore all services <span aria-hidden="true">↗</span></a></div>
<div class="bn-expertise-matrix">
@foreach([
['administrative-tasks','Administrative support','Everyday essentials, expertly handled.'],
['digital-marketing-services','Digital marketing','Connect your brand with your audience.'],
['customer-support-and-experience','Customer experience','Make every conversation count.'],
['website-revamp-and-optimization','Web & optimization','Better experiences on every screen.'],
['creative-services','Creative & design','Give your ideas a distinctive identity.'],
['software-and-app-development','Software & apps','Digital tools built around your work.'],
['finance-and-accounting','Finance & accounting','Keep the numbers moving with clarity.'],
['engineering-services','Engineering support','Technical expertise for your next project.']
] as [$slug,$label,$description])
<a href="{{ route('services.show',['slug'=>$slug]) }}"><span class="bn-expertise-number">0{{ $loop->iteration }}</span><div><h3>{{ $label }}</h3><p>{{ $description }}</p></div><span class="bn-expertise-arrow" aria-hidden="true">↗</span></a>
@endforeach
</div></div></section>
