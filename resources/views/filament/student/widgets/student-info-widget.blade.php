<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            <h3 class="text-base font-bold text-gray-800 border-b pb-2">Taarifa za Usajili na Masomo</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-100">
                    <p class="mb-2"><strong>Hali ya Usajili:</strong> <span class="text-emerald-700 font-semibold">Imethibitishwa / Registered</span></p>
                    <p class="mb-2"><strong>Mwaka wa Masomo:</strong> {{ optional($activeAcademicYear)->name ?? '2025/2026' }}</p>
                    <p><strong>Semester:</strong> {{ optional($activeSemester)->name ?? 'Semester I' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="mb-2"><strong>Namba ya Usajili:</strong> {{ optional($studentProfile)->reg_number ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Kozi / Idara:</strong> <span class="font-semibold text-emerald-800">{{ optional(optional($studentProfile)->department)->name ?? 'Haijajazwa' }}</span></p>
                    <p><strong>Mwaka wa Masomo:</strong> <span class="font-semibold text-blue-700">{{ optional($studentProfile)->year_of_study ?? 'Mwaka wa Kwanza' }}</span></p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>