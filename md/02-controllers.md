# Controllers in Laravel

## What We Learned

### Creating a Controller
Controllers live in `app/Http/Controllers/` and extend the base `Controller` class.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('pages.index');
    }
}
```
- Each public method is an **action** that handles a specific route.
- `return view('pages.index')` renders the `resources/views/pages/index.blade.php` template.

### Connecting Routes to Controllers
Instead of closures in routes, point to a controller method using the array syntax:

```php
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
```
- First element: the controller class.
- Second element: the method name (string).

### Resource Controllers
A resource controller provides all 7 CRUD actions out of the box:

```php
use App\Http\Controllers\JobController;

Route::resource('jobs', JobController::class);
```

This single line registers **all** of these routes:

| Verb      | URI               | Action  | Purpose              |
|-----------|-------------------|---------|----------------------|
| GET       | /jobs             | index   | List all             |
| GET       | /jobs/create      | create  | Show create form     |
| POST      | /jobs             | store   | Save new record      |
| GET       | /jobs/{job}       | show    | Show one             |
| GET       | /jobs/{job}/edit  | edit    | Show edit form       |
| PUT/PATCH | /jobs/{job}       | update  | Update record        |
| DELETE    | /jobs/{job}       | destroy | Delete record        |

### Resource Controller Example
```php
class JobController extends Controller
{
    public function index(): View
    {
        $jobs = ['Web', 'Database admin', 'Software engineer'];
        return view('jobs.index', compact('jobs'));
    }

    public function create(): View
    {
        return view('jobs.create');
    }

    public function store(Request $request): string
    {
        return 'store';
    }

    public function show(string $id): string
    {
        return 'show';
    }

    // edit, update, destroy follow the same pattern...
}
```

### Passing Data to Views
```php
$jobs = ['Web', 'Database admin'];
return view('jobs.index', compact('jobs'));
```
- `compact('jobs')` creates `['jobs' => $jobs]` — a shortcut for passing variables to the view.
- The variable `$jobs` becomes available inside the Blade template.
- You can also pass data manually: `view('jobs.index', ['jobs' => $jobs])`.

### Return Type Hints
```php
use Illuminate\View\View;

public function index(): View
```
- Use `Illuminate\View\View` as the return type when returning a view.
- Use `string` when returning plain text.
