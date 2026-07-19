@extends('layouts.app')

@section('title', 'Join Our Team — Careers at Knowledge Valley International School')
@section('meta_description', 'Teach at KVS: join a British curriculum international school in Giza where teachers feel valued, respected and motivated to deliver exceptional learning.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Join Our Team',
    'subtitle' => 'Great schools are built by great teachers. If that\'s you — we\'d love to hear from you.',
    'crumbs' => [['Contact', '/contact'], ['Join Our Team', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-12 items-start">
        <div class="reveal">
            <p class="eyebrow">Working at KVS</p>
            <h2 class="heading-serif text-2xl sm:text-3xl mt-3 gold-rule-left">A School That Values Its Teachers</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                At Knowledge Valley, teachers feel valued, respected and motivated to deliver exceptional learning
                experiences. We invest in professional development, provide a supportive leadership structure, and
                build a community where educators grow alongside their students.
            </p>
            <ul class="mt-8 space-y-4">
                @php $careers_list0 = [
                    'British curriculum classrooms with international accreditation standards',
                    'Continuous professional development and training',
                    'A collaborative, respectful staff culture',
                    'Clear career progression within a growing school',
                ]; @endphp
                @foreach ($careers_list0 as $item)
                <li class="flex gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-charcoal-700">{{ $item }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="reveal">
            <form class="bg-white border border-beige-200 rounded-sm shadow-xl p-7 sm:p-10" method="POST" action="#">
                <h2 class="font-display text-2xl font-semibold text-maroon-900">Apply Now</h2>
                <p class="mt-1.5 text-sm text-charcoal-600">Send your details and CV — our HR team reviews every application.</p>
                <div class="mt-8 space-y-5">
                    <div>
                        <label for="c_name" class="block text-sm font-medium mb-1.5">Full Name <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="text" id="c_name" name="name" required autocomplete="name" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="c_phone" class="block text-sm font-medium mb-1.5">Mobile Number <span class="text-maroon-600" aria-hidden="true">*</span></label>
                            <input type="tel" id="c_phone" name="phone" required autocomplete="tel" inputmode="tel" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label for="c_email" class="block text-sm font-medium mb-1.5">Email <span class="text-maroon-600" aria-hidden="true">*</span></label>
                            <input type="email" id="c_email" name="email" required autocomplete="email" inputmode="email" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div>
                        <label for="c_position" class="block text-sm font-medium mb-1.5">Position Applying For <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <select id="c_position" name="position" required class="w-full h-12 px-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                            <option value="" selected disabled>Select position</option>
                            <option>Early Years Teacher</option>
                            <option>Primary Teacher</option>
                            <option>Secondary Teacher</option>
                            <option>Languages Teacher (German / French)</option>
                            <option>Administration</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="c_cv" class="block text-sm font-medium mb-1.5">Upload CV (PDF) <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="file" id="c_cv" name="cv" accept=".pdf,.doc,.docx" required class="w-full text-sm file:mr-4 file:btn-maroon file:!py-2.5 file:!px-5 file:border-0 file:cursor-pointer text-charcoal-600">
                        <p class="mt-1.5 text-xs text-charcoal-600/70">PDF or Word, up to 5 MB.</p>
                    </div>
                    <button type="submit" class="btn-gold w-full !py-4">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
