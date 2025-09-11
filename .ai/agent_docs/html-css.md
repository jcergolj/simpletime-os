# HTML & CSS Frontend
> Styling, layout, and component markup conventions for SimpleTime OS

## Stack Overview
- **CSS Framework:** Tailwind CSS (using new @import syntax)
- **Component Library:** DaisyUI (light theme only)
- **Templates:** Blade components (server-rendered)
- **Typography:** Manrope font (display + body)
- **Icons:** Heroicons via Blade Components
- **Responsive:** Mobile-first approach

## Design System

### CSS Variables
All colors and theming use CSS custom properties defined in `resources/css/app.css`:

```css
:root {
    --color-bg: #FAFBFC;
    --color-surface: #FFFFFF;
    --color-text: #1A1F36;
    --color-text-secondary: #697386;
    --color-text-muted: #9AA5B1;
    --color-border: #E3E8EE;
    --color-primary: #0066FF;
    --color-primary-hover: #0052CC;
    --font-display: 'Manrope', sans-serif;
    --font-body: 'Manrope', sans-serif;
}
```

**Usage in templates:**
```html
<!-- Use CSS variable references -->
<div class="text-[var(--color-text)]">
<div class="border-[var(--border)]">
```

### Typography Classes
Custom typography utilities defined in app.css:

```html
<!-- Page-level headings -->
<h1 class="font-display page-heading">Dashboard</h1>
<p class="page-subheading">Weekly overview</p>

<!-- Section headings -->
<h2 class="section-heading">Recent Entries</h2>

<!-- Card headings -->
<h3 class="card-heading">Timer Widget</h3>

<!-- List headers -->
<h3 class="list-header-title">Clients</h3>
<p class="list-header-subtitle">25 clients total</p>
```

## Component Architecture

### Blade Component Organization
Components live in `resources/views/components/`:

```
components/
├── layouts/           # Layout wrappers
│   ├── app.blade.php
│   ├── auth.blade.php
│   └── app/
│       ├── header.blade.php
│       └── sidebar.blade.php
├── form/              # Form inputs and controls
│   ├── text-input.blade.php
│   ├── label.blade.php
│   ├── error.blade.php
│   ├── search-clients.blade.php
│   └── button/
│       ├── primary.blade.php
│       ├── save.blade.php
│       └── danger.blade.php
├── list/              # List components
│   ├── header.blade.php
│   ├── empty-state.blade.php
│   └── action-buttons.blade.php
├── navbar/            # Navigation components
├── sidebar/           # Sidebar navigation
└── text/              # Text components
    ├── heading.blade.php
    └── subheading.blade.php
```

### Component Naming Convention
- **File:** `kebab-case.blade.php`
- **Usage:** `<x-kebab-case />`
- **Namespaced:** `<x-form.text-input />`

### Component Props Pattern
Always define props using `@props` directive:

```blade
@props([
    'title',
    'current' => false,  # Default value
])

<div {{ $attributes->merge(['class' => 'base-class']) }}>
    {{ $slot }}
</div>
```

## Button System

### DaisyUI Button Classes
```html
<!-- Ghost button (navbar) -->
<a class="btn btn-ghost">Link</a>

<!-- Active state via data attribute -->
<a class="btn btn-ghost data-current:btn-active!" @if($current) data-current="data-current" @endif>
    Active Link
</a>
```

### Custom Button Classes (from app.css)
```html
<!-- Primary action button -->
<button class="btn-primary inline-flex items-center justify-center">
    Save Changes
</button>

<!-- Secondary button -->
<button class="btn-secondary">Cancel</button>

<!-- Export button -->
<a href="#" class="btn-export">
    Export CSV
</a>

<!-- Danger button with gradient -->
<button class="btn-danger-gradient">Delete</button>

<!-- Link-style button -->
<a href="#" class="btn-link">View All</a>
```

### Button Components
Use existing button components when possible:

```html
<x-form.button.primary>Save</x-form.button.primary>
<x-form.button.save>Save Changes</x-form.button.save>
<x-form.button.danger>Delete</x-form.button.danger>
<x-form.button.cancel>Cancel</x-form.button.cancel>
<x-form.button.link href="{{ route('clients.index') }}">View Clients</x-form.button.link>
```

## Card System

### DaisyUI Base Card
```html
<div class="card bg-white border border-base-300">
    <!-- card content -->
</div>
```

