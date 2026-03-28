# Job Store Validation & Routing Fixes

## Full Store Validation

The `store` method now validates all job listing fields, not just title and description:

```php
$validateData = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'salary' => 'required|integer|min:0',
    'tags' => 'nullable|string',
    'job_type' => 'required|string',
    'remote' => 'required|boolean',
    'requirements' => 'nullable|string',
    'benefits' => 'nullable|string',
    'company_name' => 'required|string|max:255',
    'company_description' => 'nullable|string',
    'company_website' => 'nullable|url',
    'contact_phone' => 'nullable|string|max:20',
    'contact_email' => 'required|email',
    'address' => 'nullable|string|max:255',
    'city' => 'required|string|max:255',
    'state' => 'required|string|max:255',
    'zipcode' => 'nullable|string|max:20',
    'company_logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
]);
```

## Field Mapping

The form uses `tags` but the database column is `strings`, so we map it:

```php
$validateData['strings'] = $validateData['tags'] ?? null;
unset($validateData['tags']);
```

## File Upload Handling

Company logos are stored in the `logos` disk under `public`:

```php
if ($request->hasFile('company_logo')) {
    $path = $request->file('company_logo')->store('logos', 'public');
    $validateData['company_logo'] = $path;
}
```

## Validation Error Display

Added error block at the top of the create form:

```blade
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

## Custom Routes Before Resource Routes

`Route::resource` generates `/jobs/{job}` which catches anything after `/jobs/`. Custom routes like `/jobs/saved` must be defined **before** the resource to avoid being matched as a job ID:

```php
// Must come BEFORE Route::resource
Route::get('jobs/saved', [JobController::class, 'saved'])->name('jobs.saved');

// This catches /jobs/{job} — any unmatched path becomes {job}
Route::resource('jobs', JobController::class);
```

Without this ordering, visiting `/jobs/saved` causes a database error because PostgreSQL tries to look up `WHERE id = 'saved'`.
