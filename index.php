<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DorkSearch - Google Dork Generator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Flatpickr Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ========================================
           TEXT SELECTION PREVENTION
           Disabled globally to improve usability
           and prevent accidental highlighting
           during clicks/taps on UI elements.
           ======================================== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(180deg, #0a1a0a 0%, #0d2818 50%, #0a1a0a 100%);
            min-height: 100vh;
            color: #e4e4e4;
            padding: 40px 20px;
            /* Text selection prevention */
            -webkit-user-select: none;  /* Safari, Chrome, iOS */
            -moz-user-select: none;     /* Firefox */
            -ms-user-select: none;      /* IE 10+ / Edge */
            user-select: none;          /* Standard */
            -webkit-touch-callout: none; /* iOS Safari - disable callout */
        }

        /* Re-enable selection for form inputs and editable fields
           so users can type, select, copy text normally */
        input,
        textarea,
        select,
        [contenteditable="true"],
        .preview-query {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
            -webkit-touch-callout: default;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-text {
            font-size: 2.8rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 50%, #16a34a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            position: relative;
        }

        .logo-text::before {
            content: 'DorkSearch';
            position: absolute;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 50%, #16a34a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: blur(20px);
            opacity: 0.6;
            z-index: -1;
        }

        .logo-icon {
            display: inline-block;
            font-size: 2.2rem;
            margin-right: 8px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .logo-subtitle {
            font-size: 0.9rem;
            color: #6b8f6b;
            margin-top: 8px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .mode-toggle-row {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .search-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .keyword-input {
            flex: 1;
            padding: 16px 20px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            background: #1a2e1a;
            border: 2px solid #2d4a2d;
            border-radius: 12px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .keyword-input:focus {
            outline: none;
            border-color: #4ade80;
            box-shadow: 0 0 20px rgba(74, 222, 128, 0.2);
        }

        .keyword-input::placeholder {
            color: #6b8f6b;
        }

        .dork-btn {
            padding: 16px 32px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .dork-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }

        .section {
            margin-bottom: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #1a3a2a 0%, #1a2e1a 100%);
            border-radius: 16px;
            border: 1px solid #2d4a2d;
        }

        .section-title {
            font-size: 0.85rem;
            color: #4ade80;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .multi-input-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .text-input {
            flex: 1;
            padding: 12px 15px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            background: #0d2818;
            border: 2px solid #2d4a2d;
            border-radius: 10px;
            color: #fff;
        }

        .text-input:focus {
            outline: none;
            border-color: #4ade80;
        }

        .text-input::placeholder {
            color: #4a6b4a;
        }

        select.text-input {
            cursor: pointer;
        }

        select.text-input option {
            background: #0d2818;
            color: #fff;
        }

        .add-btn, .remove-btn {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 10px;
            font-size: 1.4rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .add-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
        }

        .add-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.5);
        }

        .remove-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }

        .remove-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px;
            background: rgba(13, 40, 24, 0.6);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .checkbox-item:hover {
            background: rgba(13, 40, 24, 0.9);
            border-color: #2d4a2d;
        }

        .checkbox-item input[type="checkbox"] {
            width: 22px;
            height: 22px;
            accent-color: #22c55e;
            cursor: pointer;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .checkbox-label {
            flex: 1;
        }

        .checkbox-label strong {
            color: #4ade80;
            display: block;
            margin-bottom: 4px;
            font-size: 1rem;
        }

        .checkbox-label small {
            color: #7a9a7a;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .preview-section {
            margin-bottom: 25px;
            padding: 16px 20px;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.1));
            border-radius: 12px;
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(10px);
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .preview-icon {
            font-size: 1rem;
        }

        .preview-title {
            font-size: 0.75rem;
            color: #4ade80;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .preview-query {
            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
            font-size: 0.9rem;
            color: #fff;
            word-break: break-all;
            padding: 12px 14px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 8px;
            min-height: 20px;
            border-left: 3px solid #22c55e;
        }

        /* Mode Toggle Styles */
        .mode-toggle {
            display: flex;
            background: #0d2818;
            border-radius: 12px;
            padding: 4px;
            gap: 4px;
            border: 2px solid #2d4a2d;
        }

        .mode-btn {
            padding: 12px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            background: transparent;
            border: none;
            border-radius: 8px;
            color: #6b8f6b;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .mode-btn.active {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .mode-btn:hover:not(.active) {
            background: rgba(34, 197, 94, 0.1);
            color: #4ade80;
        }

        .mode-icon {
            font-size: 1rem;
        }

        /* URL Operators Section */
        .url-operators {
            display: none;
        }

        .url-operators.visible {
            display: block;
        }

        .keyword-sections {
            display: block;
        }

        .keyword-sections.hidden {
            display: none;
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            background: rgba(13, 40, 24, 0.6);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .radio-item:hover {
            background: rgba(13, 40, 24, 0.9);
            border-color: #2d4a2d;
        }

        .radio-item.selected {
            background: rgba(34, 197, 94, 0.15);
            border-color: #22c55e;
        }

        .radio-item input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: #22c55e;
            cursor: pointer;
            flex-shrink: 0;
        }

        .radio-label {
            flex: 1;
        }

        .radio-label strong {
            color: #4ade80;
            display: block;
            margin-bottom: 4px;
            font-size: 1rem;
            font-weight: 600;
        }

        .radio-label small {
            color: #7a9a7a;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .operator-icon {
            font-size: 1.4rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(34, 197, 94, 0.2);
            border-radius: 8px;
        }

        /* Compact Radio Items for Search Scope */
        .radio-item.compact {
            padding: 12px 14px;
        }

        .radio-item.compact .radio-label strong {
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .radio-item.compact .radio-label small {
            font-size: 0.8rem;
        }

        /* Toggle Switch Styles */
        .toggle-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding: 10px 14px;
            background: rgba(13, 40, 24, 0.4);
            border-radius: 8px;
        }

        .toggle-switch {
            position: relative;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #2d4a2d;
            border-radius: 26px;
            transition: 0.3s;
        }

        .toggle-slider::before {
            position: absolute;
            content: '';
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background: #6b8f6b;
            border-radius: 50%;
            transition: 0.3s;
        }

        .toggle-switch input:checked + .toggle-slider {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(22px);
            background: #fff;
        }

        .toggle-label {
            font-size: 0.9rem;
            color: #9ab89a;
        }

        .toggle-label code {
            background: rgba(34, 197, 94, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            color: #4ade80;
            font-family: 'JetBrains Mono', monospace;
        }

        /* Date Range Styles */
        .date-range-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .date-input-group {
            flex: 1;
            min-width: 160px;
        }

        .date-label {
            display: block;
            font-size: 0.8rem;
            color: #4ade80;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .date-label code {
            background: rgba(34, 197, 94, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            color: #6b8f6b;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            margin-left: 4px;
        }

        .date-input {
            width: 100%;
            padding: 12px 15px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            background: #0d2818;
            border: 2px solid #2d4a2d;
            border-radius: 10px;
            color: #fff;
            color-scheme: dark;
            transition: all 0.3s ease;
        }

        .date-input:hover {
            border-color: #3d5a3d;
            background: #0f3020;
        }

        .date-input:focus {
            outline: none;
            border-color: #4ade80;
            box-shadow: 0 0 15px rgba(74, 222, 128, 0.15);
        }

        .date-input::placeholder {
            color: #4a6b4a;
        }

        /* Date Preset Buttons */
        .date-presets {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .preset-btn {
            padding: 8px 14px;
            font-size: 0.8rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid #2d4a2d;
            border-radius: 20px;
            color: #4ade80;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .preset-btn:hover {
            background: rgba(34, 197, 94, 0.25);
            border-color: #4ade80;
            transform: translateY(-1px);
        }

        .preset-btn:active {
            transform: translateY(0);
        }

        .preset-btn.preset-clear {
            background: rgba(239, 68, 68, 0.1);
            border-color: #5a3a3a;
            color: #f87171;
        }

        .preset-btn.preset-clear:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #f87171;
        }

        /* Date Validation */
        .date-input.date-invalid {
            border-color: #f59e0b !important;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.2) !important;
        }

        .date-validation-hint {
            font-size: 0.8rem;
            color: #f59e0b;
            margin-top: 12px;
            padding: 10px 14px;
            background: rgba(245, 158, 11, 0.1);
            border-radius: 8px;
            border-left: 3px solid #f59e0b;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .date-validation-hint.visible {
            opacity: 1;
            max-height: 60px;
        }

        /* Individual Date Clear Controls */
        .date-clear-controls {
            display: flex;
            gap: 12px;
            margin-top: 10px;
            justify-content: flex-start;
        }

        [data-lang="dar"] .date-clear-controls,
        [data-lang="both"] .date-clear-controls {
            justify-content: flex-end;
        }

        .date-clear-btn {
            padding: 4px 10px;
            font-size: 0.7rem;
            font-family: 'Inter', sans-serif;
            background: transparent;
            border: 1px solid rgba(107, 114, 128, 0.3);
            border-radius: 12px;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-clear-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(248, 113, 113, 0.4);
            color: #f87171;
        }

        .date-clear-btn:active {
            transform: scale(0.97);
        }

        /* Flatpickr Custom Theme Overrides */
        .flatpickr-calendar {
            background: #0d2818 !important;
            border: 2px solid #2d4a2d !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
            font-family: 'Inter', sans-serif !important;
            opacity: 0;
            transform: scale(0.95) translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease !important;
        }

        .flatpickr-calendar.open {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        .flatpickr-calendar.arrowTop::before,
        .flatpickr-calendar.arrowTop::after {
            border-bottom-color: #1a3a2a !important;
        }

        .flatpickr-months {
            background: #1a3a2a !important;
            border-radius: 10px 10px 0 0 !important;
            padding: 8px 0 !important;
        }

        .flatpickr-months .flatpickr-month {
            background: transparent !important;
            color: #4ade80 !important;
            fill: #4ade80 !important;
            height: 34px !important;
        }

        .flatpickr-current-month {
            padding-top: 5px !important;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: #fff !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
        }

        .flatpickr-monthDropdown-months {
            background: #0d2818 !important;
            border: 1px solid #2d4a2d !important;
            border-radius: 6px !important;
        }

        .flatpickr-monthDropdown-months option {
            background: #0d2818 !important;
            color: #fff !important;
        }

        .flatpickr-weekdays {
            background: #1a3a2a !important;
            padding: 8px 0 !important;
        }

        .flatpickr-weekday {
            color: #6b8f6b !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
        }

        .flatpickr-days {
            background: #0d2818 !important;
            border-radius: 0 0 10px 10px !important;
        }

        .dayContainer {
            background: #0d2818 !important;
            padding: 4px !important;
        }

        .flatpickr-day {
            color: #c4d4c4 !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
            transition: all 0.15s ease !important;
            border: 1px solid transparent !important;
        }

        .flatpickr-day:hover {
            background: #1a3a2a !important;
            border-color: #2d4a2d !important;
        }

        .flatpickr-day.today {
            border-color: #4ade80 !important;
            background: rgba(74, 222, 128, 0.1) !important;
        }

        .flatpickr-day.today:hover {
            background: rgba(74, 222, 128, 0.2) !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: linear-gradient(135deg, #22c55e, #16a34a) !important;
            border-color: #22c55e !important;
            color: #fff !important;
            font-weight: 600 !important;
        }

        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #3a5a3a !important;
        }

        .flatpickr-day.prevMonthDay:hover,
        .flatpickr-day.nextMonthDay:hover {
            background: #152515 !important;
            border-color: #2d4a2d !important;
        }

        .flatpickr-day.flatpickr-disabled {
            color: #2a3a2a !important;
        }

        .flatpickr-prev-month,
        .flatpickr-next-month {
            fill: #6b8f6b !important;
            padding: 8px !important;
            transition: all 0.15s ease !important;
        }

        .flatpickr-prev-month:hover,
        .flatpickr-next-month:hover {
            background: rgba(74, 222, 128, 0.1) !important;
            border-radius: 6px !important;
        }

        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg {
            fill: #4ade80 !important;
        }

        .numInputWrapper {
            transition: all 0.15s ease !important;
        }

        .numInputWrapper:hover {
            background: rgba(74, 222, 128, 0.1) !important;
            border-radius: 4px !important;
        }

        .numInputWrapper span {
            border-color: #2d4a2d !important;
            transition: all 0.15s ease !important;
        }

        .numInputWrapper span:hover {
            background: #2d4a2d !important;
        }

        .numInputWrapper span::after {
            border-top-color: #6b8f6b !important;
            border-bottom-color: #6b8f6b !important;
        }

        /* Respect reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            .flatpickr-calendar {
                transition: opacity 0.1s ease !important;
                transform: none !important;
            }
            .flatpickr-day,
            .preset-btn,
            .date-input,
            .date-validation-hint {
                transition: none !important;
            }
        }

        /* Advanced Section Styles */
        .advanced-section .section-title.collapsible {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            margin-bottom: 0;
            transition: margin 0.3s ease;
        }

        .advanced-section .section-title.collapsible.open {
            margin-bottom: 16px;
        }

        .collapse-icon {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
            color: #6b8f6b;
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        .advanced-content {
            display: none;
            padding-top: 16px;
            border-top: 1px solid #2d4a2d;
            margin-top: 16px;
        }

        .advanced-content.visible {
            display: block;
        }

        .advanced-option {
            margin-bottom: 16px;
        }

        .advanced-option:last-child {
            margin-bottom: 0;
        }

        .option-label {
            display: block;
            font-size: 0.85rem;
            color: #9ab89a;
            margin-bottom: 10px;
        }

        .numrange-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .numrange-input {
            width: 100px;
            text-align: center;
        }

        .range-separator {
            color: #6b8f6b;
            font-size: 0.9rem;
        }

        /* Definition Mode Sections */
        .definition-sections {
            display: none;
        }

        .definition-sections.visible {
            display: block;
        }

        /* Language Toggle Styles */
        .lang-toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        .lang-toggle {
            display: flex;
            background: #0d2818;
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
            border: 1px solid #2d4a2d;
        }

        .lang-btn {
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            background: transparent;
            border: none;
            border-radius: 6px;
            color: #6b8f6b;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .lang-btn.active {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
        }

        .lang-btn:hover:not(.active) {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
        }

        /* Bilingual Text Styles */
        .text-en {
            display: block;
        }

        .text-dar {
            display: block;
            direction: rtl;
            font-family: 'Noto Sans Arabic', 'Inter', sans-serif;
            font-size: 0.9em;
            color: #9ab89a;
            margin-top: 2px;
        }

        .text-dar-inline {
            direction: rtl;
            font-family: 'Noto Sans Arabic', 'Inter', sans-serif;
        }

        /* Language visibility states */
        [data-lang="en"] .text-dar,
        [data-lang="en"] .text-dar-inline {
            display: none;
        }

        [data-lang="dar"] .text-en {
            display: none;
        }

        [data-lang="dar"] .text-dar {
            display: block;
            color: #e4e4e4;
            font-size: 1em;
            margin-top: 0;
        }

        [data-lang="both"] .text-dar {
            display: block;
        }

        /* RTL-specific adjustments for DAR mode */
        [data-lang="dar"] .section-title,
        [data-lang="dar"] .radio-label,
        [data-lang="dar"] .date-label,
        [data-lang="dar"] .option-label,
        [data-lang="dar"] .toggle-label {
            direction: rtl;
            text-align: right;
        }

        [data-lang="dar"] .date-range-container {
            flex-direction: row-reverse;
        }

        [data-lang="dar"] .date-presets,
        [data-lang="both"] .date-presets {
            justify-content: flex-end;
        }

        [data-lang="dar"] .collapse-icon {
            transform: scaleX(-1);
        }

        [data-lang="dar"] .collapse-icon.rotated {
            transform: scaleX(-1) rotate(-180deg);
        }

        /* Keep code elements LTR even in RTL context */
        [data-lang="dar"] code,
        [data-lang="both"] .text-dar code {
            direction: ltr;
            unicode-bidi: embed;
        }

        @media (max-width: 600px) {
            .lang-toggle-container {
                position: relative;
                top: 0;
                right: 0;
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }
            .search-row {
                flex-direction: column;
            }
            .dork-btn {
                width: 100%;
            }
            .logo-text {
                font-size: 2rem;
            }
            .logo-icon {
                font-size: 1.6rem;
            }
            .mode-toggle {
                width: 100%;
                flex-wrap: wrap;
            }
            .mode-btn {
                flex: 1;
                justify-content: center;
                min-width: 100px;
            }
            .date-range-container {
                flex-direction: column;
            }
            .numrange-container {
                flex-wrap: wrap;
            }
            .numrange-input {
                flex: 1;
                min-width: 80px;
            }
        }
    </style>
</head>
<body data-lang="both">
    <!-- Language Toggle -->
    <div class="lang-toggle-container">
        <div class="lang-toggle">
            <button class="lang-btn" onclick="setLang('en')">EN</button>
            <button class="lang-btn" onclick="setLang('dar')">DAR</button>
            <button class="lang-btn active" onclick="setLang('both')">BOTH</button>
        </div>
    </div>

    <div class="container">
        <div class="logo">
            <div>
                <span class="logo-icon">🔍</span><span class="logo-text">DorkSearch</span>
            </div>
            <div class="logo-subtitle">
                <span class="text-en">Google Dork Query Builder</span>
                <span class="text-dar">أداة بناء استعلامات جوجل المتقدمة</span>
            </div>
        </div>

        <div class="mode-toggle-row">
            <div class="mode-toggle">
                <button class="mode-btn active" id="keywordModeBtn" onclick="setMode('keyword')">
                    <span class="mode-icon">🔤</span>
                    <span class="text-en">Keyword</span>
                    <span class="text-dar">كلمة مفتاحية</span>
                </button>
                <button class="mode-btn" id="websiteModeBtn" onclick="setMode('website')">
                    <span class="mode-icon">🌐</span>
                    <span class="text-en">Website</span>
                    <span class="text-dar">موقع</span>
                </button>
                <button class="mode-btn" id="definitionModeBtn" onclick="setMode('definition')">
                    <span class="mode-icon">📖</span>
                    <span class="text-en">Definition</span>
                    <span class="text-dar">تعريف</span>
                </button>
            </div>
        </div>

        <div class="search-row">
            <input type="text" id="keyword" class="keyword-input" data-placeholder-en="Enter your search keyword..." data-placeholder-dar="أدخل كلمة البحث..." placeholder="Enter your search keyword..." autofocus>
            <button class="dork-btn" onclick="dorkIt()">
                <span class="text-en">Dork it!</span>
                <span class="text-dar">ابحث!</span>
            </button>
        </div>

        <div class="preview-section">
            <div class="preview-header">
                <span class="preview-icon">⚡</span>
                <div class="preview-title">
                    <span class="text-en">Search Preview Result</span>
                    <span class="text-dar">معاينة الاستعلام</span>
                </div>
            </div>
            <div class="preview-query" id="previewQuery">—</div>
        </div>

        <div class="url-operators" id="urlOperators">
            <div class="section">
                <div class="section-title">
                    <span>🔗</span>
                    <span class="text-en">URL Operator (Select One)</span>
                    <span class="text-dar">عامل الرابط (ختار واحد)</span>
                </div>
                <div class="radio-group">
                    <label class="radio-item selected">
                        <input type="radio" name="urlOperator" value="cache" checked>
                        <span class="operator-icon">📦</span>
                        <div class="radio-label">
                            <strong>cache:</strong>
                            <small>
                                <span class="text-en">View Google's cached/saved version of the website.</span>
                                <span class="text-dar">عرض النسخة المحفوظة ديال الموقع ف جوجل.</span>
                            </small>
                        </div>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="urlOperator" value="related">
                        <span class="operator-icon">🔀</span>
                        <div class="radio-label">
                            <strong>related:</strong>
                            <small>
                                <span class="text-en">Find websites similar to the specified URL.</span>
                                <span class="text-dar">لقا مواقع كتشبه هاد الموقع.</span>
                            </small>
                        </div>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="urlOperator" value="info">
                        <span class="operator-icon">ℹ️</span>
                        <div class="radio-label">
                            <strong>info:</strong>
                            <small>
                                <span class="text-en">Get information Google has about the URL.</span>
                                <span class="text-dar">جيب معلومات عند جوجل على هاد الرابط.</span>
                            </small>
                        </div>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="urlOperator" value="link">
                        <span class="operator-icon">🔗</span>
                        <div class="radio-label">
                            <strong>link:</strong>
                            <small>
                                <span class="text-en">Find pages that link to the specified URL.</span>
                                <span class="text-dar">لقا صفحات فيها روابط لهاد الموقع.</span>
                            </small>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="keyword-sections" id="keywordSections">
        <!-- Search Scope Operators - Radio buttons for single selection -->
        <div class="section">
            <div class="section-title">
                <span>⚙️</span>
                <span class="text-en">Search Scope (Optional)</span>
                <span class="text-dar">نطاق البحث (اختياري)</span>
            </div>
            <div class="radio-group" id="scopeRadioGroup">
                <label class="radio-item compact selected">
                    <input type="radio" name="searchScope" value="normal" checked>
                    <div class="radio-label">
                        <strong><span class="text-en">Normal</span><span class="text-dar">عادي</span></strong>
                        <small>
                            <span class="text-en">Standard Google search</span>
                            <span class="text-dar">بحث جوجل عادي</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="intext">
                    <div class="radio-label">
                        <strong>intext:</strong>
                        <small>
                            <span class="text-en">Keyword in page body</span>
                            <span class="text-dar">الكلمة ف محتوى الصفحة</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="allintext">
                    <div class="radio-label">
                        <strong>allintext:</strong>
                        <small>
                            <span class="text-en">All words must be in body</span>
                            <span class="text-dar">جميع الكلمات خصهم يكونو ف المحتوى</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="intitle">
                    <div class="radio-label">
                        <strong>intitle:</strong>
                        <small>
                            <span class="text-en">Keyword in page title</span>
                            <span class="text-dar">الكلمة ف عنوان الصفحة</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="allintitle">
                    <div class="radio-label">
                        <strong>allintitle:</strong>
                        <small>
                            <span class="text-en">All words must be in title</span>
                            <span class="text-dar">جميع الكلمات خصهم يكونو ف العنوان</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="inurl">
                    <div class="radio-label">
                        <strong>inurl:</strong>
                        <small>
                            <span class="text-en">Keyword in URL</span>
                            <span class="text-dar">الكلمة ف الرابط</span>
                        </small>
                    </div>
                </label>
                <label class="radio-item compact">
                    <input type="radio" name="searchScope" value="allinurl">
                    <div class="radio-label">
                        <strong>allinurl:</strong>
                        <small>
                            <span class="text-en">All words must be in URL</span>
                            <span class="text-dar">جميع الكلمات خصهم يكونو ف الرابط</span>
                        </small>
                    </div>
                </label>
            </div>
        </div>

        <!-- Filetype Section with ext: toggle -->
        <div class="section">
            <div class="section-title">
                <span>📄</span>
                <span class="text-en">Filetype (Optional)</span>
                <span class="text-dar">نوع الملف (اختياري)</span>
            </div>
            <div class="toggle-row">
                <label class="toggle-switch">
                    <input type="checkbox" id="useExtToggle">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">
                    <span class="text-en">Use <code>ext:</code> instead of <code>filetype:</code></span>
                    <span class="text-dar">استعمل <code>ext:</code> بدل <code>filetype:</code></span>
                </span>
            </div>
            <div class="multi-input-container" id="filetypeContainer">
                <div class="input-row">
                    <select class="text-input filetype-select">
                        <option value="">-- Select filetype --</option>
                        <option value="pdf">PDF</option>
                        <option value="doc">DOC</option>
                        <option value="docx">DOCX</option>
                        <option value="xls">XLS</option>
                        <option value="xlsx">XLSX</option>
                        <option value="txt">TXT</option>
                        <option value="ppt">PPT</option>
                        <option value="pptx">PPTX</option>
                        <option value="pps">PPS</option>
                        <option value="rtf">RTF</option>
                        <option value="odt">ODT</option>
                        <option value="sxw">SXW</option>
                        <option value="psw">PSW</option>
                        <option value="ps">PS</option>
                        <option value="xml">XML</option>
                        <option value="psd">PSD</option>
                    </select>
                    <button class="add-btn" onclick="addFiletype()">+</button>
                </div>
            </div>
        </div>

        <!-- Site Section -->
        <div class="section">
            <div class="section-title">
                <span>🌐</span>
                <span class="text-en">Site (Optional)</span>
                <span class="text-dar">الموقع (اختياري)</span>
            </div>
            <div class="multi-input-container" id="siteContainer">
                <div class="input-row">
                    <input type="text" class="text-input site-input" placeholder="e.g. github.com">
                    <button class="add-btn" onclick="addSite()">+</button>
                </div>
            </div>
        </div>

        <!-- Date Range Section -->
        <div class="section">
            <div class="section-title">
                <span>📅</span>
                <span class="text-en">Date Range (Optional)</span>
                <span class="text-dar">نطاق التاريخ (اختياري)</span>
            </div>
            <div class="date-presets">
                <button type="button" class="preset-btn" onclick="setDatePreset(7)">
                    <span class="text-en">Last 7 days</span>
                    <span class="text-dar">آخر 7 أيام</span>
                </button>
                <button type="button" class="preset-btn" onclick="setDatePreset(30)">
                    <span class="text-en">Last 30 days</span>
                    <span class="text-dar">آخر 30 يوم</span>
                </button>
                <button type="button" class="preset-btn" onclick="setDatePreset(90)">
                    <span class="text-en">Last 90 days</span>
                    <span class="text-dar">آخر 90 يوم</span>
                </button>
                <button type="button" class="preset-btn preset-clear" onclick="clearDates()">
                    <span class="text-en">Clear</span>
                    <span class="text-dar">إفراغ</span>
                </button>
            </div>
            <div class="date-range-container">
                <div class="date-input-group">
                    <label class="date-label" for="dateBefore">
                        <span class="text-en">Before date</span>
                        <span class="text-dar">قبل تاريخ</span>
                        <code>before:</code>
                    </label>
                    <input type="text" id="dateBefore" class="date-input flatpickr-input" data-placeholder-en="Select date..." data-placeholder-dar="ختار تاريخ..." placeholder="Select date..." readonly>
                </div>
                <div class="date-input-group">
                    <label class="date-label" for="dateAfter">
                        <span class="text-en">After date</span>
                        <span class="text-dar">بعد تاريخ</span>
                        <code>after:</code>
                    </label>
                    <input type="text" id="dateAfter" class="date-input flatpickr-input" data-placeholder-en="Select date..." data-placeholder-dar="ختار تاريخ..." placeholder="Select date..." readonly>
                </div>
            </div>
            <div class="date-clear-controls">
                <button type="button" class="date-clear-btn" onclick="clearSingleDate('before')">
                    <span class="text-en">✕ Clear Before</span>
                    <span class="text-dar">✕ مسح قبل</span>
                </button>
                <button type="button" class="date-clear-btn" onclick="clearSingleDate('after')">
                    <span class="text-en">✕ Clear After</span>
                    <span class="text-dar">✕ مسح بعد</span>
                </button>
            </div>
            <div class="date-validation-hint" id="dateValidationHint"></div>
        </div>

        <!-- Advanced Options - Collapsible -->
        <div class="section advanced-section">
            <div class="section-title collapsible" onclick="toggleAdvanced()">
                <span>
                    <span>🔧</span>
                    <span class="text-en">Advanced Options</span>
                    <span class="text-dar">خيارات متقدمة</span>
                </span>
                <span class="collapse-icon" id="advancedIcon">▼</span>
            </div>
            <div class="advanced-content" id="advancedContent">
                <div class="advanced-option">
                    <label class="option-label">
                        <span class="text-en">Number Range</span>
                        <span class="text-dar">نطاق الأرقام</span>
                        (numrange:)
                    </label>
                    <div class="numrange-container">
                        <input type="number" id="numrangeMin" class="text-input numrange-input" data-placeholder-en="Min" data-placeholder-dar="أقل" placeholder="Min">
                        <span class="range-separator">
                            <span class="text-en">to</span>
                            <span class="text-dar">إلى</span>
                        </span>
                        <input type="number" id="numrangeMax" class="text-input numrange-input" data-placeholder-en="Max" data-placeholder-dar="أقصى" placeholder="Max">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="app.js"></script>
    <script>
        // Flatpickr instances
        let fpAfter, fpBefore;

        // Initialize Flatpickr with dark theme
        const fpConfig = {
            dateFormat: 'Y-m-d',
            allowInput: true,
            disableMobile: true,
            animate: true,
            onChange: function() {
                validateDateRange();
                _u();
            }
        };

        fpAfter = flatpickr('#dateAfter', fpConfig);
        fpBefore = flatpickr('#dateBefore', fpConfig);

        // Date preset function
        function setDatePreset(days) {
            const today = new Date();
            const pastDate = new Date();
            pastDate.setDate(today.getDate() - days);
            
            const formatDate = (d) => d.toISOString().split('T')[0];
            
            fpAfter.setDate(formatDate(pastDate), true);
            fpBefore.setDate(formatDate(today), true);
            
            validateDateRange();
            _u();
        }

        // Clear dates function
        function clearDates() {
            fpAfter.clear();
            fpBefore.clear();
            validateDateRange();
            _u();
        }

        // Validate date range
        function validateDateRange() {
            const afterInput = document.getElementById('dateAfter');
            const beforeInput = document.getElementById('dateBefore');
            const hint = document.getElementById('dateValidationHint');
            const afterVal = afterInput.value;
            const beforeVal = beforeInput.value;

            if (afterVal && beforeVal) {
                const afterDate = new Date(afterVal);
                const beforeDate = new Date(beforeVal);
                
                if (afterDate > beforeDate) {
                    afterInput.classList.add('date-invalid');
                    beforeInput.classList.add('date-invalid');
                    hint.textContent = '⚠️ "After" date cannot be later than "Before" date';
                    hint.classList.add('visible');
                    return false;
                }
            }
            
            afterInput.classList.remove('date-invalid');
            beforeInput.classList.remove('date-invalid');
            hint.classList.remove('visible');
            hint.textContent = '';
            return true;
        }

        // Clear individual date
        function clearSingleDate(which) {
            if (which === 'before') {
                fpBefore.clear();
            } else if (which === 'after') {
                fpAfter.clear();
            }
            validateDateRange();
            _u();
        }

        // Reset all state on page load - ensures fresh start
        function resetAllState() {
            // Clear keyword input
            document.getElementById('keyword').value = '';
            
            // Reset mode to Keyword (default)
            setMode('keyword');
            
            // Clear Flatpickr date selections
            fpAfter.clear();
            fpBefore.clear();
            
            // Reset filetype selects to default
            document.querySelectorAll('.filetype-select').forEach(s => s.selectedIndex = 0);
            
            // Clear site inputs
            document.querySelectorAll('.site-input').forEach(i => i.value = '');
            
            // Reset search scope to Normal
            const normalRadio = document.querySelector('input[name="searchScope"][value="normal"]');
            if (normalRadio) {
                normalRadio.checked = true;
                document.querySelectorAll('#scopeRadioGroup .radio-item').forEach(r => r.classList.remove('selected'));
                normalRadio.closest('.radio-item').classList.add('selected');
            }
            
            // Reset URL operator to cache (default)
            const cacheRadio = document.querySelector('input[name="urlOperator"][value="cache"]');
            if (cacheRadio) {
                cacheRadio.checked = true;
                document.querySelectorAll('#urlOperators .radio-item').forEach(r => r.classList.remove('selected'));
                cacheRadio.closest('.radio-item').classList.add('selected');
            }
            
            // Reset ext toggle
            const extToggle = document.getElementById('useExtToggle');
            if (extToggle) extToggle.checked = false;
            
            // Clear numrange inputs
            const numMin = document.getElementById('numrangeMin');
            const numMax = document.getElementById('numrangeMax');
            if (numMin) numMin.value = '';
            if (numMax) numMax.value = '';
            
            // Collapse advanced section
            const advContent = document.getElementById('advancedContent');
            const advIcon = document.getElementById('advancedIcon');
            const advTitle = document.querySelector('.section-title.collapsible');
            if (advContent) advContent.classList.remove('visible');
            if (advIcon) advIcon.classList.remove('rotated');
            if (advTitle) advTitle.classList.remove('open');
            
            // Clear validation states
            document.querySelectorAll('.date-invalid').forEach(el => el.classList.remove('date-invalid'));
            const hint = document.getElementById('dateValidationHint');
            if (hint) {
                hint.classList.remove('visible');
                hint.textContent = '';
            }
            
            // Update preview
            _u();
        }

        // Language toggle function
        function setLang(lang) {
            // Update body data attribute
            document.body.setAttribute('data-lang', lang);
            
            // Update toggle buttons
            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update placeholders based on language
            document.querySelectorAll('[data-placeholder-en]').forEach(el => {
                if (lang === 'dar') {
                    el.placeholder = el.getAttribute('data-placeholder-dar') || el.getAttribute('data-placeholder-en');
                } else {
                    el.placeholder = el.getAttribute('data-placeholder-en');
                }
            });
            
            // Store in sessionStorage (persists during session, clears on close)
            sessionStorage.setItem('dorkSearchLang', lang);
        }

        // Initialize language on page load
        function initLanguage() {
            // Default to 'both' on page refresh (don't persist across refreshes)
            const lang = 'both';
            document.body.setAttribute('data-lang', lang);
            
            // Update toggle buttons
            document.querySelectorAll('.lang-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.trim() === 'BOTH') {
                    btn.classList.add('active');
                }
            });
        }

        // Run reset on page load
        resetAllState();
        initLanguage();
    </script>
</body>
</html>