### Custom Card Variants (from app.css)
```html
<!-- Spacious padding -->
<div class="card-spacious">Content</div>

<!-- Comfortable padding -->
<div class="card-comfortable">Content</div>

<!-- Compact padding -->
<div class="card-compact">Content</div>

<!-- Timer-specific card -->
<div class="card-timer">Content</div>

<!-- Card with header -->
<div class="card">
    <div class="card-header">
        <h3 class="card-heading">Title</h3>
    </div>
    <div class="p-6">Body</div>
</div>
```

## Form Components

### Text Input Pattern
```html
<x-form.text-input
    id="name"
    name="name"
    value="{{ old('name', $client->name ?? '') }}"
    required
    autofocus
/>
```

**Component definition** (`form/text-input.blade.php`):
```blade
<input {{ $attributes->merge([
    'type' => 'text',
    'class' => 'w-full px-4 py-3 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent data-error:border-red-500 transition-all',
]) }}>
```

### Form Label Pattern
```html
<x-form.label for="name" value="Client Name" />
```

### Form Error Pattern
```html
<x-form.error for="name" />
```

### Complete Form Example
```html
<form action="{{ route('clients.store') }}" method="POST">
    @csrf

    <div class="space-y-6">
        <div>
            <x-form.label for="name" value="Client Name" />
            <x-form.text-input
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
            />
            <x-form.error for="name" />
        </div>

        <div class="flex justify-end gap-3">
            <x-form.button.cancel>Cancel</x-form.button.cancel>
            <x-form.button.save>Create Client</x-form.button.save>
        </div>
    </div>
</form>
```

## Layout Patterns

### Responsive Grid
```html
<!-- Mobile-first responsive grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>Column 1</div>
    <div>Column 2</div>
</div>
```

### Container Spacing
```html
<!-- Page container with responsive padding -->
<div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8 py-8">
    {{ $slot }}
</div>

<!-- Mobile-adjusted padding -->
<div class="px-4 sm:px-0">
    Content
</div>
```

### List Layout Pattern
```html
<div class="card">
    <!-- List Header -->
    <x-list.header
        title="Clients"
        :items="$clients"
        singular-label="client"
        plural-label="clients"
    />

    <!-- List Body -->
    <div class="divide-y divide-[var(--border)]">
        @forelse($clients as $client)
            <div class="px-8 py-5">
                <!-- list item content -->
            </div>
        @empty
            <x-list.empty-state
                title="No clients yet"
                description="Get started by creating your first client"
                action-url="{{ route('clients.create') }}"
                action-label="Add Client"
            />
        @endforelse
    </div>

    <!-- Pagination -->
    @if($clients->hasPages())
        <div class="px-8 py-5 border-t border-[var(--border)]">
            {{ $clients->links() }}
        </div>
    @endif
</div>
```

## Empty State Component

```html
<div class="empty-state">
    <div class="empty-state-icon-wrapper">
        <x-heroicon-o-clock class="w-8 h-8 text-[var(--text-secondary)]" />
    </div>
    <h3 class="empty-state-title">No entries yet</h3>
    <p class="empty-state-description">Start tracking time by creating a new entry</p>
    <a href="{{ route('time-entries.create') }}" class="empty-state-action">
        Start Timer
    </a>
</div>
```

## Icons (Heroicons)

### Usage via Blade Components
```html
<!-- Outline icons -->
<x-heroicon-o-clock class="size-6" />

<!-- Solid icons -->
<x-heroicon-s-play class="size-5" />
```

### Icon Sizing Utilities
```html
<x-heroicon-o-clock class="icon-sm" />   <!-- w-4 h-4 -->
<x-heroicon-o-clock class="icon-md" />   <!-- w-[18px] h-[18px] -->
<x-heroicon-o-clock class="icon-lg" />   <!-- w-8 h-8 -->
<x-heroicon-o-clock class="icon-xl" />   <!-- w-14 h-14 -->
```

## Animations & Transitions

### Available Animations (from app.css)
```css
/* Keyframe animations available */
@keyframes fadeInUp { ... }
@keyframes fadeIn { ... }
@keyframes slideInRight { ... }
@keyframes scaleIn { ... }
@keyframes float { ... }
```

### Stagger Delays
```html
<div class="stagger-1">Item 1</div>  <!-- delay: 0.15s -->
<div class="stagger-2">Item 2</div>  <!-- delay: 0.3s -->
<div class="stagger-3">Item 3</div>  <!-- delay: 0.45s -->
```

### Transition Patterns
```html
<!-- Smooth color transition -->
<button class="transition-colors hover:bg-gray-100">

<!-- Transform on hover -->
<div class="transition-transform hover:-translate-y-1">

<!-- Multiple properties -->
<div class="transition-all hover:shadow-lg hover:scale-105">
```

