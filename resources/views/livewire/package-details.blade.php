<?php

use App\Services\PackagistService;
use App\Services\GitHubService;
use Livewire\Volt\Component;
use function Livewire\Volt\{mount};
new class extends Component {
    public $package;
    public $readme;
    public $packagistService;
    public $githubService;

    public function mount(PackagistService $packagistService, GitHubService $githubService, $vendor, $package)
    {
        $this->package = $packagistService->getPackage($vendor, $package);
        $this->readme = $githubService->getReadmeContent($this->package['package']['repository']);
    }
};
?>

<div class="bg-white dark:bg-zinc-900 rounded-lg p-6 mx-auto">
    <flux:heading size="xl" class="text-left mb-4">{{ $package['package']['name'] }}</flux:heading>
    <div class="border-b dark:border-gray-700 mb-4 pb-4">
        <flux:text class="text-gray-600 dark:text-gray-300 text-lg">{{ $package['package']['description'] }}</flux:text>
    </div>

    <div class="flex flex-wrap gap-4 justify-between items-center">
        <div class="flex items-center space-x-4">
            <flux:link href="{{ $package['package']['repository'] }}"
                class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-700 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
                <flux:icon class="mr-2" name="github" />
                View on GitHub
            </flux:link>
        </div>

        <div class="flex items-center space-x-3 text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center">
                <flux:icon name="star" class="mr-1" />
                <span>{{ number_format($package['package']['github_stars'] ?? 0) }}</span>
            </div>
            <div class="flex items-center">
                <flux:icon name="git-fork" class="mr-1" />
                <span>{{ number_format($package['package']['github_forks'] ?? 0) }}</span>
            </div>
            <div class="flex items-center">
                <flux:icon name="download" class="mr-1" />
                <span>{{ number_format($package['package']['downloads']['total'] ?? 0) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <flux:heading size="lg" class="mb-4">Installation</flux:heading>
        <div>
            <flux:text class="text-gray-600 dark:text-gray-300 font-bold">
                Create with Laravel CLI:
            </flux:text>
            <div class="flex items-center mt-2 max-w-full overflow-x-auto overflow-ellipsis">
                <flux:tooltip content="Copy to clipboard" class="flex-1">
                    <flux:text @click="copyLaravelToClipboard"
                        class="inline-block text-gray-600 dark:text-gray-300 bg-zinc-100 dark:bg-zinc-600 p-2 rounded-md w-full">
                        <pre>laravel new --using {{ $package['package']['name'] }}</pre>
                    </flux:text>
                </flux:tooltip>
            </div>
        </div>
        <div class="mt-4">
            <flux:text class="text-gray-600 dark:text-gray-300 font-bold">
                Create with Composer (with a name):
            </flux:text>
            <div class="flex items-center mt-2 max-w-full overflow-x-auto overflow-ellipsis">
                <flux:tooltip content="Copy to clipboard" class="flex-1">
                    <flux:text @click="copyComposerToClipboard"
                        class="cursor-pointer overflow-ellipsis inline-block text-gray-600 dark:text-gray-300 bg-zinc-100 dark:bg-zinc-600 p-2 rounded-md w-full">
                        <pre>composer create-project {{ $package['package']['name'] }} {name}</pre>
                    </flux:text>
                </flux:tooltip>
            </div>
        </div>
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-zinc-900 text-gray-500 dark:text-gray-400">OR</span>
            </div>
        </div>
        <div class="mt-4">
            <flux:link target="_blank" href="https://herd.laravel.com/new/{{ $package['package']['name'] }}">
                <img class="w-64" src="{{ asset('images/Herd create image.png') }}" alt="Create a new site with Herd">
            </flux:link>
        </div>
    </div>
    @if($readme)
    <div class="mt-8">
        <flux:heading size="lg" class="mb-4">Documentation</flux:heading>
        <div class="rounded-xl bg-zinc-50 dark:bg-zinc-800/60 shadow-lg p-8 border border-zinc-200 dark:border-zinc-700">
            <div class="prose dark:prose-invert mx-auto
                prose-img:rounded-lg prose-img:shadow-lg
                prose-a:text-primary-600 prose-a:inline-block dark:prose-a:text-primary-400 prose-a:underline hover:prose-a:text-primary-800
                prose-h2:mt-10 prose-h2:border-b prose-h2:pb-2 prose-h2:border-gray-200 dark:prose-h2:border-gray-700
                prose-li:marker:text-primary-500
            ">
                {!! Str::markdown($readme) !!}
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    function copyLaravelToClipboard() {
        const command = 'laravel new --using {{ $package['package']['name'] }}';
        navigator.clipboard.writeText(command);
        Flux.toast({
            heading: 'Copied!',
            text: 'Command copied to clipboard',
            variant: 'success',
            duration: 3000
        })
    }

    function copyComposerToClipboard() {
        const command = 'composer create-project {{ $package['package']['name'] }}';
        navigator.clipboard.writeText(command);
        Flux.toast({
            heading: 'Copied!',
            text: 'Command copied to clipboard',
            variant: 'success',
            duration: 3000
        })
    }
</script>