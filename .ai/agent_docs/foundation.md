# Foundation Rules
> Core conventions, directory structure, and reply style for SimpleTime OS

## Application Context
- **Project:** SimpleTime OS - Self-hosted single-user time tracking application
- **Stack:** PHP 8.4 + Laravel 12
- **Frontend:** Hotwire (Turbo + Stimulus)
- **Purpose:** Track billable hours for freelancers/consultants
- **Architecture:** Server-rendered Blade templates with minimal JavaScript

## Code Conventions
- Follow all existing code conventions used in this application
- When creating or editing a file, check sibling files for correct structure, approach, and naming
- Use descriptive names for variables and methods
  - Example: `isRegisteredForDiscounts()`, not `discount()`
- Check for existing components to reuse before writing new ones

## Directory Structure
- Stick to existing directory structure
- **Do not create new base folders without approval**
- Custom directories in use:
  - `/app/Actions/` - Action classes
  - `/app/Enums/` - Enum definitions
  - `/app/Services/` - Service layer
  - `/app/ValueObjects/` - Value object classes

## Application Dependencies
- Do not change application dependencies without approval
- Current stack is intentionally minimal and focused

## Documentation Files
- **Only create documentation files (*.md) if explicitly requested by the user**
- Do not proactively create README files or other documentation

## Reply Style
- Be concise in explanations
- Focus on what's important rather than explaining obvious details
- Output text directly (not via bash echo)
- Keep responses focused on the task at hand