## Responsive Design

### Breakpoint Strategy
- **Mobile-first** - Base styles for mobile, scale up
- **Breakpoints:** `sm:` (640px), `md:` (768px), `lg:` (1024px), `xl:` (1280px)

### Common Responsive Patterns
```html
<!-- Hide on mobile, show on desktop -->
<span class="hidden sm:inline">Desktop text</span>

<!-- Responsive text sizing -->
<h1 class="text-2xl lg:text-4xl">Heading</h1>

<!-- Responsive spacing -->
<div class="px-4 sm:px-6 lg:px-8">Content</div>

<!-- Stack on mobile, grid on desktop -->
<div class="space-y-4 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-6">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

## Dashboard Stats Pattern

```html
<div class="card">
    <div class="p-6">
        <div class="stat-label">Weekly Hours</div>
        <div class="stat-value">42.5h</div>
    </div>
</div>

<!-- Accent color variant -->
<div class="stat-value-accent">$3,250</div>
```

## Turbo Frame Integration

### Contents Class for Layout
```html
<!-- Prevents turbo-frame from creating wrapper div -->
<turbo-frame id="timer-widget" class="contents">
    <div class="card">
        <!-- actual content -->
    </div>
</turbo-frame>
```

### Turbo Frame Styling
```html
<!-- Frame that maintains layout during load -->
<turbo-frame id="clients_list" class="min-h-[200px]">
    @include('turbo.clients')
</turbo-frame>
```

## Best Practices

### Component Reuse
- **Always check** `resources/views/components/` before creating new markup
- Reuse existing button, form, and layout components
- Extend components via `$attributes->merge()` rather than duplicating

### CSS Class Organization
```html
<!-- Good: Logical grouping -->
<button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">

<!-- Avoid: Random order -->
<button class="text-white transition-colors bg-blue-600 px-6 rounded-lg py-3 hover:bg-blue-700 font-medium">
```

### CSS Variable Usage
```html
<!-- Preferred: Use CSS variables for theme colors -->
<div class="text-[var(--color-text)]">

<!-- Avoid: Hardcoding colors when theme variable exists -->
<div class="text-[#1A1F36]">
```

### Custom Utility Classes
- **Use custom utilities** from app.css when available (`.btn-primary`, `.card-timer`, etc.)
- **Don't duplicate** custom styles - extend app.css if needed
- **Check app.css** before writing inline Tailwind for common patterns

### Responsive Considerations
```html
<!-- Good: Mobile-optimized touch targets -->
<button class="px-6 py-3 sm:px-8 sm:py-4">

<!-- Avoid: Too small on mobile -->
<button class="px-2 py-1">
```

### Accessibility
```html
<!-- Always include descriptive labels -->
<x-form.label for="name" value="Client Name" />
<x-form.text-input id="name" name="name" />

<!-- Use semantic HTML -->
<button type="button">Click</button>  <!-- Not <div> -->

<!-- Provide alt text or aria-labels -->
<x-heroicon-o-clock class="size-6" aria-label="Time icon" />
```

### Performance
- **Minimize custom CSS** - use Tailwind utilities first
- **Reuse components** - reduces HTML duplication
- **Use `contents` class** on Turbo Frames to avoid wrapper divs
- **Lazy load images** when appropriate

## Common Pitfalls

### ❌ Don't Create New Base Directories
```html
<!-- DON'T create new component directories without approval -->
resources/views/components/new-feature/  <!-- Ask first! -->
```

### ❌ Don't Mix Inline Styles
```html
<!-- DON'T use inline styles -->
<div style="color: red;">

<!-- DO use Tailwind or CSS variables -->
<div class="text-red-500">
<div class="text-[var(--color-danger)]">
```

### ❌ Don't Ignore Existing Components
```html
<!-- DON'T recreate existing components -->
<button class="...">Submit</button>

<!-- DO use existing component -->
<x-form.button.primary>Submit</x-form.button.primary>
```

### ❌ Don't Hardcode Theme Colors
```html
<!-- DON'T hardcode when CSS variable exists -->
<div class="text-[#1A1F36]">

<!-- DO use CSS variable -->
<div class="text-[var(--color-text)]">
```

## File Locations Reference

- **Component files:** `/resources/views/components/`
- **Layout files:** `/resources/views/components/layouts/`
- **Turbo partials:** `/resources/turbo/`
- **Main CSS:** `/resources/css/app.css`
- **Page views:** `/resources/views/` (dashboard.blade.php, welcome.blade.php, etc.)
