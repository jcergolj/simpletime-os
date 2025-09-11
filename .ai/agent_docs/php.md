# PHP Conventions
> PHP 8.4 type declarations, constructor promotion, and coding standards

## Type Declarations
- **Always use explicit return type declarations** for methods and functions
- **Always use appropriate PHP type hints** for method parameters
- Include nullable types where applicable (`?string`, `?int`, etc.)

```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    // ...
}
```

## Constructor Property Promotion
- Use PHP 8 constructor property promotion in `__construct()`
- Do not allow empty `__construct()` methods with zero parameters

```php
public function __construct(
    public GitHub $github,
    protected UserRepository $users,
) {
}
```

## Control Structures
- Always use curly braces for control structures
- Even if the body contains only one line

```php
// Correct
if ($condition) {
    return true;
}

// Incorrect
if ($condition)
    return true;
```

## Comments and Documentation
- Prefer PHPDoc blocks over inline comments
- Never use comments within code unless something is very complex
- Add useful array shape type definitions when appropriate

```php
/**
 * @param array{name: string, email: string, age: int} $userData
 * @return array{id: int, created_at: string}
 */
public function createUser(array $userData): array
{
    // ...
}
```

## Enums
- Keys in an Enum should be TitleCase
- Examples: `FavoritePerson`, `BestLake`, `Monthly`

```php
enum Currency: string
{
    case UnitedStatesDollar = 'USD';
    case Euro = 'EUR';
    case BritishPound = 'GBP';
}
```
