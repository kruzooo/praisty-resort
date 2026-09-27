<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\ContactMessage;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function rooms(Request $request)
    {
        $filters = $request->validate([
            'check_in' => ['nullable', 'date', 'required_with:check_out'],
            'check_out' => ['nullable', 'date', 'required_with:check_in', 'after:check_in'],
            'guests' => ['nullable', 'integer', 'in:1,2,3,4'],
            'room_type' => ['nullable', 'in:all,suite,villa,pavilion'],
            'sort' => ['nullable', 'in:popularity,price_low,price_high,size'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $guests = (int) ($filters['guests'] ?? 2);
        $roomType = $filters['room_type'] ?? 'all';
        $sort = $filters['sort'] ?? 'popularity';

        $rooms = collect($this->accommodations())
            ->filter(fn (array $room) => $roomType === 'all' || $room['category'] === $roomType)
            ->filter(fn (array $room) => $room['capacity'] >= $guests);

        $rooms = (match ($sort) {
            'price_low' => $rooms->sortBy('priceValue'),
            'price_high' => $rooms->sortByDesc('priceValue'),
            'size' => $rooms->sortByDesc('sizeValue'),
            default => $rooms,
        })->values();

        $perPage = 4;
        $totalPages = max(1, (int) ceil($rooms->count() / $perPage));
        $currentPage = min((int) ($filters['page'] ?? 1), $totalPages);

        return view('rooms', [
            'visibleRooms' => $rooms->slice(($currentPage - 1) * $perPage, $perPage),
            'roomCount' => $rooms->count(),
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'filters' => [
                'check_in' => $filters['check_in'] ?? '',
                'check_out' => $filters['check_out'] ?? '',
                'guests' => $guests,
                'room_type' => $roomType,
                'sort' => $sort,
            ],
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'business_type' => ['required', 'string', 'max:255'],
        ]);

        return 'Generated successfully';
    }

    public function customerDashboard(Request $request)
    {
        $account = $request->session()->get('guest_profile');
        $reservationGuest = $request->session()->get('guest_reservation', []);
        $user = $request->user();
        $guest = [
            'name' => $reservationGuest['full_name'] ?? $account['name'] ?? $user?->name ?? 'Guest',
            'email' => $reservationGuest['email'] ?? $account['email'] ?? $user?->email ?? '',
            'reference' => $reservationGuest['reference'] ?? null,
        ];

        $stay = $request->session()->has('reservation')
            ? $this->reservationSummary($request)
            : null;

        $latestReservation = $user
            ? Reservation::query()->where('user_id', $user->id)->latest()->first()
            : null;

        if (! $stay && $latestReservation) {
            $room = $this->findAccommodation($latestReservation->room_slug);
            $stay = [
                'room' => $room,
                'reservation' => [
                    'room' => $latestReservation->room_slug,
                    'check_in' => $latestReservation->check_in->toDateString(),
                    'check_out' => $latestReservation->check_out->toDateString(),
                    'guests' => $latestReservation->guests,
                ],
                'checkIn' => $latestReservation->check_in,
                'checkOut' => $latestReservation->check_out,
                'nights' => $latestReservation->nights,
                'stayTotal' => $latestReservation->stay_total,
                'resortFee' => $latestReservation->resort_fee,
                'taxes' => $latestReservation->taxes,
            ];
            $guest['reference'] = $latestReservation->reference;
        }

        return view('customer-dashboard', compact('guest', 'stay'));
    }

    public function roomDetails(string $room)
    {
        return view('room-details', [
            'room' => $this->findAccommodation($room),
        ]);
    }

    public function reserveRoom(Request $request, string $room)
    {
        $accommodation = $this->findAccommodation($room);

        $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:'.$accommodation['capacity']],
        ]);

        $request->session()->put('reservation', [
            'room' => Str::slug($accommodation['name']),
            'check_in' => $request->string('check_in')->toString(),
            'check_out' => $request->string('check_out')->toString(),
            'guests' => (int) $request->input('guests'),
        ]);

        return redirect()->route('reservation.cart');
    }

    public function reservationCart(Request $request)
    {
        $reservation = $request->session()->get('reservation');

        if (! $reservation) {
            return redirect()->route('rooms');
        }

        $room = $this->findAccommodation($reservation['room']);
        $checkIn = \Carbon\Carbon::parse($reservation['check_in']);
        $checkOut = \Carbon\Carbon::parse($reservation['check_out']);
        $nights = $checkIn->diffInDays($checkOut);
        $stayTotal = $room['priceValue'] * $nights;
        $resortFee = (int) round($stayTotal * 0.05);
        $taxes = (int) round($stayTotal * 0.09);

        return view('reservation-cart', compact('room', 'reservation', 'checkIn', 'checkOut', 'nights', 'stayTotal', 'resortFee', 'taxes'));
    }

    public function guestPayment(Request $request)
    {
        if (! $request->session()->has('reservation')) {
            return redirect()->route('rooms');
        }

        $selectedPaymentMethod = old('payment_method', $request->session()->get('guest_reservation.payment_method', 'card'));

        return view('guest-payment', array_merge($this->reservationSummary($request), [
            'paymentOptions' => $this->paymentOptions(),
            'selectedPaymentMethod' => $selectedPaymentMethod,
        ]));
    }

    public function completeReservation(Request $request)
    {
        $summary = $this->reservationSummary($request);

        $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'in:card,gcash,bank_transfer'],
        ]);

        $request->session()->put('guest_reservation', [
            'full_name' => $request->string('full_name')->toString(),
            'email' => $request->string('email')->toString(),
            'payment_method' => $request->string('payment_method')->toString(),
            'reference' => 'PR-'.now()->format('Y').'-'.random_int(10000, 99999),
        ]);

        Reservation::create([
            'user_id' => $request->user()?->id,
            'reference' => $request->session()->get('guest_reservation.reference'),
            'guest_name' => $request->string('full_name')->toString(),
            'guest_email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString(),
            'country' => $request->string('country')->toString(),
            'room_slug' => $summary['reservation']['room'],
            'room_name' => $summary['room']['name'],
            'check_in' => $summary['checkIn']->toDateString(),
            'check_out' => $summary['checkOut']->toDateString(),
            'guests' => $summary['reservation']['guests'],
            'nights' => $summary['nights'],
            'stay_total' => $summary['stayTotal'],
            'resort_fee' => $summary['resortFee'],
            'taxes' => $summary['taxes'],
            'grand_total' => $summary['stayTotal'] + $summary['resortFee'] + $summary['taxes'],
            'payment_method' => $request->string('payment_method')->toString(),
            'status' => 'processing',
        ]);

        return redirect()->route('reservation.confirmation');
    }

    public function bookingConfirmation(Request $request)
    {
        $guest = $request->session()->get('guest_reservation');

        if (! $guest || ! $request->session()->has('reservation')) {
            return redirect()->route('rooms');
        }

        return view('booking-confirmation', array_merge($this->reservationSummary($request), compact('guest'), [
            'paymentMethod' => $this->paymentOptions()[$guest['payment_method']],
        ]));
    }

    public function contact()
    {
        return view('contact');
    }

    public function experiences()
    {
        return view('experiences');
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function infoPage(string $page)
    {
        $pages = [
            'privacy' => [
                'eyebrow' => 'Your privacy matters',
                'title' => 'Privacy Policy',
                'summary' => 'We collect only the details needed to coordinate your stay and respond to your requests.',
                'sections' => [
                    ['title' => 'Information we use', 'body' => 'When you create an account, request a reservation, or contact our concierge, we use your name, contact details, stay preferences, and booking information to provide the service you requested.'],
                    ['title' => 'How we protect it', 'body' => 'Your account data is handled through the resort application and is used for guest support, reservation coordination, and service updates. We do not sell guest information.'],
                    ['title' => 'Your choices', 'body' => 'You may contact our concierge to ask about your profile information or request help with updating your details.'],
                ],
            ],
            'terms' => [
                'eyebrow' => 'A thoughtful stay begins with clarity',
                'title' => 'Terms of Service',
                'summary' => 'These simple terms keep the Praisty guest experience clear, respectful, and dependable.',
                'sections' => [
                    ['title' => 'Reservations', 'body' => 'A reservation request is subject to availability. Our concierge team will confirm the stay and provide the next payment or arrival instructions.'],
                    ['title' => 'Guest details', 'body' => 'Please provide accurate contact and arrival information so our team can coordinate your villa, transfers, and requested services.'],
                    ['title' => 'Responsible use', 'body' => 'Use the website and guest portal only for lawful resort, reservation, and concierge purposes.'],
                ],
            ],
            'careers' => [
                'eyebrow' => 'Work with the Praisty team',
                'title' => 'Careers',
                'summary' => 'Bring warmth, precision, and a love of island hospitality to a team that cares deeply about the details.',
                'sections' => [
                    ['title' => 'Open opportunities', 'body' => 'We welcome applications for guest relations, villa hosting, wellness, culinary, marine operations, and resort support roles.'],
                    ['title' => 'How to apply', 'body' => 'Send your resume and a short introduction through our contact page. Our team will reach out when your experience matches an upcoming role.'],
                    ['title' => 'Life at Praisty', 'body' => 'Our best work is calm, curious, and collaborative, with a shared commitment to thoughtful service.'],
                ],
            ],
            'press-room' => [
                'eyebrow' => 'Praisty Resort & Spa',
                'title' => 'Press Room',
                'summary' => 'A concise home for resort notes, story requests, and media inquiries.',
                'sections' => [
                    ['title' => 'Media inquiries', 'body' => 'For interviews, image requests, editorial visits, or partnership stories, please contact our concierge team with your publication and deadline.'],
                    ['title' => 'The story', 'body' => 'Praisty is a modern island sanctuary in El Nido, Palawan, shaped around raw coastal beauty, quiet rituals, and deeply personal hospitality.'],
                    ['title' => 'Request a media kit', 'body' => 'Use the contact page and select Events or Other so we can route your request to the right team.'],
                ],
            ],
            'sustainability' => [
                'eyebrow' => 'Care for the island',
                'title' => 'Sustainability',
                'summary' => 'Luxury at Praisty is designed to feel lighter on the places and waters that make the stay possible.',
                'sections' => [
                    ['title' => 'Respecting the coast', 'body' => 'Our guest experiences are shaped around the marine environment, with mindful excursions and quiet access to the island’s natural rhythms.'],
                    ['title' => 'Thoughtful operations', 'body' => 'We favor durable materials, responsible sourcing, and practical choices that reduce unnecessary waste across the resort.'],
                    ['title' => 'A shared responsibility', 'body' => 'Guests can help by following reef-safe practices, respecting wildlife, and leaving each shoreline as beautiful as they found it.'],
                ],
            ],
        ];

        abort_unless(isset($pages[$page]), 404);

        return view('info', ['page' => $pages[$page]]);
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'in:booking,transportation,events,other'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($request->only([
            'name',
            'email',
            'subject',
            'message',
        ]));

        return back()->with('contact_status', 'Your inquiry has been received. Our concierge team will contact you soon.');
    }

    public function submitFeedback(Request $request)
    {
        $account = $request->session()->get('guest_profile', []);
        $reservation = $request->session()->get('guest_reservation', []);

        $details = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:1200'],
        ]);

        $entry = [
            'name' => $reservation['full_name'] ?? $account['name'] ?? $request->user()?->name ?? 'Praisty Guest',
            'email' => $reservation['email'] ?? $account['email'] ?? $request->user()?->email ?? '',
            'rating' => (int) $details['rating'],
            'message' => $details['message'],
            'reference' => $reservation['reference'] ?? 'Guest dashboard',
            'created_at' => now()->toDateTimeString(),
        ];

        $reservationRecord = Reservation::query()
            ->where('reference', $entry['reference'])
            ->first();

        CustomerFeedback::create([
            'user_id' => $request->user()?->id,
            'reservation_id' => $reservationRecord?->id,
            'reference' => $entry['reference'],
            'name' => $entry['name'],
            'email' => $entry['email'],
            'rating' => $entry['rating'],
            'message' => $entry['message'],
        ]);

        return back()->with('feedback_status', 'Thank you. Your feedback has been sent to the Praisty admin team.');
    }

    private function accommodations(): array
    {
        return [
            ['name' => 'Royal Overwater Bungalow', 'type' => 'Overwater Bungalow', 'category' => 'pavilion', 'image' => 'images/resort/royal-overwater-bungalow.png', 'alt' => 'Royal Overwater Bungalow over clear turquoise lagoon waters', 'size' => '1,100 sq ft', 'sizeValue' => 1100, 'capacity' => 3, 'bed' => '1 King Bed', 'featureIcon' => 'waves', 'feature' => 'Direct Lagoon Access', 'price' => '₱95,000', 'priceValue' => 95000],
            ['name' => 'Sunset Beachfront Villa', 'type' => 'Beachfront Villa', 'category' => 'villa', 'image' => 'images/resort/sunset-beachfront-villa.png', 'alt' => 'Sunset Beachfront Villa with private terrace and infinity pool', 'size' => '1,320 sq ft', 'sizeValue' => 1320, 'capacity' => 4, 'bed' => '2 King Beds', 'featureIcon' => 'star', 'feature' => 'Sunset Beach Access', 'price' => '₱88,000', 'priceValue' => 88000],
            ['name' => 'Canopy Jungle Villa', 'type' => 'Private Villa', 'category' => 'villa', 'image' => 'images/resort/canopy-jungle-villa.png', 'alt' => 'Canopy Jungle Villa with private pool', 'size' => '1,200 sq ft', 'sizeValue' => 1200, 'capacity' => 4, 'bed' => '2 King Beds', 'featureIcon' => 'pool', 'feature' => 'Private Plunge Pool', 'price' => '₱82,000', 'priceValue' => 82000],
            ['name' => 'Ocean Serenity Wellness Villa', 'type' => 'Wellness Villa', 'category' => 'villa', 'image' => 'images/resort/ocean-serenity-wellness-villa.png', 'alt' => 'Ocean Serenity Wellness Villa with cliffside infinity pool and sea view', 'size' => '980 sq ft', 'sizeValue' => 980, 'capacity' => 3, 'bed' => '1 King Bed + Lounge', 'featureIcon' => 'spa', 'feature' => 'Wellness Terrace', 'price' => '₱72,000', 'priceValue' => 72000],
            ['name' => 'Azure Ocean Suite', 'type' => 'Premium Suite', 'category' => 'suite', 'image' => 'images/resort/azure-ocean-suite.png', 'alt' => 'Azure Ocean Suite interior with panoramic balcony', 'size' => '650 sq ft', 'sizeValue' => 650, 'capacity' => 3, 'bed' => '1 King Bed', 'featureIcon' => 'sunny', 'feature' => 'Panoramic Ocean View', 'price' => '₱48,000', 'priceValue' => 48000],
            ['name' => 'Lagoon View Casita', 'type' => 'Lagoon Casita', 'category' => 'pavilion', 'image' => 'images/resort/lagoon-view-casita.png', 'alt' => 'Lagoon View Casita living area facing a bright turquoise shoreline', 'size' => '610 sq ft', 'sizeValue' => 610, 'capacity' => 3, 'bed' => '1 King Bed + Daybed', 'featureIcon' => 'waves', 'feature' => 'Lagoon View Deck', 'price' => '₱34,000', 'priceValue' => 34000],
            ['name' => 'Deluxe Garden Villa', 'type' => 'Garden Villa', 'category' => 'villa', 'image' => 'images/resort/deluxe-garden-villa.png', 'alt' => 'Deluxe Garden Villa bedroom with private veranda and lush gardens', 'size' => '540 sq ft', 'sizeValue' => 540, 'capacity' => 2, 'bed' => '1 King Bed', 'featureIcon' => 'eco', 'feature' => 'Private Garden Veranda', 'price' => '₱28,000', 'priceValue' => 28000],
            ['name' => 'Palm Studio Suite', 'type' => 'Studio Suite', 'category' => 'suite', 'image' => 'images/resort/palm-studio-suite.png', 'alt' => 'Palm Studio Suite airy interior overlooking a tropical coconut grove', 'size' => '420 sq ft', 'sizeValue' => 420, 'capacity' => 2, 'bed' => '1 Queen Bed', 'featureIcon' => 'eco', 'feature' => 'Palm Grove View', 'price' => '₱22,000', 'priceValue' => 22000],
            ['name' => 'Winter Sun Pool Villa', 'type' => 'Seasonal Villa', 'category' => 'villa', 'image' => 'images/resort/winter-sun-escape.png', 'alt' => 'Sunlit infinity pool villa overlooking the ocean', 'size' => '920 sq ft', 'sizeValue' => 920, 'capacity' => 2, 'bed' => '1 King Bed', 'featureIcon' => 'sunny', 'feature' => 'Ocean-View Pool Deck', 'price' => '₱58,000', 'priceValue' => 58000],
            ['name' => 'Seaside Romance Suite', 'type' => 'Romance Suite', 'category' => 'suite', 'image' => 'images/resort/seaside-romance-retreat.png', 'alt' => 'Oceanfront villa suite at sunset with private pool', 'size' => '780 sq ft', 'sizeValue' => 780, 'capacity' => 2, 'bed' => '1 King Bed', 'featureIcon' => 'favorite', 'feature' => 'Private Sunset Terrace', 'price' => '₱64,000', 'priceValue' => 64000],
            ['name' => 'Reef Overwater Spa Villa', 'type' => 'Spa Villa', 'category' => 'villa', 'image' => 'images/resort/reef-overwater-spa-villa.png', 'alt' => 'Overwater spa villa with private deck above clear reef waters', 'size' => '1,180 sq ft', 'sizeValue' => 1180, 'capacity' => 3, 'bed' => '1 King Bed + Lounge', 'featureIcon' => 'hot_tub', 'feature' => 'Outdoor Soaking Bath', 'price' => '₱90,000', 'priceValue' => 90000],
            ['name' => 'Golden Tide Beach Villa', 'type' => 'Beach Villa', 'category' => 'villa', 'image' => 'images/resort/golden-tide-beach-villa.png', 'alt' => 'Beach villa terrace with sunset dining by the ocean', 'size' => '1,050 sq ft', 'sizeValue' => 1050, 'capacity' => 4, 'bed' => '2 King Beds', 'featureIcon' => 'wb_twilight', 'feature' => 'Sunset Dining Terrace', 'price' => '₱86,000', 'priceValue' => 86000],
            ['name' => 'Coral Horizon Overwater Villa', 'type' => 'Overwater Villa', 'category' => 'pavilion', 'image' => 'images/resort/overwater-wellness-ritual.png', 'alt' => 'Private overwater villa with reef access and ocean horizon view', 'size' => '1,180 sq ft', 'sizeValue' => 1180, 'capacity' => 3, 'bed' => '1 King Bed + Lounge', 'featureIcon' => 'snorkeling', 'feature' => 'Direct Reef Access', 'price' => '₱92,000', 'priceValue' => 92000],
        ];
    }

    private function findAccommodation(string $slug): array
    {
        $room = collect($this->accommodations())
            ->first(fn (array $accommodation) => Str::slug($accommodation['name']) === $slug);

        abort_unless($room, 404);

        return $room;
    }

    private function reservationSummary(Request $request): array
    {
        $reservation = $request->session()->get('reservation');

        abort_unless($reservation, 404);

        $room = $this->findAccommodation($reservation['room']);
        $checkIn = \Carbon\Carbon::parse($reservation['check_in']);
        $checkOut = \Carbon\Carbon::parse($reservation['check_out']);
        $nights = $checkIn->diffInDays($checkOut);
        $stayTotal = $room['priceValue'] * $nights;
        $resortFee = (int) round($stayTotal * 0.05);
        $taxes = (int) round($stayTotal * 0.09);

        return compact('room', 'reservation', 'checkIn', 'checkOut', 'nights', 'stayTotal', 'resortFee', 'taxes');
    }

    private function paymentOptions(): array
    {
        return [
            'card' => [
                'label' => 'Credit or debit card',
                'icon' => 'credit_card',
                'summary' => 'Secure payment link',
                'nextStep' => 'A secure card payment link will be sent to your email after availability is confirmed.',
            ],
            'gcash' => [
                'label' => 'GCash',
                'icon' => 'account_balance_wallet',
                'summary' => 'Pay after confirmation',
                'nextStep' => 'Your concierge will share the official GCash payment details after availability is confirmed.',
            ],
            'bank_transfer' => [
                'label' => 'Bank transfer',
                'icon' => 'account_balance',
                'summary' => 'Bank details by concierge',
                'nextStep' => 'Your concierge will send the official bank transfer instructions after availability is confirmed.',
            ],
        ];
    }
}
