<?php

use App\Services\PackagistService;
use Livewire\Volt\Component;
use function Livewire\Volt\{mount};
new class extends Component {
    public $package;
    public $packagistService;

    public function mount(PackagistService $packagistService, $vendor, $package)
    {
        $this->package = $packagistService->getPackage($vendor, $package);
    }
};
?>

<div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-6 mx-auto">
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
            <div class="flex items-center mt-2 max-w-full">
                <flux:tooltip content="Copy to clipboard" class="flex-1">

                    <flux:text @click="copyToClipboard"
                        class="cursor-pointer inline-block text-gray-600 dark:text-gray-300 bg-zinc-100 dark:bg-zinc-600 p-2 rounded-md w-full">
                        <pre class="max-w-full overflow-x-hidden overflow-ellipsis">laravel new --using {{ $package['package']['name'] }}</pre>
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
                <flux:text class="text-gray-600 dark:text-gray-300 font-bold">Create with Herd</flux:text>
            </flux:link>
        </div>
    </div>

</div>
<script>
    function copyToClipboard() {
        const command = 'laravel new --using {{ $package['package']['name'] }}';
        navigator.clipboard.writeText(command);
        Flux.toast({
            heading: 'Copied!',
            text: 'Command copied to clipboard',
            variant: 'success',
            duration: 3000
        })
    }
</script>
