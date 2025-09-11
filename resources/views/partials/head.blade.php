<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0{{ $scalable ?? false ? ', maximum-scale=1.0, user-scalable=0' : '' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="project-filter-route" content="{{ route('project-filter') }}">

@if ($transitions ?? false)
    <meta name="view-transition" content="same-origin">
@endif

<title>{{ $title ?? config('app.name') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />

<style>
    :root {
        --color-bg: #FAFBFC;
        --color-surface: #FFFFFF;
        --color-text: #1A1F36;
        --color-text-secondary: #697386;
        --color-text-muted: #9AA5B1;
        --color-border: #E3E8EE;
        --color-border-light: #F3F4F6;
        --color-primary: #0066FF;
        --color-primary-hover: #0052CC;
        --color-primary-light: #E6F0FF;
        --color-accent: #FB923C;
        --color-accent-hover: #F97316;
        --color-accent-light: #FFF7ED;
        --color-success: #10B981;
        --color-success-light: #D1FAE5;
        --color-danger: #EF4444;
        --color-danger-light: #FEE2E2;
        --font-display: 'Manrope', sans-serif;
        --font-body: 'Manrope', sans-serif;
        --font-mono: 'DM Mono', monospace;
        --ease-smooth: cubic-bezier(0.4, 0.0, 0.2, 1);
        --ease-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);

        /* Legacy variable support */
        --bg: var(--color-bg);
        --card: var(--color-surface);
        --text: var(--color-text);
        --text-secondary: var(--color-text-secondary);
        --text-muted: var(--color-text-muted);
        --border: var(--color-border);
        --accent: var(--color-primary);
        --accent-light: var(--color-primary-light);
    }

    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        font-family: var(--font-body);
        background: var(--color-bg);
        color: var(--color-text);
    }

    .font-display {
        font-family: var(--font-display);
        letter-spacing: -0.02em;
        font-weight: 700;
    }

    /* Card styles */
    .card {
        background: var(--color-surface);
        border-radius: 16px;
        border: 2px solid var(--color-border-light);
        transition: all 0.3s var(--ease-smooth);
    }

    .card:hover {
        border-color: var(--color-border);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }

    /* Button styles */
    .btn-primary {
        background: var(--accent);
        color: white;
        transition: background-color 0.3s var(--ease-smooth);
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 14px 24px;
        font-family: var(--font-body);
        font-size: 15px;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: var(--color-primary-hover);
    }

    .btn-primary:active {
        transform: translateY(0) scale(1);
    }

    .btn-secondary {
        border: 2px solid var(--color-border);
        color: var(--color-text);
        background: var(--color-surface);
        transition: all 0.3s var(--ease-smooth);
        font-weight: 600;
        border-radius: 12px;
        padding: 14px 24px;
        font-family: var(--font-body);
        font-size: 15px;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .btn-secondary:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 102, 255, 0.1);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    /* Input styles */
    .input-field {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--color-border);
        border-radius: 8px;
        background: var(--color-surface);
        font-family: var(--font-body);
        font-size: 15px;
        font-weight: 500;
        color: var(--color-text);
        transition: all 0.2s var(--ease-smooth);
    }

    .input-field:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px var(--color-primary-light);
    }

    .input-field:hover {
        border-color: var(--color-text-muted);
    }

    textarea.input-field {
        resize: vertical;
        min-height: 100px;
    }

    /* Label styles */
    .label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-secondary);
        margin-bottom: 8px;
    }

    /* Stat styles */
    .stat-label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-muted);
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 700;
        color: var(--color-text);
        letter-spacing: -1px;
    }

    .stat-value-accent {
        color: var(--color-primary);
    }

    /* Entry info */
    .entry-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-muted);
        margin-bottom: 6px;
    }

    .entry-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--color-text);
    }

    .entry-amount {
        font-family: var(--font-mono);
        font-size: 24px;
        font-weight: 500;
        color: var(--color-text);
    }

    /* Navigation Enhancement */
    nav {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.95) !important;
        border-bottom: 1px solid var(--color-border-light);
    }

    /* Link Styles */
    a.link-hover {
        position: relative;
        transition: color 0.3s var(--ease-smooth);
    }

    a.link-hover::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: currentColor;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s var(--ease-smooth);
    }

    a.link-hover:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }
</style>

<x-importmap::tags />
