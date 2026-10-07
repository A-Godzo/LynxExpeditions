<?php /* Shared <head>: fonts, Tailwind (play CDN) with the Lynx palette. Expects $title. */ ?>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=e($title ?? 'Lynx Expeditions')?> | Lynx Expeditions</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{forest:'#17352B',ink:'#111513',bone:'#F4F1E8',stone:'#D9D2C3',amber:'#C99A4A'},fontFamily:{display:['"Barlow Condensed"','Impact','sans-serif'],sans:['"Public Sans"','system-ui','sans-serif']}}}}</script>
<link rel="stylesheet" href="<?=ROOT?>assets/style.css">
