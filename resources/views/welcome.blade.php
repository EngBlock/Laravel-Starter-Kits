<x-layouts.app.header :title="$title ?? null">
    <flux:main container>
        <flux:heading size="xl">Welcome to Laravel Starter Kits</flux:heading>
        <flux:heading size="lg" class="mt-8">Favourite Starter Kits</flux:heading>
        <div class="mt-4">
            <livewire:most-downloaded-starter-kit-list />
        </div>
    </flux:main>
</x-layouts.app.header>
