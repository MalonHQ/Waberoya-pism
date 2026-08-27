<div class="p-6 bg-white rounded-lg shadow-sm print:shadow-none" id="student-report-print-area">
    <div class="text-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">TAARIFA NA MATOKEO YA MWANAFUNZI</h2>
        <p class="text-sm text-gray-600">Tarehe ya Ripoti: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mb-4 grid grid-cols-2 gap-4 text-sm">
        <div>
            <p><strong>Jina Kamili:</strong> {{ optional($record->user)->name }}</p>
            <p><strong>Barua Pepe:</strong> {{ optional($record->user)->email }}</p>
        </div>
        <div>
            <p><strong>Namba ya Usajili:</strong> {{ $record->reg_number ?? 'N/A' }}</p>
            <p><strong>Tarehe ya Kujiandikisha:</strong> {{ $record->created_at?->format('d M Y H:i') }}</p>
        </div>
    </div>

    <h3 class="font-bold text-md text-gray-700 mt-6 mb-3">Orodha ya Masomo na Alama</h3>
    
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
                    <td colspan="6" class="border border-gray-300 p-4 text-center text-gray-500">Mwanafunzi hana matokeo bado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6 flex justify-end gap-3">
        <button onclick="window.print()" class="px-4 py-2 bg-success-600 text-white rounded-lg hover:bg-success-700 font-medium text-sm flex items-center gap-2">
            <span>🖨️ Chapisha / Pakua PDF</span>
        </button>
    </div>
</div>