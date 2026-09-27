<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestAuthController extends Controller
{
    public function create()
    {
        return view('guest-login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($this->usesFileAccounts()) {
            $account = collect($this->fileAccounts())
                ->first(fn (array $guest) => strtolower($guest['email']) === strtolower($credentials['email']));

            if (! $account || ! Hash::check($credentials['password'], $account['password'])) {
                return back()->withErrors([
                    'email' => 'The email address or password is incorrect.',
                ])->onlyInput('email');
            }

            $request->session()->put('guest_profile', [
                'name' => $account['name'],
                'email' => $account['email'],
                'is_admin' => false,
            ]);
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            return redirect()->route('home')->with('account_status', 'Welcome back to Praisty Resort.');
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The email address or password is incorrect.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        return redirect()->route('home')->with('account_status', 'Welcome back to Praisty Resort.');
    }

    public function register()
    {
        return view('create-account');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $details = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($this->usesFileAccounts()) {
            $accounts = collect($this->fileAccounts());
            $updated = false;

            $accounts = $accounts->map(function (array $account) use ($details, &$updated) {
                if (strtolower($account['email']) !== strtolower($details['email'])) {
                    return $account;
                }

                $account['password'] = Hash::make($details['password']);
                $updated = true;

                return $account;
            })->values()->all();

            if (! $updated) {
                return back()->withErrors([
                    'email' => 'No guest account was found for this email address.',
                ])->onlyInput('email');
            }

            $this->saveFileAccounts($accounts);

            return redirect()->route('guest.login')->with('account_status', 'Your password has been updated. Please sign in with your new password.');
        }

        $guest = User::query()
            ->where('email', $details['email'])
            ->where('is_admin', false)
            ->first();

        if (! $guest) {
            return back()->withErrors([
                'email' => 'No guest account was found for this email address.',
            ])->onlyInput('email');
        }

        $guest->forceFill([
            'password' => Hash::make($details['password']),
        ])->save();

        return redirect()->route('guest.login')->with('account_status', 'Your password has been updated. Please sign in with your new password.');
    }

    public function registerStore(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:'.now()->subYears(18)->toDateString()],
            'password' => ['required', 'confirmed', 'min:8'],
        ];

        if (! $this->usesFileAccounts()) {
            $rules['email'][] = 'unique:users,email';
        }

        $details = $request->validate($rules, [
            'date_of_birth.before_or_equal' => 'You must be at least 18 years old to create a guest account.',
        ]);

        if ($this->usesFileAccounts()) {
            $accounts = $this->fileAccounts();
            $emailExists = collect($accounts)
                ->contains(fn (array $guest) => strtolower($guest['email']) === strtolower($details['email']));

            if ($emailExists) {
                return back()->withErrors([
                    'email' => 'An account already exists for this email address.',
                ])->withInput();
            }

            $accounts[] = [
                'name' => $details['name'],
                'email' => strtolower($details['email']),
                'date_of_birth' => $details['date_of_birth'],
                'password' => Hash::make($details['password']),
            ];
            $this->saveFileAccounts($accounts);
        } else {
            User::create([
                'name' => $details['name'],
                'email' => $details['email'],
                'date_of_birth' => $details['date_of_birth'],
                'password' => Hash::make($details['password']),
            ]);
        }

        return redirect()->route('guest.login')->with('account_status', 'Your Praisty guest account is ready. Please sign in to continue.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->forget('guest_profile');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guest.login')->with('account_status', 'You have been signed out.');
    }

    private function usesFileAccounts(): bool
    {
        return config('guest-accounts.storage') === 'file';
    }

    private function fileAccounts(): array
    {
        $path = storage_path('app/guest-accounts.json');

        if (! is_file($path)) {
            return [];
        }

        return json_decode((string) file_get_contents($path), true) ?: [];
    }

    private function saveFileAccounts(array $accounts): void
    {
        file_put_contents(
            storage_path('app/guest-accounts.json'),
            json_encode($accounts, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            LOCK_EX,
        );
    }
}
