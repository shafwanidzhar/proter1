<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                    SELAMAT DATANG,
                    {{ strtoupper(auth()->user()->role === 'admin' ? 'ADMIN' : (auth()->user()->role === 'teacher' ? 'GURU' : 'ORANG TUA')) }}
                </h2>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>