<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Groups managed as editable lists.
     * kind: text | service | image | video
     */
    private const GROUPS = [
        'faq' => [
            'title' => 'Frequently Asked Questions', 'singular' => 'FAQ',
            'live' => '/faqs', 'kind' => 'text',
        ],
        'service' => [
            'title' => 'Parent Services', 'singular' => 'Service',
            'live' => '/services', 'kind' => 'service',
        ],
        'accreditation' => [
            'title' => 'Accreditations & Certificates', 'singular' => 'Accreditation',
            'live' => '/accreditations', 'kind' => 'image',
        ],
        'testimonial' => [
            'title' => 'Parent Testimonials (Videos)', 'singular' => 'Testimonial',
            'live' => '/#testimonials', 'kind' => 'video',
        ],
    ];

    /** Content hub — every page of the site, with live preview + edit links. */
    public function hub()
    {
        $accEdit = route('admin.content.group', 'accreditation');
        $testEdit = route('admin.content.group', 'testimonial');

        $pages = [
            ['name' => 'Home', 'url' => '/', 'edit' => $testEdit],
            ['name' => 'About Us', 'url' => '/about', 'edit' => null],
            ['name' => 'Leadership', 'url' => '/leadership', 'edit' => null],
            ['name' => 'Accreditations', 'url' => '/accreditations', 'edit' => $accEdit],
            ['name' => 'Academics', 'url' => '/academics', 'edit' => null],
            ['name' => 'Early Years', 'url' => '/academics/early-years', 'edit' => null],
            ['name' => 'Primary', 'url' => '/academics/primary', 'edit' => null],
            ['name' => 'Secondary', 'url' => '/academics/secondary', 'edit' => null],
            ['name' => 'Admissions', 'url' => '/admissions', 'edit' => null],
            ['name' => 'Book a Tour', 'url' => '/book-a-tour', 'edit' => null],
            ['name' => 'Tuition & Fees', 'url' => '/fees', 'edit' => null],
            ['name' => 'FAQs', 'url' => '/faqs', 'edit' => route('admin.content.group', 'faq')],
            ['name' => 'School Life', 'url' => '/school-life', 'edit' => null],
            ['name' => 'Parent Services', 'url' => '/services', 'edit' => route('admin.content.group', 'service')],
            ['name' => 'Events', 'url' => '/events', 'edit' => route('admin.events.index')],
            ['name' => 'Contact', 'url' => '/contact', 'edit' => null],
            ['name' => 'Careers', 'url' => '/careers', 'edit' => null],
        ];

        $modules = [
            ['name' => 'Events & Gallery', 'desc' => 'Add, edit, reorder events and their photos.', 'route' => route('admin.events.index')],
            ['name' => 'Parent Testimonials', 'desc' => 'Add or replace the parent video testimonials on the homepage.', 'route' => $testEdit],
            ['name' => 'Accreditations', 'desc' => 'Upload accreditation & certificate images.', 'route' => $accEdit],
            ['name' => 'FAQs', 'desc' => 'Edit the questions and answers parents see.', 'route' => route('admin.content.group', 'faq')],
            ['name' => 'Parent Services', 'desc' => 'Edit or add the parent-services cards.', 'route' => route('admin.content.group', 'service')],
            ['name' => 'Site Settings', 'desc' => 'Phones, emails, social links, tracking IDs.', 'route' => route('admin.settings')],
        ];

        return view('admin.content.hub', compact('pages', 'modules'));
    }

    public function group(string $group)
    {
        abort_unless(isset(self::GROUPS[$group]), 404);
        $meta = self::GROUPS[$group];
        $items = ContentItem::group($group)->ordered()->get();

        return view('admin.content.group', compact('group', 'meta', 'items'));
    }

    public function store(Request $request, string $group)
    {
        abort_unless(isset(self::GROUPS[$group]), 404);
        $kind = self::GROUPS[$group]['kind'];
        $data = $this->validated($request, $kind);
        $data['group'] = $group;
        $data['sort_order'] = $data['sort_order'] ?? (ContentItem::group($group)->max('sort_order') + 1);

        $this->applyUploads($request, $kind, $data);

        ContentItem::create($data);

        return back()->with('success', self::GROUPS[$group]['singular'] . ' added.');
    }

    public function update(Request $request, ContentItem $item)
    {
        $kind = self::GROUPS[$item->group]['kind'] ?? 'text';
        $data = $this->validated($request, $kind);

        $this->applyUploads($request, $kind, $data);

        $item->update($data);

        return back()->with('success', 'Saved.');
    }

    public function destroy(ContentItem $item)
    {
        $item->delete();

        return back()->with('success', 'Removed.');
    }

    private function validated(Request $request, string $kind): array
    {
        $rules = [
            'title'      => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
        if (in_array($kind, ['text', 'service', 'image'], true)) {
            $rules['body'] = ['nullable', 'string', 'max:5000'];
        }
        if ($kind === 'service') {
            $rules['icon'] = ['nullable', 'string', 'max:3000'];
        }
        if ($kind === 'image') {
            $rules['image_file'] = ['nullable', 'image', 'max:8192'];
        }
        if ($kind === 'video') {
            $rules['video_file']  = ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:61440'];
            $rules['poster_file'] = ['nullable', 'image', 'max:8192'];
        }

        $data = $request->validate($rules);

        $out = [
            'title'      => $data['title'],
            'sort_order' => $data['sort_order'] ?? null,
            'is_active'  => $request->boolean('is_active'),
        ];
        if ($kind !== 'video') {
            $out['body'] = $data['body'] ?? null;
        }
        if ($kind === 'service') {
            $out['icon'] = $data['icon'] ?? null;
        }

        return $out;
    }

    private function applyUploads(Request $request, string $kind, array &$data): void
    {
        if ($kind === 'image' && $request->hasFile('image_file')) {
            $data['icon'] = $this->upload($request->file('image_file'), public_path('img'), '/img', 'acc');
        }
        if ($kind === 'video') {
            if ($request->hasFile('video_file')) {
                $data['icon'] = $this->upload($request->file('video_file'), public_path('videos'), '/videos', 'testimonial');
            }
            if ($request->hasFile('poster_file')) {
                $data['body'] = $this->upload($request->file('poster_file'), public_path('videos/posters'), '/videos/posters', 'poster');
            }
        }
    }

    private function upload($file, string $dir, string $publicPrefix, string $prefix): string
    {
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = $prefix . '-' . date('Ymd_His') . '-' . Str::random(6) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move($dir, $name);

        return $publicPrefix . '/' . $name;
    }
}
