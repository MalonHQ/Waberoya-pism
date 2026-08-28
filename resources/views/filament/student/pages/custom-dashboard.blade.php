<x-filament-panels::page>
    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="text-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">KARIBU KWENYE PANELI YAKO</h2>
            <div class="flex justify-center items-center gap-3 mt-2 text-sm text-gray-600 font-medium">
                <span>Mwaka wa Masomo: <strong class="text-emerald-700">{{ optional($activeAcademicYear)->name ?? '2025/2026' }}</strong></span>
                <span>•</span>
                <span>Semester: <strong class="text-blue-700">{{ optional($activeSemester)->name ?? 'Semester II' }}</strong></span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Tarehe ya Leo: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @if($record)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div>
                    <p class="mb-2"><strong>Jina Kamili:</strong> {{ optional($record->user)->name }}</p>
                    <p class="mb-2"><strong>Barua Pepe:</strong> {{ optional($record->user)->email }}</p>
                    <p><strong>Namba ya Usajili:</strong> {{ $record->reg_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="mb-2"><strong>Kozi / Idara:</strong> <span class="font-semibold text-emerald-800">{{ optional($record->department)->name ?? 'N/A' }}</span></p>
                    <p class="mb-2"><strong>Mwaka wa Masomo (Year of Study):</strong> <span class="font-semibold text-blue-700">{{ $record->year_of_study ?? 'N/A' }}</span></p>
                    <p><strong>Hali ya Akaunti:</strong> <span class="text-green-600 font-semibold">Active / Imethibitishwa</span></p>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('filament.student.pages.view-my-results') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium text-sm flex items-center gap-2">
                    <span>Tazama Matokeo Yangu Yote ➔</span>
                </a>
            </div>
        @else
            <p class="text-center text-gray-500 py-4">Wasifu wa mwanafunzi haujapatikana kwa akaunti hii.</p>
        @endif
    </div>
</x-filament-panels::page>