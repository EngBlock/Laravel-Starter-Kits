<x-layouts.app.header :title="$title ?? null">
    <div class="lg:p-8">
        <livewire:package-details :vendor="$vendor" :package="$package" />
    </div>
</x-layouts.app.header>
