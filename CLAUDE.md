# SimpleTime OS - Development Guidelines

This application uses modular documentation in `.ai/agent_docs/`. Each file focuses on a specific area of development.

## Documentation Structure

- **[.ai/agent_docs/foundation.md](.ai/agent_docs/foundation.md)** - Core rules, conventions, and reply style
- **[.ai/agent_docs/php.md](.ai/agent_docs/php.md)** - PHP 8.4 conventions and type declarations
- **[.ai/agent_docs/laravel-core.md](.ai/agent_docs/laravel-core.md)** - Laravel 12 patterns and best practices
- **[.ai/agent_docs/hotwire.md](.ai/agent_docs/hotwire.md)** - Turbo/Stimulus frontend conventions
- **[.ai/agent_docs/testing.md](.ai/agent_docs/testing.md)** - PHPUnit testing guidelines
- **[.ai/agent_docs/laravel-boost.md](.ai/agent_docs/laravel-boost.md)** - MCP server tools and documentation search
- **[.ai/agent_docs/formatting.md](.ai/agent_docs/formatting.md)** - Code formatting rules

## Quick Context

**SimpleTime OS** is a self-hosted, single-user time tracking application for freelancers and consultants.

### Tech Stack
- **Backend:** PHP 8.4 + Laravel 12
- **Frontend:** Hotwire (Turbo + Stimulus)
- **Templates:** Server-rendered Blade
- **Testing:** PHPUnit 12
- **Database:** SQLite (default)
- **Styling:** Tailwind CSS + DaisyUI

### Key Features
- One-click timer with keyboard shortcuts
- Client and project management
- Multi-currency support (56 currencies)
- Reports with CSV export
- User preferences for date/time formatting

### Architecture
- Server-rendered HTML over HTTP (no JSON APIs)
- Stimulus controllers for interactivity
- Service layer for business logic
- Action classes for discrete operations
- Value Objects (Money) for domain concepts
