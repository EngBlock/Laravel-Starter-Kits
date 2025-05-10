<?php

use Livewire\Volt\Component;

new class extends Component {
    public $mostDownloadedStarterKits;

    public function mount()
    {
        $this->mostDownloadedStarterKits = $this->getMostDownloadedStarterKits();
    }

    public function getMostDownloadedStarterKits()
    {
        // make request to https://packagist.org/search.json?tags=starter%20kit&per_page=100
        $response = Http::get('https://packagist.org/search.json?tags=starter%20kit&per_page=100');
        return collect($response->json()['results'])->sortByDesc('favers');

        // returns {results: [{name: 'laravel-lang/starter-kits', downloads: 107343, favers: 1000}]}
    }
}; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4">
    @foreach ($mostDownloadedStarterKits as $starterKit)
    <a href="{{ $starterKit['repository'] }}" aria-label="Visit {{ $starterKit['name'] }} repository">
        <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
            <flux:heading class="flex items-center gap-2">{{ $starterKit['name'] }} <flux:icon name="arrow-up-right" class="ml-auto text-zinc-400" variant="micro" /></flux:heading>
            <flux:text class="mt-2">{{ $starterKit['downloads'] }} downloads</flux:text>
        </flux:card>
    </a>
    @endforeach
</div>
