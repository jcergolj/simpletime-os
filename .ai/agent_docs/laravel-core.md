# Laravel Core Patterns
> Laravel 12 conventions, Eloquent, validation, configuration actively used in SimpleTime OS

## Do Things the Laravel Way

### Artisan Make Commands
- Use `php artisan make:` commands to create new files
- Use the `list-artisan-commands` tool to see available commands
- Pass `--no-interaction` to all Artisan commands
- Pass correct `--options` for desired behavior

```bash
# Create a controller
php artisan make:controller TimeEntryController --no-interaction

# Create a generic PHP class
php artisan make:class Actions/SyncHourlyRateAction --no-interaction
```

## Database and Eloquent

### Relationships
- Always use proper Eloquent relationship methods with return type hints
- Prefer relationship methods over raw queries or manual joins

```php
public function timeEntries(): HasMany
{
    return $this->hasMany(TimeEntry::class);
}

public function client(): BelongsTo
{
    return $this->belongsTo(Client::class);
}
```

### Query Best Practices
- Prefer `Model::query()` over `DB::`
- Generate code that leverages Laravel's ORM capabilities
- **Prevent N+1 query problems** by using eager loading

```php
// Good: Eager loading
$projects = Project::with('client', 'timeEntries')->get();

// Bad: N+1 queries
$projects = Project::all();
foreach ($projects as $project) {
    echo $project->client->name; // Lazy loads client each time
}
```

### Query Scopes
- Use query scopes for common filters
- This project uses scopes like: `completed()`, `forClient()`, `forProject()`, `betweenDates()`, `latestFirst()`

```php
// In TimeEntry model
public function scopeCompleted($query): void
{
    $query->whereNotNull('end_at');
}

// Usage
$entries = TimeEntry::completed()->latestFirst()->get();
```

## Model Creation

### Factories and Seeders
- When creating new models, create useful factories and seeders too
- Use the `list-artisan-commands` tool to check options for `php artisan make:model`

```bash
# Create model with migration, factory, and seeder
php artisan make:model Project --migration --factory --seed --no-interaction
```

### Model Casts
- Use the `casts()` method on models (Laravel 12 convention)
- Do not use the `$casts` property

```php
// Correct (Laravel 12)
protected function casts(): array
{
    return [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}

// Incorrect (old style)
protected $casts = [
    'start_at' => 'datetime',
];
```

## Controllers and Validation

### Form Request Classes
- Always create Form Request classes for validation
- Do not use inline validation in controllers
- Include both validation rules and custom error messages
- Check sibling Form Requests to see if the application uses array or string-based validation rules

```php
// Create Form Request
php artisan make:request StoreTimeEntryRequest --no-interaction

// In the Form Request
public function rules(): array
{
    return [
        'project_id' => ['required', 'exists:projects,id'],
        'start_at' => ['required', 'date'],
    ];
}
```

## Routing and URLs

### Named Routes
- When generating links, prefer named routes and the `route()` function
- Do not hardcode URLs

```php
// Good
<a href="{{ route('projects.show', $project) }}">View Project</a>

// Bad
<a href="/projects/{{ $project->id }}">View Project</a>
```

## Configuration

### Environment Variables
- Use environment variables **only in configuration files**
- Never use `env()` function directly outside of config files
- Always use `config('app.name')`, not `env('APP_NAME')`

```php
// config/app.php
'name' => env('APP_NAME', 'Laravel'),

// Anywhere in the app
$appName = config('app.name'); // Correct
$appName = env('APP_NAME');    // Incorrect
```

## Laravel 12 Structure

### Streamlined Architecture
- No `app/Console/Kernel.php` - use `bootstrap/app.php` or `routes/console.php`
- Commands auto-register from `app/Console/Commands/`
- No middleware files in `app/Http/Middleware/` by default
- `bootstrap/app.php` registers middleware, exceptions, and routing files
- `bootstrap/providers.php` contains application-specific service providers

### Console Commands
- Files in `app/Console/Commands/` are automatically available
- No manual registration required

## Database Migrations

### Modifying Columns
- When modifying a column, the migration must include all attributes previously defined
- Otherwise, they will be dropped and lost

```php
// Correct: Includes all previous attributes
Schema::table('time_entries', function (Blueprint $table) {
    $table->decimal('duration', 8, 2)->nullable()->change();
});
```

### Eager Loading Limits
- Laravel 12 allows limiting eagerly loaded records natively

```php
$projects = Project::with(['timeEntries' => function ($query) {
    $query->latest()->limit(10);
}])->get();
```

## Frontend Build Errors

### Vite Manifest Error
- If you see "Unable to locate file in Vite manifest" error:
  - Run `npm run build`, or
  - Ask user to run `npm run dev` or `composer run dev`
