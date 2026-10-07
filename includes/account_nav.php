<?php /* Customer sidebar. Set $acct to the active key before including. */
$items = ['account' => ['account.php', 'Overview and Profile'], 'trips' => ['my-bookings.php', 'My Trips'], 'favs' => ['favorites.php', 'My Favorites'], 'notes' => ['notifications.php', 'Notifications']]; ?>
<nav aria-label="Account" class="md:w-56 shrink-0"><ul class="flex md:block gap-2 overflow-x-auto md:space-y-1 pb-2 md:pb-0">
<?php foreach ($items as $k => [$href, $label]): ?><li class="shrink-0"><a href="<?=$href?>" class="block px-4 py-2 rounded text-sm font-medium whitespace-nowrap <?=($acct ?? '') === $k ? 'bg-forest text-bone' : 'bg-white border border-stone hover:bg-stone'?>" <?=($acct ?? '') === $k ? 'aria-current="page"' : ''?>><?=$label?><?php if ($k === 'notes' && $unread): ?> <span class="ml-1 bg-amber text-ink rounded-full px-2 text-xs font-bold"><?=$unread?></span><?php endif; ?></a></li><?php endforeach; ?>
</ul></nav>
