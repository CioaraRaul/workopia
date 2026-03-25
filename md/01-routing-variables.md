# Routing Variables in Laravel

## What We Learned

### Basic Route Definition
```php
Route::get('/jobs', function(){
    return 'Available jobs';
})->name('jobs');
```
- Define routes with `Route::get()`, `Route::post()`, etc.
- Chain `->name()` to give a route a named reference.

### Route Parameters (Variables)
```php
Route::get('/posts/{id}', function(string $id){
    return 'POST ' . $id;
});
```
- Wrap parameter names in `{curly braces}` in the URI.
- Laravel automatically injects the matched value into the closure parameter.
- Type-hint the parameter (e.g., `string $id`) for clarity.

### Request Object
```php
use Illuminate\Http\Request;

Route::get('/test', function(Request $request){
    return [
        'method' => $request->method(),
        'ip'     => $request->ip(),
        'header' => $request->header('Accept')
    ];
});
```
- Import `Illuminate\Http\Request` to access the full request.
- Useful methods: `method()`, `ip()`, `header()`, `url()`, `fullUrl()`.
- Returning an array automatically converts it to JSON.

### Query Parameters
```php
Route::get('/users', function(Request $request){
    return $request->query('name');
});
```
- Access query string values (`?name=John`) with `$request->query('key')`.
- Also available via `$request->input('key')` or `$request->get('key')`.
