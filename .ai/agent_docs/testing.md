# Testing Guidelines
> PHPUnit testing conventions and best practices for SimpleTime OS

## Test Framework
- This application uses **PHPUnit v12** for testing
- **All tests must be written as PHPUnit classes**
- Not using Pest - PHPUnit only

## Creating Tests

### Artisan Command
```bash
# Create feature test
php artisan make:test TimeEntryTest --phpunit --no-interaction

# Create unit test
php artisan make:test Services/ReportAggregationServiceTest --phpunit --unit --no-interaction
```

### Test Structure
- Feature tests in `/tests/Feature/`
- Unit tests in `/tests/Unit/`
- Use attributes for modern PHPUnit syntax

```php
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TimeEntry::class)]
class TimeEntryTest extends TestCase
{
    #[Test]
    public function it_calculates_duration_correctly(): void
    {
        // Test implementation
    }
}
```

## Running Tests

### Minimal Test Execution
- Run the minimal number of tests needed
- Use specific file or filter to speed up testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/TimeEntryTest.php

# Filter by test name
php artisan test --filter=testTimerSession

# Recommended after making changes
php artisan test --filter=calculateDuration
```

### Test Database
- Uses SQLite in-memory database
- Configured in `phpunit.xml`
- Fast and isolated test environment

## Test Coverage Requirements

### Comprehensive Testing
- Test all paths: happy paths, failure paths, and weird paths
- Every change must be programmatically tested
- Write a new test or update an existing test
- Run affected tests to ensure they pass

### Examples
```php
#[Test]
public function it_starts_timer_successfully(): void
{
    // Happy path
}

#[Test]
public function it_prevents_starting_timer_when_one_is_active(): void
{
    // Failure path
}

#[Test]
public function it_handles_missing_project_gracefully(): void
{
    // Weird path
}
```

## Using Factories

### Model Creation
- Use factories for creating test models
- Check if factory has custom states before manual setup

```php
// Good: Use factory
$user = User::factory()->create();
$project = Project::factory()->create(['user_id' => $user->id]);

// Check for custom states
$activeProject = Project::factory()->active()->create();
$completedEntry = TimeEntry::factory()->completed()->create();
```

### Factory States
This project uses factory states for different scenarios:

```php
// TimeEntry factory has states
TimeEntry::factory()->completed()->create();
TimeEntry::factory()->inProgress()->create();
```

## Faker Usage

### Data Generation
- Follow existing conventions: `$this->faker` or `fake()`
- Check sibling tests to maintain consistency

```php
// Pattern 1: Using $this->faker
$name = $this->faker->word();

// Pattern 2: Using fake() helper
$email = fake()->email();
```

## Test Organization

### Never Remove Tests
- Do not remove tests or test files without approval
- Tests are core to the application, not temporary
- If a test fails, fix the code or update the test

### After Feature Completion
- Run tests for the specific feature first
- Ask user if they want to run the entire test suite

```php
// After implementing timer feature
// 1. Run: php artisan test --filter=Timer
// 2. Ask: "Would you like me to run the entire test suite?"
```

## Test Quality

### N+1 Query Prevention
- Test for N+1 queries using `DB::getQueryLog()`
- Example from `TimeEntryLazyLoadingTest.php`

```php
#[Test]
public function it_prevents_n_plus_one_queries(): void
{
    DB::enableQueryLog();

    $entries = TimeEntry::with('project.client')->get();

    $queryCount = count(DB::getQueryLog());
    $this->assertLessThanOrEqual(3, $queryCount);
}
```

### Assertions
- Use specific assertions
- Include meaningful assertion messages

```php
// Good
$this->assertEquals(120, $entry->duration_in_minutes);
$this->assertDatabaseHas('time_entries', ['id' => $entry->id]);

// Better with messages
$this->assertEquals(
    120,
    $entry->duration_in_minutes,
    'Duration should be 120 minutes for 2-hour entry'
);
```
