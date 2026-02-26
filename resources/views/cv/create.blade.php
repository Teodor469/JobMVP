<x-app-layout>
    <form method="POST" action="{{ route('cv.store') }}" enctype="multipart/form-data"
          x-data="cvForm()">
        @csrf

        {{-- ── Sticky top bar ─────────────────────────────────────── --}}
        <div class="sticky top-0 z-20 bg-white/95 backdrop-blur-sm border-b border-secondary/20 shadow-sm">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-4">

                <a href="{{ route('cv.index') }}"
                   class="text-sm text-gray-400 hover:text-accent transition-colors shrink-0">← Back</a>

                <div class="flex-1 flex items-center gap-2 min-w-0">
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="Untitled CV"
                           class="flex-1 min-w-0 text-sm font-medium text-gray-700 placeholder-gray-300
                                  border-0 border-b border-transparent focus:border-secondary focus:outline-none
                                  py-0.5 bg-transparent transition-colors">
                    @error('title')
                        <span class="text-red-400 text-xs shrink-0">{{ $message }}</span>
                    @enderror
                </div>

                <select name="template"
                        class="border border-secondary/40 rounded-lg px-3 py-1.5 text-sm text-gray-600
                               focus:outline-none focus:border-secondary shrink-0">
                    <option value="modern"  {{ old('template', 'modern') === 'modern'  ? 'selected' : '' }}>Modern</option>
                    <option value="classic" {{ old('template', 'modern') === 'classic' ? 'selected' : '' }}>Classic</option>
                    <option value="minimal" {{ old('template', 'modern') === 'minimal' ? 'selected' : '' }}>Minimal</option>
                </select>

                <button type="submit"
                        class="shrink-0 bg-accent text-primary text-sm font-medium px-5 py-2 rounded-lg
                               hover:bg-secondary transition-colors duration-150">
                    Save CV
                </button>
            </div>
        </div>

        {{-- ── CV Document ─────────────────────────────────────────── --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="rounded-2xl shadow-xl overflow-hidden flex flex-col lg:flex-row" style="min-height:820px">

                {{-- ══ LEFT SIDEBAR ══════════════════════════════════ --}}
                <div class="bg-[#484f6a] lg:w-[37%] p-8 flex flex-col gap-7">

                    {{-- Profile photo --}}
                    <div class="flex flex-col items-center">
                        <label for="photo-upload" class="cursor-pointer group relative block">
                            <div class="w-32 h-32 rounded-full border-2 border-dashed border-[#E3E4ED]/30
                                        overflow-hidden flex items-center justify-center
                                        bg-white/10 group-hover:bg-white/15 transition-colors">
                                <img x-show="photoUrl" :src="photoUrl"
                                     class="w-full h-full object-cover" alt="Profile photo">
                                <div x-show="!photoUrl"
                                     class="flex flex-col items-center text-[#E3E4ED]/40
                                            group-hover:text-[#E3E4ED]/70 transition-colors px-2">
                                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    <span class="text-xs mt-2 tracking-wide">Add Photo</span>
                                </div>
                            </div>

                            {{-- Camera badge --}}
                            <div class="absolute bottom-1 right-1 w-8 h-8 rounded-full
                                        bg-[#7697c6] flex items-center justify-center shadow-lg
                                        group-hover:bg-[#7697c6]/80 transition-colors">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2" class="text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                                </svg>
                            </div>
                        </label>
                        <input id="photo-upload" type="file" name="profile_picture" accept="image/*"
                               class="hidden" @change="onPhotoChange($event)">
                        @error('profile_picture')
                            <p class="text-red-300 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact info --}}
                    <div>
                        <p class="text-[10px] font-bold tracking-[0.2em] text-[#E3E4ED]/45 uppercase mb-3">Contact</p>
                        <div class="space-y-3.5">
                            <div>
                                <label class="text-[10px] text-[#E3E4ED]/45 block mb-0.5">Full Name <span class="text-red-300">*</span></label>
                                <input type="text" name="personal_info[name]" value="{{ old('personal_info.name') }}"
                                       placeholder="Jane Doe"
                                       class="w-full bg-transparent border-0 border-b border-[#E3E4ED]/20
                                              text-[#E3E4ED] placeholder-[#E3E4ED]/25 text-sm py-1
                                              focus:outline-none focus:border-[#E3E4ED]/55 transition-colors">
                                @error('personal_info.name')
                                    <p class="text-red-300 text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-[10px] text-[#E3E4ED]/45 block mb-0.5">Email <span class="text-red-300">*</span></label>
                                <input type="email" name="personal_info[email]" value="{{ old('personal_info.email') }}"
                                       placeholder="jane@email.com"
                                       class="w-full bg-transparent border-0 border-b border-[#E3E4ED]/20
                                              text-[#E3E4ED] placeholder-[#E3E4ED]/25 text-sm py-1
                                              focus:outline-none focus:border-[#E3E4ED]/55 transition-colors">
                                @error('personal_info.email')
                                    <p class="text-red-300 text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-[10px] text-[#E3E4ED]/45 block mb-0.5">Phone <span class="text-red-300">*</span></label>
                                <input type="text" name="personal_info[phone_number]" value="{{ old('personal_info.phone_number') }}"
                                       placeholder="+1 555 000 000"
                                       class="w-full bg-transparent border-0 border-b border-[#E3E4ED]/20
                                              text-[#E3E4ED] placeholder-[#E3E4ED]/25 text-sm py-1
                                              focus:outline-none focus:border-[#E3E4ED]/55 transition-colors">
                                @error('personal_info.phone_number')
                                    <p class="text-red-300 text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Skills --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-bold tracking-[0.2em] text-[#E3E4ED]/45 uppercase">Skills</p>
                            <button type="button" @click="add('skills')"
                                    class="text-xs text-[#E3E4ED]/55 hover:text-[#E3E4ED] transition-colors">+ Add</button>
                        </div>
                        <div class="flex flex-wrap gap-2 min-h-[28px]">
                            <template x-for="(item, i) in skills" :key="i">
                                <div class="flex items-center gap-1 bg-white/10 hover:bg-white/15 rounded-full px-3 py-1 transition-colors">
                                    <input type="text" :name="`skills[${i}][name]`" x-model="item.name"
                                           placeholder="Skill"
                                           class="bg-transparent text-[#E3E4ED] text-xs w-20
                                                  focus:outline-none placeholder-[#E3E4ED]/35">
                                    <button type="button" @click="remove('skills', i)"
                                            class="text-[#E3E4ED]/35 hover:text-red-300 text-sm leading-none transition-colors ml-0.5">&times;</button>
                                </div>
                            </template>
                            <p x-show="skills.length === 0" class="text-xs text-[#E3E4ED]/25 italic self-center">
                                No skills yet
                            </p>
                        </div>
                    </div>

                    {{-- Languages --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-bold tracking-[0.2em] text-[#E3E4ED]/45 uppercase">Languages</p>
                            <button type="button" @click="add('languages')"
                                    class="text-xs text-[#E3E4ED]/55 hover:text-[#E3E4ED] transition-colors">+ Add</button>
                        </div>
                        <div class="space-y-2.5">
                            <template x-for="(item, i) in languages" :key="i">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="`languages[${i}][name]`" x-model="item.name"
                                           placeholder="Language"
                                           class="flex-1 bg-transparent border-0 border-b border-[#E3E4ED]/20
                                                  text-[#E3E4ED] placeholder-[#E3E4ED]/30 text-sm py-1
                                                  focus:outline-none focus:border-[#E3E4ED]/55 transition-colors min-w-0">
                                    <input type="text" :name="`languages[${i}][level]`" x-model="item.level"
                                           placeholder="Level"
                                           class="w-16 bg-transparent border-0 border-b border-[#E3E4ED]/20
                                                  text-[#E3E4ED] placeholder-[#E3E4ED]/30 text-xs py-1
                                                  focus:outline-none focus:border-[#E3E4ED]/55 transition-colors text-right">
                                    <button type="button" @click="remove('languages', i)"
                                            class="text-[#E3E4ED]/35 hover:text-red-300 text-lg leading-none transition-colors shrink-0">&times;</button>
                                </div>
                            </template>
                            <p x-show="languages.length === 0" class="text-xs text-[#E3E4ED]/25 italic">
                                No languages yet
                            </p>
                        </div>
                    </div>

                </div>

                {{-- ══ RIGHT CONTENT ══════════════════════════════════ --}}
                <div class="bg-white flex-1 p-8 flex flex-col gap-8">

                    {{-- Experience --}}
                    <div>
                        <div class="flex items-end justify-between mb-5">
                            <div class="flex-1 mr-4">
                                <h2 class="text-xs font-bold tracking-[0.18em] text-accent uppercase">Experience</h2>
                                <div class="h-0.5 bg-secondary/30 mt-1.5 rounded-full"></div>
                            </div>
                            <button type="button" @click="add('experience')"
                                    class="text-xs font-medium text-secondary hover:text-accent transition-colors shrink-0 pb-1">
                                + Add
                            </button>
                        </div>

                        <div class="space-y-5">
                            <template x-for="(item, i) in experience" :key="i">
                                <div class="pl-4 border-l-2 border-secondary/25 group relative">
                                    <button type="button" @click="remove('experience', i)"
                                            class="absolute -left-[11px] top-0.5 w-5 h-5 rounded-full
                                                   bg-red-100 text-red-400 hover:bg-red-200
                                                   text-xs flex items-center justify-center
                                                   opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                        &times;
                                    </button>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-1.5">
                                        <div class="col-span-2 flex items-end justify-between gap-4">
                                            <input type="text" :name="`experience[${i}][role]`" x-model="item.role"
                                                   placeholder="Job Title"
                                                   class="flex-1 font-semibold text-sm text-gray-800 placeholder-gray-300
                                                          border-0 border-b border-gray-100 focus:border-secondary/50
                                                          focus:outline-none py-0.5 bg-transparent transition-colors">
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <input type="date" :name="`experience[${i}][start_date]`" x-model="item.start_date"
                                                       class="text-xs text-gray-400 border-0 border-b border-gray-100
                                                              focus:border-secondary/50 focus:outline-none py-0.5 bg-transparent
                                                              transition-colors w-32">
                                                <span class="text-gray-300 text-xs">—</span>
                                                <input type="date" :name="`experience[${i}][end_date]`" x-model="item.end_date"
                                                       class="text-xs text-gray-400 border-0 border-b border-gray-100
                                                              focus:border-secondary/50 focus:outline-none py-0.5 bg-transparent
                                                              transition-colors w-32">
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="text" :name="`experience[${i}][company]`" x-model="item.company"
                                                   placeholder="Company"
                                                   class="w-full text-sm text-secondary placeholder-gray-300
                                                          border-0 border-b border-gray-100 focus:border-secondary/50
                                                          focus:outline-none py-0.5 bg-transparent transition-colors">
                                        </div>
                                        <div class="col-span-2">
                                            <textarea :name="`experience[${i}][description]`" x-model="item.description"
                                                      placeholder="Key responsibilities and achievements…"
                                                      rows="2"
                                                      class="w-full text-sm text-gray-500 placeholder-gray-300
                                                             border-0 border-b border-gray-100 focus:border-secondary/50
                                                             focus:outline-none py-0.5 bg-transparent resize-none transition-colors leading-relaxed"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <p x-show="experience.length === 0"
                               class="text-sm text-gray-300 italic text-center py-3">
                                Click "+ Add" to add work experience
                            </p>
                        </div>
                    </div>

                    {{-- Education --}}
                    <div>
                        <div class="flex items-end justify-between mb-5">
                            <div class="flex-1 mr-4">
                                <h2 class="text-xs font-bold tracking-[0.18em] text-accent uppercase">Education</h2>
                                <div class="h-0.5 bg-secondary/30 mt-1.5 rounded-full"></div>
                            </div>
                            <button type="button" @click="add('education')"
                                    class="text-xs font-medium text-secondary hover:text-accent transition-colors shrink-0 pb-1">
                                + Add
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, i) in education" :key="i">
                                <div class="pl-4 border-l-2 border-secondary/25 group relative">
                                    <button type="button" @click="remove('education', i)"
                                            class="absolute -left-[11px] top-0.5 w-5 h-5 rounded-full
                                                   bg-red-100 text-red-400 hover:bg-red-200
                                                   text-xs flex items-center justify-center
                                                   opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                        &times;
                                    </button>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-1.5">
                                        <div>
                                            <input type="text" :name="`education[${i}][school]`" x-model="item.school"
                                                   placeholder="School / University"
                                                   class="w-full font-semibold text-sm text-gray-800 placeholder-gray-300
                                                          border-0 border-b border-gray-100 focus:border-secondary/50
                                                          focus:outline-none py-0.5 bg-transparent transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="`education[${i}][degree]`" x-model="item.degree"
                                                   placeholder="Degree / Field"
                                                   class="w-full text-sm text-secondary placeholder-gray-300
                                                          border-0 border-b border-gray-100 focus:border-secondary/50
                                                          focus:outline-none py-0.5 bg-transparent transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <p x-show="education.length === 0"
                               class="text-sm text-gray-300 italic text-center py-3">
                                Click "+ Add" to add education
                            </p>
                        </div>
                    </div>

                    {{-- Projects --}}
                    <div>
                        <div class="flex items-end justify-between mb-5">
                            <div class="flex-1 mr-4">
                                <h2 class="text-xs font-bold tracking-[0.18em] text-accent uppercase">Projects</h2>
                                <div class="h-0.5 bg-secondary/30 mt-1.5 rounded-full"></div>
                            </div>
                            <button type="button" @click="add('projects')"
                                    class="text-xs font-medium text-secondary hover:text-accent transition-colors shrink-0 pb-1">
                                + Add
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, i) in projects" :key="i">
                                <div class="pl-4 border-l-2 border-secondary/25 group relative">
                                    <button type="button" @click="remove('projects', i)"
                                            class="absolute -left-[11px] top-0.5 w-5 h-5 rounded-full
                                                   bg-red-100 text-red-400 hover:bg-red-200
                                                   text-xs flex items-center justify-center
                                                   opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                        &times;
                                    </button>
                                    <div class="space-y-1.5">
                                        <input type="text" :name="`projects[${i}][title]`" x-model="item.title"
                                               placeholder="Project Name"
                                               class="w-full font-semibold text-sm text-gray-800 placeholder-gray-300
                                                      border-0 border-b border-gray-100 focus:border-secondary/50
                                                      focus:outline-none py-0.5 bg-transparent transition-colors">
                                        <textarea :name="`projects[${i}][description]`" x-model="item.description"
                                                  placeholder="Briefly describe the project…"
                                                  rows="2"
                                                  class="w-full text-sm text-gray-500 placeholder-gray-300
                                                         border-0 border-b border-gray-100 focus:border-secondary/50
                                                         focus:outline-none py-0.5 bg-transparent resize-none transition-colors leading-relaxed"></textarea>
                                    </div>
                                </div>
                            </template>
                            <p x-show="projects.length === 0"
                               class="text-sm text-gray-300 italic text-center py-3">
                                Click "+ Add" to add projects
                            </p>
                        </div>
                    </div>

                </div>
                {{-- ══ END RIGHT CONTENT ══════════════════════════════ --}}

            </div>

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="mt-5 bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-red-600 mb-2">Please fix the following:</p>
                    <ul class="list-disc list-inside text-sm text-red-500 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </form>
</x-app-layout>
