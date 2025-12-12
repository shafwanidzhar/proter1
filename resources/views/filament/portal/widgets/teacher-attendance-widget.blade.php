<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col items-center justify-center space-y-4">
            <h2 class="text-xl font-bold">Attendance Check-In</h2>
            <p class="text-gray-500">{{ now()->format('l, d F Y') }}</p>

            @if($this->hasCheckedIn())
                <div class="px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                    Checked in at {{ $this->getCheckInTime() }}
                </div>
            @else
                <x-filament::button wire:click="checkIn" size="lg">
                    Check In Now
                </x-filament::button>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>