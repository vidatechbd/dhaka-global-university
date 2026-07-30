@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
    @if(auth()->user()->hasRole('Student'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-textclr-100 leading-tight">
                {{ __('My Marksheets') }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-7xl mx-auto">
            <div class="bg-bgclr-200 border border-bgclr-300 overflow-hidden shadow-sm sm:rounded-2xl p-6">
                <h3 class="text-lg font-bold text-textclr-100 mb-4">{{ __('My Issued Marksheets') }}</h3>
                <div class="overflow-x-auto border border-bgclr-300 rounded-xl">
                    <table class="min-w-full divide-y divide-bgclr-300">
                        <thead class="bg-bgclr-300/30">
                            <tr class="text-textclr-200 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">{{ __('Title') }}</th>
                                <th class="px-6 py-3 text-left">{{ __('Issued By') }}</th>
                                <th class="px-6 py-3 text-left">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-bgclr-300 text-textclr-100 text-sm">
                            @forelse($marksheets as $marksheet)
                                <tr class="hover:bg-bgclr-100/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-textclr-100 font-semibold">{{ $marksheet->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-textclr-200">{{ $marksheet->creator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-textclr-200">{{ $marksheet->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-3">
                                        <a href="{{ route('marksheets.show', $marksheet) }}" class="text-primary-300 hover:text-primary-300/80 font-bold">{{ __('View') }}</a>
                                        <a href="{{ route('marksheets.show', $marksheet) }}?print=true" target="_blank" class="text-accent-200 hover:text-accent-200/80 font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            {{ __('Download') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-textclr-200 italic">{{ __('No marksheets found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Admin / Teacher Full Width Marksheet & Transcript Page -->
        <style>
            @media print {
                body * { visibility: hidden; }
                #sidebar, header, #form-section, .no-print, nav { display: none !important; }
                #marksheet-section, #marksheet-section * { visibility: visible; }
                #marksheet-section {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    box-shadow: none;
                    border: none;
                }
                body { background-color: white; }
                @page { size: A4 portrait; margin: 15mm; }
                .print-border { border-color: #000 !important; }
            }
        </style>

        <div class="flex flex-col gap-6 w-full">
            @if(session('success'))
                <div class="p-4 bg-primary-100 border-l-4 border-primary-300 text-primary-300 text-xs font-semibold rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-accent-100/30 border-l-4 border-accent-200 text-accent-200 text-xs font-semibold rounded-r-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Generated Marksheets List Table (Full Width) -->
            <div class="bg-bgclr-200 border border-bgclr-300 rounded-3xl p-6 shadow-sm w-full">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-xl font-bold text-textclr-100">{{ __('All Generated Marksheets') }}</h2>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('marksheets.create') }}" class="px-4 py-2 bg-primary-300 hover:bg-primary-300/90 text-white font-bold text-xs rounded-lg shadow-sm transition">
                            + Generate Marksheet
                        </a>
                        <button type="button" class="px-4 py-1.5 bg-bgclr-300/40 text-textclr-100 font-bold text-[11px] rounded-md shadow-sm hover:bg-bgclr-300/70 transition">CSV</button>
                        <button type="button" class="px-4 py-1.5 bg-bgclr-300/40 text-textclr-100 font-bold text-[11px] rounded-md shadow-sm hover:bg-bgclr-300/70 transition">Excel</button>
                        <button type="button" class="px-4 py-1.5 bg-bgclr-300/40 text-textclr-100 font-bold text-[11px] rounded-md shadow-sm hover:bg-bgclr-300/70 transition">PDF</button>
                        <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-bgclr-300/40 text-textclr-100 font-bold text-[11px] rounded-md shadow-sm hover:bg-bgclr-300/70 transition">Print</button>
                    </div>
                </div>

                <div class="overflow-x-auto border border-bgclr-300 rounded-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-bgclr-300/30 border-b border-bgclr-300 text-textclr-200 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-4 text-center">#</th>
                                <th class="px-6 py-4">Student Name</th>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Department</th>
                                <th class="px-6 py-4 text-center">Exam Roll</th>
                                <th class="px-6 py-4 text-center">Result</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-bgclr-300 text-xs text-textclr-100">
                            @forelse($marksheets as $index => $marksheet)
                                <tr class="hover:bg-bgclr-100/60 transition">
                                    <td class="px-6 py-4 text-center text-textclr-200 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-textclr-100">{{ $marksheet->student->name }}</td>
                                    <td class="px-6 py-4 font-semibold text-textclr-100">{{ $marksheet->title }}</td>
                                    <td class="px-6 py-4 font-semibold text-textclr-200">{{ $marksheet->department ?: 'CSE' }}</td>
                                    <td class="px-6 py-4 text-center font-mono text-textclr-200">{{ $marksheet->exam_roll ?: (46437 + $index) }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-textclr-100">{{ $marksheet->result ?: '3.96' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-2.5 py-1 bg-primary-100/50 border border-primary-200/50 text-primary-300 font-bold text-[10px] rounded-md tracking-wider">
                                            GENERATED
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                        <a href="{{ route('marksheets.show', $marksheet) }}" class="inline-flex items-center justify-center p-1.5 bg-primary-100/40 hover:bg-primary-100/80 text-primary-300 rounded-md transition shadow-sm" title="View Transcript">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('marksheets.show', $marksheet) }}?print=true" target="_blank" class="inline-flex items-center justify-center p-1.5 bg-accent-100/40 hover:bg-accent-100/80 text-accent-200 rounded-md transition shadow-sm" title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('marksheets.destroy', $marksheet) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this marksheet?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center p-1.5 bg-accent-100/30 hover:bg-accent-100/60 text-accent-200 rounded-md transition shadow-sm" title="Delete Marksheet">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-textclr-200 font-medium italic">
                                        {{ __('No marksheets generated yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-dynamic-component>
