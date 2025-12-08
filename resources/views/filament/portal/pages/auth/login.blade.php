<x-filament-panels::page.simple>
    <div class="flex flex-col items-center justify-center space-y-4">
        <h2 class="text-2xl font-bold tracking-tight text-center text-gray-900 dark:text-white">
            Selamat Datang di Portal TK
        </h2>
        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
            Silakan masuk untuk melanjutkan
        </p>
    </div>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page.simple>