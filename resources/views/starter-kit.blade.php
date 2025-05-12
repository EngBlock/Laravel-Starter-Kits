<x-layouts.app.header :title="$title ?? null">
    <flux:main container>
        <livewire:package-details :vendor="$vendor" :package="$package" />
    </flux:main>
</x-layouts.app.header>
