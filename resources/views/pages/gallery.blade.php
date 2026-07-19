@extends('layouts.site')

@section('title', 'Gallery — Moments from the Valley | Knowledge Valley International School')
@section('description', 'Browse moments from life at KVS — science fairs, graduations, art exhibitions, sports and celebrations.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'School Life',
    'title'   => 'Moments from the Valley',
    'lead'    => 'Science fairs, graduations, art, sports and celebrations — a picture of life at KVS. (Placeholder images — real photos coming soon.)',
    'crumbs'  => [['label' => 'School Life', 'url' => route('school-life')], ['label' => 'Gallery']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
                $gallery = [
                    ['img' => 'g-science-fair', 'label' => 'KVS Science Fair'],
                    ['img' => 'g-graduation',   'label' => 'Graduation 2025'],
                    ['img' => 'g-art',          'label' => 'Art Exhibition'],
                    ['img' => 'g-book-fair',    'label' => 'KVS Book Fair'],
                    ['img' => 'g-chess',        'label' => 'Chess Academy'],
                    ['img' => 'g-peace-day',    'label' => 'International Peace Day'],
                    ['img' => 'c-sports',       'label' => 'Sports Day'],
                    ['img' => 'c-science-lab',  'label' => 'In the Lab'],
                    ['img' => 'c-library',      'label' => 'Library Time'],
                    ['img' => 'c-art-room',     'label' => 'Creative Corner'],
                    ['img' => 'c-theatre',      'label' => 'On Stage'],
                    ['img' => 'c-playground',   'label' => 'Break Time'],
                ];
            @endphp
            @foreach ($gallery as $item)
            <figure class="reveal group relative rounded-sm overflow-hidden">
                <img src="/images/placeholders/{{ $item['img'] }}.svg" alt="{{ $item['label'] }} at KVS" class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-[1.04]" width="1600" height="1200" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-maroon-950/85 via-maroon-950/10 to-transparent"></div>
                <figcaption class="absolute bottom-0 inset-x-0 p-4 sm:p-5 text-ivory font-display font-semibold text-sm sm:text-lg">{{ $item['label'] }}</figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>

@endsection
