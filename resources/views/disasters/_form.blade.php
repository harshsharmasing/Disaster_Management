@php $disaster = $disaster ?? null; @endphp

{{-- Name --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Disaster Name <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $disaster?->name) }}"
           class="w-full px-4 py-2.5 border rounded-xl text-sm transition {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
           placeholder="e.g. 2024 Kerala Floods">
    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Type + Severity --}}
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Type <span class="text-red-500">*</span></label>
        <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition {{ $errors->has('type') ? 'border-red-400' : '' }}">
            <option value="">Select type…</option>
            @foreach($types as $type)
                <option value="{{ $type }}" {{ old('type', $disaster?->type) === $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Severity <span class="text-red-500">*</span></label>
        <select name="severity" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition {{ $errors->has('severity') ? 'border-red-400' : '' }}">
            <option value="">Select…</option>
            @foreach($severities as $sev)
                <option value="{{ $sev }}" {{ old('severity', $disaster?->severity) === $sev ? 'selected' : '' }}>
                    {{ ucfirst($sev) }}
                </option>
            @endforeach
        </select>
        @error('severity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

{{-- Region --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Region <span class="text-gray-400 font-normal">(optional)</span></label>
    <input type="text" name="region" value="{{ old('region', $disaster?->region) }}"
           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"
           placeholder="e.g. Kerala, India">
</div>

{{-- Description --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
    <textarea name="description" rows="3"
              class="w-full px-4 py-2.5 border rounded-xl text-sm transition resize-none {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
              placeholder="Describe the disaster, its causes and impact (at least 50 characters)…">{{ old('description', $disaster?->description) }}</textarea>
    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- What To Do --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
        <span class="text-green-600">✓</span> What To Do <span class="text-red-500">*</span>
    </label>
    <textarea name="what_to_do" rows="4"
              class="w-full px-4 py-2.5 border rounded-xl text-sm transition resize-none {{ $errors->has('what_to_do') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
              placeholder="List the safety actions people should take…">{{ old('what_to_do', $disaster?->what_to_do) }}</textarea>
    @error('what_to_do') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- What Not To Do --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
        <span class="text-red-500">✕</span> What Not To Do <span class="text-red-500">*</span>
    </label>
    <textarea name="what_not_to_do" rows="4"
              class="w-full px-4 py-2.5 border rounded-xl text-sm transition resize-none {{ $errors->has('what_not_to_do') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
              placeholder="List common mistakes and dangerous actions to avoid…">{{ old('what_not_to_do', $disaster?->what_not_to_do) }}</textarea>
    @error('what_not_to_do') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
