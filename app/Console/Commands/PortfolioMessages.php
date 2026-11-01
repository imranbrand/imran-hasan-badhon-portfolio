<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use Illuminate\Console\Command;

class PortfolioMessages extends Command
{
    protected $signature = 'portfolio:messages {--all : Include messages already marked as read} {--read : Mark the listed messages as read}';

    protected $description = 'List messages sent through the portfolio contact form';

    public function handle(): int
    {
        $query = ContactMessage::query()->latest();

        if (! $this->option('all')) {
            $query->whereNull('read_at');
        }

        $messages = $query->limit(50)->get();

        if ($messages->isEmpty()) {
            $this->info('No messages.');

            return self::SUCCESS;
        }

        foreach ($messages as $m) {
            $this->line("<fg=cyan>#{$m->id}</> {$m->created_at}  <options=bold>{$m->name}</> <{$m->email}>  [{$m->type}]");
            $this->line($m->message);
            $this->newLine();
        }

        if ($this->option('read')) {
            ContactMessage::whereIn('id', $messages->pluck('id'))->update(['read_at' => now()]);
            $this->info('Marked as read.');
        }

        return self::SUCCESS;
    }
}
