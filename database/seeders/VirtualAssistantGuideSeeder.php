<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class VirtualAssistantGuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            'what-to-delegate-to-a-virtual-assistant-first' => [
                'What to delegate to a virtual assistant first',
                'Start with a repeatable task that has a clear result and few exceptions.',
                '<h2>Pick a task you can describe</h2><p>List the tasks you repeat every week. Choose one with a clear finish line: for example, tag incoming messages, update the appointment calendar, or collect invoices for review.</p><h2>Show what good looks like</h2><p>Share a completed example, a short checklist, and the name of the person who handles exceptions. Decide which actions need your approval before they go out.</p><h2>Review the first handoff</h2><p>Look at the first few outputs together. Tighten the instructions where decisions were unclear before you add another task.</p>',
            ],
            'hand-off-inbox-and-calendar-management' => [
                'How to hand off inbox and calendar management',
                'Set reply boundaries, calendar rules, and a clear route for urgent messages.',
                '<h2>Agree on inbox priorities</h2><p>Define what gets flagged, what can be answered from a template, and what should stay with you. Provide examples of messages in each group.</p><h2>Write down your calendar rules</h2><p>List your working hours, meeting buffers, and preferred appointment lengths. Explain which meetings can be rescheduled and which should be protected.</p><h2>Check exceptions early</h2><p>Ask for a short recap of questions or escalations after the first few days. Use those examples to refine the rules together.</p>',
            ],
            'prepare-a-virtual-assistant-handoff' => [
                'A practical checklist for your first virtual assistant handoff',
                'Prepare the task, instructions, tools, and approval boundaries before you begin.',
                '<h2>Prepare a simple brief</h2><p>Write the task name, who owns it, how often it runs, and what a finished output should contain. Add a sample and a deadline.</p><h2>Share only the access the task needs</h2><p>List the tools used for the workflow and arrange appropriate accounts or permissions. Keep approval and escalation contacts in the same brief.</p><h2>Schedule a short review</h2><p>Agree on when to review the first run and what to change if instructions were incomplete. Save the updated checklist for the next cycle.</p>',
            ],
        ];

        foreach ($guides as $slug => [$title, $excerpt, $content]) {
            Blog::firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => $content,
                'category' => 'Virtual Assistant Guides',
                'author_name' => 'Better Nexus',
                'is_published' => true,
                'published_at' => now(),
            ]);
        }
    }
}
