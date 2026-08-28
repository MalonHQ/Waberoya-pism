<x-filament-panels::page>
    <div class="max-w-xl bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <form wire:submit="updatePassword" class="space-y-6">
            {{ $this->form }}

            <div class="flex justify-end gap-3">
                <x-filament::button type="submit" color="success">
                    Hifadhi Mabadiliko
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>