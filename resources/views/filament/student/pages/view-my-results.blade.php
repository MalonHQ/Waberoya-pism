<x-filament-panels::page>
    <div class="p-6 bg-white rounded-lg shadow-sm print:shadow-none" id="student-report-print-area">
        <div class="text-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">TAARIFA NA MATOKEO YAKO</h2>
            <div class="flex justify-center items-center gap-3 mt-2 text-sm text-gray-600 font-medium">
                <span>Mwaka wa Masomo: <strong class="text-emerald-700">{{ optional($activeAcademicYear)->name ?? \App\Models\AcademicYear::where('is_active', true)->first()->name ?? '2025/2026' }}</strong></span>
                <span>•</span>
                <span>Semester: <strong class="text-blue-700">{{ optional($activeSemester)->name ?? \App\Models\Semester::where('is_active', true)->first()->name ?? 'Semester I' }}</strong></span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Tarehe ya Ripoti: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @if($record)
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div>
                    <p class="mb-2"><strong>Jina Kamili:</strong> {{ optional($record->user)->name }}</p>
                    <p class="mb-2"><strong>Barua Pepe:</strong> {{ optional($record->user)->email }}</p>
                    <p><strong>Namba ya Usajili:</strong> {{ $record->reg_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="mb-2"><strong>Kozi / Idara:</strong> <span class="font-semibold text-emerald-800">{{ optional($record->department)->name ?? 'N/A' }}</span></p>
                    <p class="mb-2"><strong>Mwaka wa Masomo (Year of Study):</strong> <span class="font-semibold text-blue-700">{{ $record->year_of_study ?? 'N/A' }}</span></p>
                    <p><strong>Tarehe ya Kujiandikisha:</strong> {{ $record->created_at?->format('d M Y H:i') }}</p>
                </div>
            </div>

            <h3 class="font-bold text-md text-gray-700 mt-6 mb-3">Orodha ya Masomo na Alama Zako</h3>

            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left">Somo</th>
                        <th class="border border-gray-300 p-2 text-center">CA</th>
                        <th class="border border-gray-300 p-2 text-center">Exam</th>
                        <th class="border border-gray-300 p-2 text-center">Jumla</th>
                        <th class="border border-gray-300 p-2 text-center">Grade</th>
                        <th class="border border-gray-300 p-2 text-center">Hali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                        <tr>
                            <td class="border border-gray-300 p-2">
                                {{ optional($result->course)->title ?? 'Somo' }}
                                @if(optional($result->course)->code)
                                    <span class="text-xs text-gray-500 block">({{ optional($result->course)->code }})</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 p-2 text-center">{{ $result->ca_marks ?? 0 }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $result->exam_marks ?? 0 }}</td>
                            <td class="border border-gray-300 p-2 text-center font-bold">{{ $result->total_marks ?? 0 }}</td>
                            <td class="border border-gray-300 p-2 text-center font-bold">{{ $result->grade ?? '-' }}</td>
                            <td class="border border-gray-300 p-2 text-center capitalize">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                    {{ $result->status ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-4 text-center text-gray-500">Huna matokeo yaliyowekwa bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6 flex justify-end gap-3 print:hidden">
                <a href="{{ url('/student') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium text-sm flex items-center gap-2">
                    <span>Rudi Nyumbani / Dashboard</span>
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium text-sm flex items-center gap-2">
                    <span>📥 Download / Chapisha</span>
                </button>
            </div>
        @else
            <p class="text-center text-gray-500 py-4">Wasifu wa mwanafunzi (StudentProfile) haujapatikana kwa akaunti hii.</p>
        @endif
    </div>
</x-filament-panels::page>