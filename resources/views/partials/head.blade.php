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
        --bg: #FAFBFC;
        --card: #FFFFFF;
        --text: #1A1F36;
        --text-secondary: #697386;
        --text-muted: #9AA5B1;
        --border: #E3E8EE;
        --accent: #0066FF;
        --accent-light: #E6F0FF;
    }

    body {
        font-family: 'Manrope', sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    /* Card styles */
    .card {
        background: var(--card);
        border-radius: 16px;
        border: 1px solid var(--border);
    }

    /* Button styles */
    .btn-primary {
        background: var(--accent);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px 16px;
        font-family: 'Manrope', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--card);
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        font-family: 'Manrope', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    /* Input styles */
    .input-field {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        background: var(--card);
        font-family: 'Manrope', sans-serif;
        font-size: 15px;
        font-weight: 500;
        color: var(--text);
    }

    .input-field:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-light);
    }

    textarea.input-field {
        resize: vertical;
        min-height: 100px;
    }

    /* Label styles */
    .label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 10px;
    }

    /* Stat styles */
    .stat-label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -1px;
    }

    .stat-value-accent {
        color: var(--accent);
    }

    /* Entry info */
    .entry-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .entry-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--text);
    }

    .entry-amount {
        font-family: 'DM Mono', monospace;
        font-size: 24px;
        font-weight: 500;
        color: var(--text);
    }
</style>

<x-importmap::tags />
