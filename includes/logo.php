<?php /* Lynx mark: simplified lynx head whose forehead notch reads as a mountain. Uses currentColor. */
function logo_mark(string $cls = 'h-8 w-8'): string {
  return '<svg class="' . $cls . '" viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M6 1l7 10 3-3 3 3 7-10 2 15 4 4-6 3-10 8-10-8-6-3 4-4z"/><path fill="var(--logo-eye,#17352B)" d="M9 17l4 1-1.5 2.5zM23 17l-4 1 1.5 2.5zM14.5 24h3L16 26z"/></svg>';
}
function logo_full(string $cls = ''): string { return '<span class="inline-flex items-center gap-2 ' . $cls . '">' . logo_mark() . '<span class="font-display text-2xl font-bold tracking-wide leading-none">LYNX <span class="font-semibold opacity-80">EXPEDITIONS</span></span></span>'; }
