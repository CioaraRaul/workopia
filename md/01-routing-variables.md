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

### Response Helpers
```php
// Custom response with status code and headers
Route::get('/test', function(){
    return response('Hello world', 200)->header('Content-Type', 'text/html');
});

// JSON response
Route::get('/test2', function(){
    return response()->json(['name' => 'Koln']);
});

// File download
Route::get('/download', function(){
    return response()->download(public_path('favicon.ico'));
});

// Custom status codes (e.g., 400 Not Found)
Route::get('/notFound', function(){
    return response('not found', 400);
});
```
- `response($content, $status)` — return a response with a custom status code.
- `->header('Key', 'Value')` — attach headers to the response.
- `->json($array)` — return a JSON response.
- `->download($path)` — trigger a file download.

### Cookies
```php
// Setting a cookie (name, value, minutes)
Route::get('/test2', function(){
    return response()->json(['name' => 'Koln'])->cookie('name', 'John', 60);
});

// Reading a cookie
Route::get('/read-cookie', function(Request $request){
    $cookieValue = $request->cookie('name');
    return response()->json(['cookie' => $cookieValue]);
});
```
- `->cookie($name, $value, $minutes)` — attach a cookie to the response. The `$minutes` parameter is required.
- `$request->cookie('name')` — read a cookie from the incoming request.
