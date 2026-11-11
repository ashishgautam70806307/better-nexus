<section class="va-section va-lead" id="va-faq" aria-labelledby="va-faq-heading"><div class="va-wrap va-split va-faq">
    <div><span class="va-kicker">FREQUENTLY ASKED QUESTIONS</span>
        <h2 id="va-faq-heading">Good questions. Clear answers.</h2>
        <p>Here’s what to know before you delegate your first task.</p>
        <a class="va-card-link" href="{{ route('contact-us') }}#bn-contact-live">Ask us a question <span aria-hidden="true">↗</span></a>
    </div>
    <div class="va-faq-list">
        @foreach([
            ['What can a virtual assistant help with?', 'You can discuss inboxes, calendars, customer requests, content updates, records and routine follow-ups. Browse our services to find the closest fit.'],
            ['Can I start with just one task?', 'Yes. Bring one repeatable task or a clear project. We can discuss the steps, timing and approvals before you start.'],
            ['Can an assistant use the tools we already work in?', 'Tell us which tools your team uses. We’ll discuss the access the task needs and what should stay with your team.'],
            ['How will I know what has been done?', 'Agree on a shared task list or update rhythm up front, including when an assistant should flag a question or ask for approval.'],
        ] as [$question, $answer])
            <details class="va-question"><summary>{{ $question }}<span aria-hidden="true"></span></summary><p>{{ $answer }}</p></details>
        @endforeach
    </div>
</div></section>
