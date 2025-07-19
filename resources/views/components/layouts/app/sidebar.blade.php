<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('calendar')" :current="request()->routeIs('calendar*')" wire:navigate>{{ __('Calendar') }}</flux:navlist.item>

                <flux:navlist.item icon="home" :href="route('bookings.index')" :current="request()->routeIs('bookings*')" wire:navigate>{{ __('Reservations') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('guests.index')" :current="request()->routeIs('guests*')" wire:navigate>{{ __('Guests') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('rooms.index')" :current="request()->routeIs('rooms*')" wire:navigate>{{ __('Rooms') }}</flux:navlist.item>

            </flux:navlist>



            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Configure')" class="grid">
                    <flux:navlist.item icon="home" :href="route('room-types.index')" :current="request()->routeIs('room-types*')" wire:navigate>{{ __('Room Types') }}</flux:navlist.item>
                    <flux:navlist.item icon="home" :href="route('sources.index')" :current="request()->routeIs('sources*')" wire:navigate>{{ __('Booking Sources') }}</flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>





            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>

    <script>
        function resizeBar(pivotId, outStr) {
            return {
                /* ----- state ----- */
                pivotId,
                outDate   : new Date(outStr),   // original check-out
                dayPx     : 0,                  // px width of 1 calendar day
                startX    : 0,
                diffDays  : 0,                  // signed day delta while dragging
                rafId     : null,               // requestAnimationFrame id

                /* ----- pointer down ----- */
                begin(ev) {
                    this.startX = ev.clientX;

                    /* measure one-day width once */
                    if (!this.dayPx) {
                        const cellWidth = this.$el.offsetWidth / this.$el.colSpan;
                        this.dayPx      = cellWidth || 112;         // fallback to 112 px
                    }

                    /* keep events even outside handle */
                    ev.target.setPointerCapture(ev.pointerId);

                    /* pointer-move */
                    ev.target.onpointermove = evt => {
                        this.diffDays = Math.round((evt.clientX - this.startX) / this.dayPx);

                        /* ------- rAF paint callback -------- */
                        this.$el.style.setProperty('--ghost-px', this.diffDays * this.dayPx);
                    };

                    /* pointer-up */
                    ev.target.onpointerup = evt => {
                        /* remove listeners */
                        ev.target.onpointermove = null;
                        ev.target.onpointerup   = null;
                        cancelAnimationFrame(this.rafId);

                        /* clear overlay */
                        this.$el.style.removeProperty('--ghost-px');

                        if (!this.diffDays) return;  // no visual change → nothing to save

                        /* compute new check-out */
                        const newOut = new Date(this.outDate);
                        newOut.setDate(newOut.getDate() + this.diffDays);

                        /* Livewire action */
                        this.$wire.updateBookingRoomDates(
                            this.pivotId,
                            newOut.toISOString().slice(0, 10)       // YYYY-MM-DD
                        );
                    };
                }
            };
        }
    </script>

    <style>
        /* --- preview overlay (left or right) --- */
        td[style*="--ghost-px"]{
            position:relative;    /* establish a containing block */
        }

        td[style*="--ghost-px"]::after{
            content:'';
            position:absolute; top:0; bottom:0;
            z-index:1;                       /* over the anchor */
            background:rgba(0,0,0,.15);
            pointer-events:none;

            /* extend or shrink */
            width:calc( var(--ghost-px) * 1px );
            /* grow right when positive, left when negative */
            left: calc(var(--ghost-px) > 0 ? 100% : auto);
            right:calc(var(--ghost-px) < 0 ? 100% : auto);
        }
    </style>
</html>
