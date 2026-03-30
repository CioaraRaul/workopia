# Policies & @can Directive

## What are Policies?
Policies are classes that organize authorization logic around a particular model. They contain methods that determine if a user can perform a given action on a model.

## Creating a Policy
```bash
php artisan make:policy JobPolicy --model=Job
```
This generates `app/Policies/JobPolicy.php` with CRUD authorization methods.

## Registering a Policy
Create or update `AuthServiceProvider` to map models to policies:
```php
use App\Models\Job;
use App\Policies\JobPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Job::class => JobPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
```
Don't forget to register the provider in `bootstrap/providers.php`.

## Policy Methods
Each method receives the authenticated `User` and the model instance, returning a boolean:
```php
public function update(User $user, Job $job): bool
{
    return $user->id === $job->user_id;
}

public function delete(User $user, Job $job): bool
{
    return $user->id === $job->user_id;
}
```
This ensures only the job owner can update or delete their job.

## Authorizing in Controllers
Use `$this->authorize()` from the `AuthorizesRequests` trait in the base controller:
```php
// In Controller.php
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;
}

// In JobController.php
public function edit(Job $job): View
{
    $this->authorize('update', $job);
    return view('jobs.edit')->with('job', $job);
}

public function destroy(Job $job): RedirectResponse
{
    $this->authorize('delete', $job);
    $job->delete();
    return redirect()->route('jobs.index');
}
```
If authorization fails, Laravel throws a 403 Forbidden response automatically.

## @can Blade Directive
Use `@can` in views to conditionally show UI elements based on policy:
```blade
@can('update', $job)
    <a href="{{ route('jobs.edit', $job->id) }}">Edit</a>
@endcan
```
This replaces manual checks like `@if(auth()->id() === $job->user_id)` — cleaner and uses the same policy logic as the controller.

## Key Takeaways
- **Policies** centralize authorization logic per model
- **`$this->authorize()`** in controllers throws 403 if the check fails
- **`@can` directive** in Blade hides UI elements the user isn't authorized to interact with
- **`AuthorizesRequests` trait** must be on the base Controller in Laravel 11+
- **`authorizeResource()`** does NOT work in Laravel 11+ (no `middleware()` method on controllers)
