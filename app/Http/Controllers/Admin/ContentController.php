<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /** Groups managed as editable lists. */
    private const GROUPS = [
        'faq'     => ['title' => 'Frequently Asked Questions', 'singular' => 'FAQ', 'live' => '/faqs', 'has_icon' => false],
        'service' => ['title' => 'Parent Services', 'singular' => 'Service', 'live' => '/services', 'has_icon' => true],
    ];

    /** Content hub — every page of the site, with live preview + edit links. */
    public function hub()
    {
        $pages = [
            ['name' => 'Home', 'url' => '/', 'edit' => null],
            ['name' => 'About Us', 'url' => '/about', 'edit' => null],
            ['name' => 'Leadership', 'url' => '/leadership', 'edit' => null],
            ['name' => 'Accreditations', 'url' => '/accreditations', 'edit' => null],
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
            ['name' => 'Contact', 'url' => '/contact', 'edit' => null],
            ['name' => 'Careers', 'url' => '/careers', 'edit' => null],
        ];

        $modules = [
            ['name' => 'Events & Gallery', 'desc' => 'Add, edit, reorder events and their photos.', 'route' => route('admin.events.index')],
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
        $data = $this->validated($request);
        $data['group'] = $group;
        $data['sort_order'] = $data['sort_order'] ?? (ContentItem::group($group)->max('sort_order') + 1);
        ContentItem::create($data);

        return back()->with('success', self::GROUPS[$group]['singular'] . ' added.');
    }

    public function update(Request $request, ContentItem $item)
    {
        $item->update($this->validated($request));

        return back()->with('success', 'Saved.');
    }

    public function destroy(ContentItem $item)
    {
        $item->delete();

        return back()->with('success', 'Removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'body'       => ['nullable', 'string', 'max:5000'],
            'icon'       => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
