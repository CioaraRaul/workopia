# 13 - Edit & Update Job Listing

## Key Learnings

### Route Model Binding for Edit/Update
- Changed `edit(string $id)` to `edit(Job $job)` — Laravel auto-resolves the model from the route parameter
- Same for `update(Request $request, Job $job)` — no manual `Job::findOrFail($id)` needed
- The `{job}` route parameter name must match the controller method's variable name

### Building the Edit Form
- Uses `@method('PUT')` directive inside the form since HTML forms only support GET/POST
- Pre-fills form fields by passing `:value="$job->field_name"` to Blade input components
- The `tags` field maps to the `strings` DB column, so we pass `:value="$job->strings"`
- Job type select uses `ucfirst($job->job_type)` to match the capitalized option values

### Update Controller Logic
- Validation rules mirror the `store` method — same fields, same constraints
- Tags-to-strings mapping: `$validateData['strings'] = $validateData['tags']` then `unset($validateData['tags'])`
- Logo upload is optional on update — only process if a new file is provided, otherwise `unset` to keep existing
- `$job->update($validateData)` mass-updates only the validated fields

### Auth for User ID
- Replaced hardcoded `$validateData['user_id'] = 1` with `auth()->id()` in the store method
- This ties new job listings to the currently authenticated user

### Cleanup
- Removed unused `use Illuminate\Support\Facades\Redirect` import
