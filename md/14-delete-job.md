# 14 - Delete Job Listing

## Key Learnings

### Destroy Controller Method
- Changed `destroy(string $id)` to `destroy(Job $job)` — uses route model binding like edit/update
- Returns `RedirectResponse` instead of a string — redirects back to job index after deletion
- `$job->delete()` removes the record from the database

### File Cleanup on Delete
- Before deleting the job, check if a `company_logo` exists
- Use `storage_path('app/public/logos/' . $job->company_logo)` to build the full file path
- `file_exists()` + `unlink()` to safely remove the logo file from disk
- Important to clean up uploaded files to avoid orphaned files in storage

### Delete Form in Blade
- HTML forms only support GET/POST — use `@method('DELETE')` to spoof the DELETE method
- The form POSTs to `route('jobs.destroy', $job->id)` and Laravel reads the `_method` hidden field

### JavaScript Confirmation Dialog
- Added `onsubmit="return confirm('...')"` on the form element
- `confirm()` returns `true` (OK) or `false` (Cancel)
- Returning `false` from `onsubmit` prevents the form from submitting

### Authorization Considerations
- Authorization check (`$job->user_id !== auth()->id()`) should be added once auth is fully implemented
- Without auth, `auth()->id()` returns `null`, causing the check to always fail and silently redirect
