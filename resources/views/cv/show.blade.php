<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-accent">{{ $cv->title }}</h1>
                <span class="text-sm text-gray-400">{{ ucfirst($cv->template) }} template · Last edited {{ ($cv->last_edited_at ?? $cv->updated_at ?? $cv->created_at)?->diffForHumans() ?? 'just now' }}</span>
            </div>
            <a href="{{ route('cv.index') }}"
               class="text-sm text-gray-500 hover:text-accent transition-colors duration-150">
                ← Back
            </a>
        </div>

        {{-- ── Personal Info ───────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6 mb-6">
            <h2 class="text-base font-semibold text-accent mb-4">Personal Info</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Full Name</span>
                    <span class="text-gray-800 font-medium">{{ $cv->personal_info['name'] ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Email</span>
                    <span class="text-gray-800 font-medium">{{ $cv->personal_info['email'] ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Phone</span>
                    <span class="text-gray-800 font-medium">{{ $cv->personal_info['phone_number'] ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- ── Experience ──────────────────────────────────────── --}}
        @if(!empty($cv->experience))
            <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6 mb-6">
                <h2 class="text-base font-semibold text-accent mb-4">Experience</h2>
                <div class="space-y-4">
                    @foreach($cv->experience as $exp)
                        <div class="border-l-2 border-secondary pl-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ $exp['role'] ?? '—' }}</p>
                                    <p class="text-secondary text-sm">{{ $exp['company'] ?? '—' }}</p>
                                </div>
                                @if(!empty($exp['start_date']))
                                    <span class="text-xs text-gray-400 whitespace-nowrap">
                                        {{ $exp['start_date'] }} — {{ $exp['end_date'] ?? 'Present' }}
                                    </span>
                                @endif
                            </div>
                            @if(!empty($exp['description']))
                                <p class="text-gray-600 text-sm mt-1">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Education ───────────────────────────────────────── --}}
        @if(!empty($cv->education))
            <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6 mb-6">
                <h2 class="text-base font-semibold text-accent mb-4">Education</h2>
                <div class="space-y-3">
                    @foreach($cv->education as $edu)
                        <div class="border-l-2 border-secondary pl-4">
                            <p class="font-medium text-gray-800 text-sm">{{ $edu['school'] ?? '—' }}</p>
                            @if(!empty($edu['degree']))
                                <p class="text-gray-500 text-sm">{{ $edu['degree'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Skills & Languages ──────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

            @if(!empty($cv->skills))
                <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6">
                    <h2 class="text-base font-semibold text-accent mb-4">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($cv->skills as $skill)
                            <span class="bg-secondary/15 text-accent text-sm px-3 py-1 rounded-full">
                                {{ $skill['name'] ?? '' }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($cv->languages))
                <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6">
                    <h2 class="text-base font-semibold text-accent mb-4">Languages</h2>
                    <div class="space-y-2">
                        @foreach($cv->languages as $lang)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-800 font-medium">{{ $lang['name'] ?? '' }}</span>
                                @if(!empty($lang['level']))
                                    <span class="text-gray-400 text-xs">{{ $lang['level'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- ── Projects ────────────────────────────────────────── --}}
        @if(!empty($cv->projects))
            <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 p-6 mb-8">
                <h2 class="text-base font-semibold text-accent mb-4">Projects</h2>
                <div class="space-y-4">
                    @foreach($cv->projects as $project)
                        <div class="border-l-2 border-secondary pl-4">
                            <p class="font-medium text-gray-800 text-sm">{{ $project['title'] ?? '—' }}</p>
                            @if(!empty($project['description']))
                                <p class="text-gray-600 text-sm mt-1">{{ $project['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Actions ─────────────────────────────────────────── --}}
        <div class="flex gap-3 justify-end">
            <a href="{{ route('cv.edit', $cv) }}"
               class="border border-secondary/50 text-accent text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-secondary/10 transition-colors duration-150">
                Edit
            </a>
            <form method="POST" action="{{ route('cv.destroy', $cv) }}"
                  onsubmit="return confirm('Delete this CV? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-red-600 transition-colors duration-150">
                    Delete
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
