{{-- ============ LEAD FORM (the funnel's conversion point) ============ --}}
<form class="bg-ivory text-charcoal-800 rounded-sm shadow-2xl p-7 sm:p-9" method="POST" action="{{ route('leads.store') }}" id="lead-form">
    @csrf
    <h3 class="font-display text-2xl font-semibold text-maroon-900">Request a Call Back</h3>
    <p class="mt-1.5 text-sm text-charcoal-600">Our team replies within 24 hours, Sun–Thu.</p>

    @if (session('success'))
    <div class="mt-5 rounded-sm border border-gold-600/50 bg-gold-100 px-5 py-4 text-sm font-medium text-maroon-900" role="status">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-7 space-y-5">
        <div>
            <label for="parent_name" class="block text-sm font-medium mb-1.5">Parent's Full Name <span class="text-maroon-600" aria-hidden="true">*</span></label>
            <input type="text" id="parent_name" name="parent_name" required autocomplete="name" value="{{ old('parent_name') }}"
                   class="w-full h-12 px-4 rounded-sm border @error('parent_name') border-red-500 @else border-beige-300 @enderror bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
            @error('parent_name')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium mb-1.5">Mobile Number <span class="text-maroon-600" aria-hidden="true">*</span></label>
            <input type="tel" id="phone" name="phone" required autocomplete="tel" inputmode="numeric" maxlength="11" pattern="01[0-9]{9}" title="Please enter an 11-digit mobile number starting with 01" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11)" placeholder="01XXXXXXXXX" value="{{ old('phone') }}"
                   class="w-full h-12 px-4 rounded-sm border @error('phone') border-red-500 @else border-beige-300 @enderror bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
            @error('phone')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label for="child_age" class="block text-sm font-medium mb-1.5">Child's Age <span class="text-maroon-600" aria-hidden="true">*</span></label>
                <select id="child_age" name="child_age" required
                        class="w-full h-12 px-3 rounded-sm border @error('child_age') border-red-500 @else border-beige-300 @enderror bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    <option value="" disabled @selected(old('child_age') === null)>Select age</option>
                    @for ($age = 3; $age <= 17; $age++)
                    <option value="{{ $age }}" @selected(old('child_age') == $age)>{{ $age }} years</option>
                    @endfor
                </select>
                @error('child_age')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="stage" class="block text-sm font-medium mb-1.5">Stage of Interest</label>
                <select id="stage" name="stage"
                        class="w-full h-12 px-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    <option value="" @selected(old('stage') === null || old('stage') === '')>Not sure yet</option>
                    <option value="early-years" @selected(old('stage') === 'early-years')>Early Years (FS1–FS2)</option>
                    <option value="primary" @selected(old('stage') === 'primary')>Primary (Years 1–6)</option>
                    <option value="secondary" @selected(old('stage') === 'secondary')>Secondary &amp; IGCSE</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-gold w-full !py-4">
            Request a Call Back
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
        </button>
        <p class="text-xs text-charcoal-600/80 text-center">Your information is kept private and used only to contact you about admissions.</p>
    </div>
</form>
