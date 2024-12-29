<template>
    <svg viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#4f46e5;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#6366f1;stop-opacity:1" />
            </linearGradient>
        </defs>
        <g>
            <path d="M15,25 L25,15 L35,15 L45,25 L35,35 L25,35 Z" fill="url(#grad)" />
            <circle cx="30" cy="25" r="6" fill="white"/>
            <path d="M27,25 L29,27 L33,23" stroke="#4f46e5" stroke-width="2" fill="none"/>
        </g>
        <text x="55" y="35" font-family="SF Pro Display, Arial, sans-serif" font-weight="700" font-size="24">
            <tspan fill="#1f2937">TASK</tspan>
            <tspan fill="#4f46e5">FORGE</tspan>
        </text>
    </svg>
</template>

