# Hotwire (Turbo + Stimulus)
> Server-rendered patterns, Turbo navigation, and Stimulus controllers for SimpleTime OS

## Architecture Overview
- **Server-rendered HTML over HTTP** - No JSON APIs
- **Turbo Drive** - Fast navigation with partial page updates
- **Turbo Frames** - Inline updates without full page reload
- **Stimulus** - Lightweight JavaScript controllers
- **Importmap** - ES modules with no build step

## Turbo Drive

### Navigation
- Turbo intercepts link clicks and form submissions
- Fetches HTML from server and updates the page
- Provides fast, SPA-like navigation without JavaScript frameworks

### Usage
- All standard `<a>` tags are automatically handled by Turbo
- Standard forms are automatically submitted via Turbo

```html
<!-- Automatically uses Turbo Drive -->
<a href="{{ route('projects.index') }}">Projects</a>

<!-- Form automatically submits via Turbo -->
<form action="{{ route('time-entries.store') }}" method="POST">
    @csrf
    <!-- ... -->
</form>
```

## Turbo Frames

### Purpose
- Update part of a page without full reload
- Inline editing, live search, dynamic content

### Location
- Turbo frame partials are in `/resources/turbo/`
- Examples: clients, projects, time-entries, project-filter

### Usage
```html
<!-- Define a Turbo Frame -->
<turbo-frame id="clients_list">
    @include('turbo.clients')
</turbo-frame>

<!-- Link that targets the frame -->
<a href="{{ route('clients.index') }}" data-turbo-frame="clients_list">
    Refresh Clients
</a>
```

## Stimulus Controllers

### Location
- Controllers are in `/resources/js/controllers/`
- 14 controllers currently in use

### Naming Convention
- File: `search_clients_controller.js`
- Class: `SearchClientsController`
- Identifier: `search-clients`

### Controller Examples in Use

#### Timer Controller (`timer_controller.js`)
- Manages timer start/stop/continue functionality
- Handles keyboard shortcuts (Ctrl+Shift+S/T/Space)

#### Session Recovery Controller (`session_recovery_controller.js`)
- Persists timer state across page refreshes
- Uses localStorage

#### Search Controllers (`search_clients_controller.js`, `search_projects_controller.js`)
- Live search with Turbo frames
- Debounced input for performance

#### Inline Edit Controller (`inline_edit_controller.js`)
- Inline editing of fields without page reload

#### Autosave Controller (`autosave_controller.js`)
- Auto-save forms with visual feedback

### Data Attributes
Stimulus uses data attributes for wiring:

```html
<div data-controller="timer">
    <button
        data-action="click->timer#start"
        data-timer-target="startButton">
        Start Timer
    </button>
</div>
```

#### Anatomy
- `data-controller="timer"` - Connects the Stimulus controller
- `data-action="click->timer#start"` - Event -> controller#method
- `data-timer-target="startButton"` - Named target for reference in controller

### Controller Structure
Follow existing patterns when creating new controllers:

```javascript
import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["startButton", "stopButton"]
    static values = { url: String }

    connect() {
        // Called when controller is connected to DOM
    }

    start(event) {
        // Action method
    }
}
```

## Session Persistence Pattern
For state that needs to survive page refreshes:

```javascript
// timer_controller.js pattern
connect() {
    this.loadState()
}

loadState() {
    const state = localStorage.getItem('timer_state')
    if (state) {
        this.restoreTimer(JSON.parse(state))
    }
}

saveState() {
    localStorage.setItem('timer_state', JSON.stringify(this.getState()))
}
```

## Importmap (No Build Step)

### Module Loading
- JavaScript modules are loaded directly by browsers
- No npm build step required
- Configured in `config/importmap.php`

### Adding Dependencies
```bash
# Add a new npm package to importmap
php artisan importmap:pin @hotwired/turbo
```

## Best Practices

### Follow Existing Patterns
- Check existing Stimulus controllers for structure
- Reuse controller patterns (search, autosave, inline edit)
- Keep controllers focused on single responsibility

### Turbo Frame Guidelines
- Use descriptive frame IDs (`clients_list`, not `frame1`)
- Place frame partials in `/resources/turbo/`
- Test frame updates work independently

### Data Attribute Organization
```html
<!-- Good: Clear hierarchy -->
<div data-controller="timer search">
    <input
        data-search-target="input"
        data-action="input->search#filter">
</div>

<!-- Avoid: Mixing concerns -->
<div data-controller="timer" data-action="click->search#filter">
```

### Server Responses
- Return HTML, not JSON
- Use Blade templates for all responses
- Turbo expects HTML responses for frames and navigation
