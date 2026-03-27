# Models, Database & Dynamic Blade Views

## Eloquent Models

Define a model with `php artisan make:model Job`:

```php
class Job extends Model
{
    protected $table = 'job_listings'; // Custom table name
    protected $fillable = ['title', 'description', 'salary', ...]; // Mass-assignable fields
}
```

- Use `$table` to override Laravel's default table naming convention
- `$fillable` protects against mass-assignment vulnerabilities

## Relationships

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

## Migrations

Create with `php artisan make:migration create_job_listings_table`:

```php
Schema::create('job_listings', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->unsignedBigInteger('user_id');
    $table->timestamps();
});
```

- Add columns later with a new migration using `$table->string('field')->after('column')`

## Factories & Seeders

Factories generate fake data for testing:

```php
// JobFactory.php
'title' => fake()->jobTitle(),
'salary' => fake()->numberBetween(40000, 120000),
'remote' => fake()->boolean(),
'city' => fake()->city(),
```

Seeders call factories:

```php
Job::factory()->count(10)->create();
```

Run with: `php artisan db:seed --class=RandomJobSeeder`

## Resource Controllers

`php artisan make:controller JobController --resource` generates CRUD methods:

| Method   | Route             | Purpose         |
|----------|-------------------|-----------------|
| index    | GET /jobs         | List all        |
| create   | GET /jobs/create  | Show form       |
| store    | POST /jobs        | Save new        |
| show     | GET /jobs/{job}   | Show single     |
| edit     | GET /jobs/{job}/edit | Show edit form |
| update   | PUT /jobs/{job}   | Update          |
| destroy  | DELETE /jobs/{job} | Delete          |

Register all routes at once: `Route::resource('jobs', JobController::class);`

## Route Model Binding

Laravel auto-fetches the model by ID:

```php
public function show(Job $job): View
{
    return view('jobs.show')->with('job', $job);
}
```

- The `$job` parameter name must match the route parameter `{job}`

## Dynamic Blade Views

Replace hardcoded HTML with model data:

```blade
<h2>{{ $job->title }}</h2>
<p>{{ $job->description }}</p>
<strong>Remote:</strong> {{ $job->remote ? 'Yes' : 'No' }}
```

- Use `{{ }}` for escaped output
- Ternary expressions work inside Blade echo tags
- Use `@if` to conditionally show optional fields:

```blade
@if($job->company_website)
    <a href="{{ $job->company_website }}">Visit Website</a>
@endif
```

## Named Routes in Blade

Use `route()` helper instead of hardcoded URLs:

```blade
<a href="{{ route('jobs.index') }}">Back To Listings</a>
<a href="{{ route('jobs.edit', $job->id) }}">Edit</a>
<form method="POST" action="{{ route('jobs.destroy', $job->id) }}">
    @csrf
    @method('DELETE')
</form>
```

- `@csrf` adds a hidden token field for CSRF protection
- `@method('DELETE')` spoofs the HTTP method (HTML forms only support GET/POST)
