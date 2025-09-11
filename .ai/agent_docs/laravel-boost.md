# Laravel Boost MCP Server
> Tools and documentation search for Laravel applications

## Overview
Laravel Boost is an MCP server with powerful tools designed specifically for this application. Use them frequently.

## Artisan Commands
- Use the `list-artisan-commands` tool when calling Artisan commands
- Double-check available parameters before running commands

## Absolute URLs
- Use the `get-absolute-url` tool when sharing project URLs with the user
- Ensures correct scheme, domain/IP, and port

```bash
# Get absolute URL for a path
get-absolute-url --path="/dashboard"

# Get absolute URL for a named route
get-absolute-url --route="home"
```

## Tinker and Debugging
- Use the `tinker` tool to execute PHP for debugging or querying Eloquent models
- Use the `database-query` tool when you only need to read from the database

## Browser Logs
- Read browser logs, errors, and exceptions using the `browser-logs` tool
- Only recent browser logs are useful - ignore old logs

## Documentation Search (Critical)
- **ALWAYS use the `search-docs` tool before other approaches**
- This tool returns version-specific documentation for packages installed in this application
- Perfect for Laravel ecosystem packages: Laravel, Tailwind, Hotwire Turbo, etc.
- **Must search docs before making code changes** to ensure correct approach

### Search Syntax
Pass multiple queries at once for best results:

1. **Simple word searches** (auto-stemming)
   - `query="authentication"` finds "authenticate" and "auth"

2. **Multiple words** (AND logic)
   - `query="rate limit"` finds content with both "rate" AND "limit"

3. **Quoted phrases** (exact position)
   - `query="infinite scroll"` finds exact phrase with adjacent words

4. **Mixed queries**
   - `query="middleware 'rate limit'"` finds "middleware" AND exact phrase "rate limit"

5. **Multiple queries** (recommended)
   - `queries=["authentication", "middleware"]` finds ANY of these terms

### Search Best Practices
- Use multiple, broad, simple, topic-based queries to start
  - Example: `['rate limiting', 'routing rate limiting', 'routing']`
- **Do not add package names to queries** - package info is already shared
  - Use `"test resource table"`, not `"filament 4 test resource table"`
- Filter by packages if you know what you need:
  - `packages=["laravel/framework", "inertiajs/inertia-laravel"]`
