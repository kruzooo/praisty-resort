<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function create()
    {
        if ((Auth::check() && Auth::user()->is_admin) || session('admin_profile.is_admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin-login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'staff_identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
            'two_factor_code' => ['required', 'digits:6'],
        ]);

        if ($this->usesFileAccounts()) {
            $admin = collect($this->fileAccounts())
                ->first(fn (array $account) => strtolower($account['email']) === strtolower($credentials['staff_identifier'])
                    || strtolower($account['staff_identifier']) === strtolower($credentials['staff_identifier']));

            if (! $admin
                || ! Hash::check($credentials['password'], $admin['password'])
                || ! hash_equals((string) config('admin-accounts.two_factor_code'), $credentials['two_factor_code'])) {
                return back()->withErrors([
                    'staff_identifier' => 'The administrative credentials could not be verified.',
                ])->onlyInput('staff_identifier');
            }

            $request->session()->put('admin_profile', [
                'name' => $admin['name'],
                'email' => $admin['email'],
                'staff_identifier' => $admin['staff_identifier'],
                'is_admin' => true,
            ]);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        $admin = User::query()
            ->where('staff_identifier', $credentials['staff_identifier'])
            ->orWhere('email', $credentials['staff_identifier'])
            ->first();

        if (! $admin
            || ! $admin->is_admin
            || ! Hash::check($credentials['password'], $admin->password)
            || ! $admin->two_factor_code
            || ! Hash::check($credentials['two_factor_code'], $admin->two_factor_code)) {
            return back()->withErrors([
                'staff_identifier' => 'The administrative credentials could not be verified.',
            ])->onlyInput('staff_identifier');
        }

        Auth::login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('admin-dashboard');
    }

    public function operations(string $page)
    {
        $pages = $this->adminPages();

        abort_unless(isset($pages[$page]), 404);

        return view('admin-page', [
            'admin' => Auth::user() ?? (object) session('admin_profile'),
            'page' => $pages[$page],
            'nav' => $this->adminNav(),
        ]);
    }

    public function feedback()
    {
        return view('admin-feedback', [
            'admin' => Auth::user() ?? (object) session('admin_profile'),
            'feedbackEntries' => collect($this->feedbackEntries())->sortByDesc('created_at')->values(),
            'nav' => $this->adminNav(),
        ]);
    }

    public function deleteFeedback(CustomerFeedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedback')->with('admin_status', 'Guest feedback deleted successfully.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->forget('admin_profile');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('admin_status', 'Administrative session signed out.');
    }

    private function usesFileAccounts(): bool
    {
        return config('admin-accounts.storage') === 'file';
    }

    private function fileAccounts(): array
    {
        $path = storage_path('app/admin-accounts.json');

        if (! is_file($path)) {
            return [];
        }

        return json_decode((string) file_get_contents($path), true) ?: [];
    }

    private function adminNav(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'grid_view', 'route' => route('admin.dashboard')],
            ['label' => 'Reservations & Stays', 'icon' => 'calendar_month', 'route' => route('admin.operations', 'reservations')],
            ['label' => 'Villa Inventory', 'icon' => 'villa', 'route' => route('admin.operations', 'villas')],
            ['label' => 'Concierge Requests', 'icon' => 'room_service', 'route' => route('admin.operations', 'concierge')],
            ['label' => 'Financials & Yield', 'icon' => 'payments', 'route' => route('admin.operations', 'financials')],
            ['label' => 'Guest Feedback', 'icon' => 'reviews', 'route' => route('admin.feedback')],
        ];
    }

    private function adminPages(): array
    {
        return [
            'reservations' => [
                'eyebrow' => 'Reservations & Stays',
                'title' => 'Guest Stay Management',
                'summary' => 'Track arrivals, booking status, villa assignments, and pending guest actions.',
                'stats' => [
                    ['label' => 'Processing', 'value' => '12', 'tone' => 'bg-amber-50 text-amber-800'],
                    ['label' => 'Successfully Booked', 'value' => '34', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Cancelled', 'value' => '3', 'tone' => 'bg-red-50 text-error'],
                ],
                'rows' => [
                    ['title' => 'Alexander Cruz', 'meta' => 'Overwater Wellness Pavilion · Sep 29 - Oct 2', 'status' => 'Processing', 'note' => 'Payment review pending'],
                    ['title' => 'Elena Vandermeer', 'meta' => 'Treetop Canopy Villa · Oct 4 - Oct 8', 'status' => 'Successfully Booked', 'note' => 'Butler and transfer assigned'],
                    ['title' => 'Sofia Lim', 'meta' => 'Garden Pool Villa · Oct 14 - Oct 16', 'status' => 'Cancelled', 'note' => 'Guest requested date change'],
                ],
                'actions' => [
                    ['label' => 'Create reservation', 'icon' => 'add', 'route' => route('admin.operations', 'new-reservation')],
                    ['label' => 'Arrival details', 'icon' => 'fact_check', 'route' => route('admin.operations', 'arrival-details')],
                ],
            ],
            'villas' => [
                'eyebrow' => 'Villa Inventory',
                'title' => 'Housekeeping & Villa Readiness',
                'summary' => 'Monitor each accommodation status before guests arrive.',
                'stats' => [
                    ['label' => 'Ready', 'value' => '28', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Turnover', 'value' => '4', 'tone' => 'bg-amber-50 text-amber-800'],
                    ['label' => 'Maintenance', 'value' => '2', 'tone' => 'bg-red-50 text-error'],
                ],
                'rows' => [
                    ['title' => 'Royal Overwater Bungalow #104', 'meta' => 'Final inspection complete', 'status' => 'Ready', 'note' => 'Welcome amenity placed'],
                    ['title' => 'Sunset Beachfront Villa #207', 'meta' => 'Fresh linens and pool check', 'status' => 'Turnover', 'note' => 'Ready by 14:30'],
                    ['title' => 'Palm Studio Suite #118', 'meta' => 'AC maintenance ticket', 'status' => 'Maintenance', 'note' => 'Engineering assigned'],
                ],
                'actions' => [
                    ['label' => 'Assign butler', 'icon' => 'room_service', 'route' => route('admin.operations', 'assign-butler')],
                ],
            ],
            'concierge' => [
                'eyebrow' => 'Concierge Requests',
                'title' => 'Guest Experience Queue',
                'summary' => 'Handle guest requests for meals, transfers, events, and special arrangements.',
                'stats' => [
                    ['label' => 'Open Requests', 'value' => '9', 'tone' => 'bg-amber-50 text-amber-800'],
                    ['label' => 'Completed Today', 'value' => '17', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Needs Approval', 'value' => '2', 'tone' => 'bg-red-50 text-error'],
                ],
                'rows' => [
                    ['title' => 'Private sunset dinner', 'meta' => 'Seaside Romance Suite · 18:30', 'status' => 'Processing', 'note' => 'Chef preparing menu'],
                    ['title' => 'Allergen-free tasting menu', 'meta' => 'Azure Ocean Suite', 'status' => 'Successfully Booked', 'note' => 'Kitchen notified'],
                    ['title' => 'Speedboat reschedule', 'meta' => 'Airport transfer', 'status' => 'Processing', 'note' => 'Awaiting dock approval'],
                ],
                'actions' => [
                    ['label' => 'Dispatch speedboat', 'icon' => 'directions_boat', 'route' => route('admin.operations', 'dispatch-speedboat')],
                    ['label' => 'Assign butler', 'icon' => 'room_service', 'route' => route('admin.operations', 'assign-butler')],
                ],
            ],
            'financials' => [
                'eyebrow' => 'Financials & Yield',
                'title' => 'Revenue Snapshot',
                'summary' => 'Review room value, upsells, and payment method activity.',
                'stats' => [
                    ['label' => 'Projected Revenue', 'value' => 'PHP 1.84M', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'ADR', 'value' => 'PHP 68.5K', 'tone' => 'bg-surface-container-low text-primary'],
                    ['label' => 'Upsell Rate', 'value' => '14.1%', 'tone' => 'bg-amber-50 text-amber-800'],
                ],
                'rows' => [
                    ['title' => 'Card payment links', 'meta' => '12 sent today', 'status' => 'Processing', 'note' => '3 awaiting confirmation'],
                    ['title' => 'GCash concierge payments', 'meta' => '5 selected by guests', 'status' => 'Successfully Booked', 'note' => 'Concierge follow-up ready'],
                    ['title' => 'Bank transfer requests', 'meta' => '4 pending invoice instructions', 'status' => 'Processing', 'note' => 'Finance review'],
                ],
                'actions' => [],
            ],
            'new-reservation' => [
                'eyebrow' => 'VIP Reservation',
                'title' => 'Create New VIP Reservation',
                'summary' => 'Use this workspace to prepare a new high-touch booking for a guest.',
                'stats' => [
                    ['label' => 'Available Villas', 'value' => '18', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Pending Holds', 'value' => '6', 'tone' => 'bg-amber-50 text-amber-800'],
                    ['label' => 'High Priority', 'value' => '2', 'tone' => 'bg-red-50 text-error'],
                ],
                'rows' => [
                    ['title' => 'Guest profile', 'meta' => 'Collect full name, email, phone, and celebration notes', 'status' => 'Processing', 'note' => 'Ready for input'],
                    ['title' => 'Villa selection', 'meta' => 'Match stay dates with availability', 'status' => 'Processing', 'note' => 'Use Reservations & Stays after creating'],
                ],
                'actions' => [
                    ['label' => 'Back to reservations', 'icon' => 'arrow_back', 'route' => route('admin.operations', 'reservations')],
                ],
            ],
            'dispatch-speedboat' => [
                'eyebrow' => 'Marine Transfer',
                'title' => 'Dispatch Speedboat',
                'summary' => 'Coordinate dock timing, captains, and private guest transfers.',
                'stats' => [
                    ['label' => 'Boats Ready', 'value' => '4', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Scheduled Runs', 'value' => '7', 'tone' => 'bg-surface-container-low text-primary'],
                    ['label' => 'Weather Risk', 'value' => 'Low', 'tone' => 'bg-green-50 text-secondary'],
                ],
                'rows' => [
                    ['title' => 'Dock Alpha', 'meta' => 'Alexander Cruz · 13:45 arrival', 'status' => 'Processing', 'note' => 'Captain Rey assigned'],
                    ['title' => 'Helipad connection', 'meta' => 'Elena Vandermeer · private charter', 'status' => 'Successfully Booked', 'note' => 'Ground team notified'],
                ],
                'actions' => [
                    ['label' => 'Concierge queue', 'icon' => 'room_service', 'route' => route('admin.operations', 'concierge')],
                ],
            ],
            'assign-butler' => [
                'eyebrow' => 'Guest Service',
                'title' => 'Assign Butler',
                'summary' => 'Pair each guest with a villa host based on stay needs.',
                'stats' => [
                    ['label' => 'Available Hosts', 'value' => '11', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Assigned Today', 'value' => '24', 'tone' => 'bg-surface-container-low text-primary'],
                    ['label' => 'VIP Requests', 'value' => '5', 'tone' => 'bg-amber-50 text-amber-800'],
                ],
                'rows' => [
                    ['title' => 'Maya Soriano', 'meta' => 'Senior Butler · wellness stays', 'status' => 'Successfully Booked', 'note' => 'Assigned to Alexander Cruz'],
                    ['title' => 'Noel Reyes', 'meta' => 'Villa Host · private charters', 'status' => 'Successfully Booked', 'note' => 'Assigned to Elena Vandermeer'],
                    ['title' => 'Lia Moreno', 'meta' => 'Dining and celebration specialist', 'status' => 'Processing', 'note' => 'Available for new request'],
                ],
                'actions' => [
                    ['label' => 'Villa inventory', 'icon' => 'villa', 'route' => route('admin.operations', 'villas')],
                ],
            ],
            'arrival-details' => [
                'eyebrow' => 'Arrival Details',
                'title' => 'Guest Arrival Timeline',
                'summary' => 'A focused page for arrival route, transfer, butler, and final status.',
                'stats' => [
                    ['label' => 'Arriving Today', 'value' => '8', 'tone' => 'bg-green-50 text-secondary'],
                    ['label' => 'Transfers Pending', 'value' => '3', 'tone' => 'bg-amber-50 text-amber-800'],
                    ['label' => 'Delayed', 'value' => '1', 'tone' => 'bg-red-50 text-error'],
                ],
                'rows' => [
                    ['title' => 'Alexander Cruz', 'meta' => 'Flight PR 2132 · Dock Alpha speedboat', 'status' => 'Processing', 'note' => 'ETA 13:45'],
                    ['title' => 'Elena Vandermeer', 'meta' => 'Private charter · South helipad', 'status' => 'Successfully Booked', 'note' => 'ETA 15:20'],
                ],
                'actions' => [
                    ['label' => 'Dispatch speedboat', 'icon' => 'directions_boat', 'route' => route('admin.operations', 'dispatch-speedboat')],
                ],
            ],
        ];
    }

    private function feedbackEntries(): array
    {
        $guestFeedback = CustomerFeedback::query()
            ->latest()
            ->get()
            ->map(fn (CustomerFeedback $feedback) => [
                'id' => $feedback->id,
                'type' => 'Guest Feedback',
                'name' => $feedback->name,
                'email' => $feedback->email,
                'rating' => $feedback->rating,
                'message' => $feedback->message,
                'reference' => $feedback->reference ?? 'Guest dashboard',
                'created_at' => $feedback->created_at?->toDateTimeString() ?? now()->toDateTimeString(),
            ]);

        $contactMessages = ContactMessage::query()
            ->latest()
            ->get()
            ->map(fn (ContactMessage $message) => [
                'id' => null,
                'type' => 'Contact Inquiry',
                'name' => $message->name,
                'email' => $message->email,
                'rating' => null,
                'message' => $message->message,
                'reference' => ucfirst(str_replace('_', ' ', $message->subject)),
                'created_at' => $message->created_at?->toDateTimeString() ?? now()->toDateTimeString(),
            ]);

        return $guestFeedback
            ->merge($contactMessages)
            ->sortByDesc('created_at')
            ->values()
            ->all();
    }
}
