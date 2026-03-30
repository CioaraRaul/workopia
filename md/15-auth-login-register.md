# 15 - Authentication: Login & Register

## Key Learnings

### Register Controller

- Created a dedicated `RegisterController` with `register()` (show form) and `store()` (handle submission) methods
- Used `Hash::make()` to hash the password before storing it in the database
- Used `User::create()` with mass assignment to create a new user
- Validation rules:
  - `confirmed` rule automatically checks that `password` matches `password_confirmation`
  - `unique:users` ensures no duplicate email addresses
  - `min:8` enforces minimum password length

```php
$validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|confirmed|min:8',
]);

$validatedData['password'] = Hash::make($validatedData['password']);
$user = User::create($validatedData);
```

### Login Controller

- Created a dedicated `LoginController` with `login()` (show form) and `authenticate()` (handle submission) methods
- Used `Auth::attempt($credentials)` to authenticate the user against the database
- `$request->session()->regenerate()` prevents session fixation attacks after login
- `redirect()->intended()` redirects the user to the page they originally wanted to visit (or a default route)
- On failure, `withErrors()` flashes validation errors and `onlyInput('email')` repopulates only the email field (not the password)

```php
if (Auth::attempt($credentials)) {
    $request->session()->regenerate();
    return redirect()->intended(route('home'))->with('success', 'Login successful.');
}

return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
```

### Auth Routes

- Registered routes manually (not using `Auth::routes()`) for full control:

```php
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
```

### Auth Views

- Both login and register views use the same card layout (`bg-white rounded-lg shadow-md`)
- Reused existing `<x-inputs.text>` and `<x-button>` components
- The `<x-button>` component uses a `label` prop (not slot content) to set button text
- Each form links to the other (login links to register and vice versa)
