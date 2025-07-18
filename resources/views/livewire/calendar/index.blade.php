


<div>

    <x-page-heading title="Reservations"/>

    {{-- ─── Calendar Navigation ─────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-6">

        {{-- Prev / Next buttons --}}
        <div class="flex items-center gap-2">
            <x-button size="sm" variant="ghost"  wire:click="prevMonth">« Prev</x-button>
            <x-button size="sm" variant="ghost"  wire:click="nextMonth">Next »</x-button>
        </div>

        {{-- Current month label --}}
        <h2 class="text-lg font-semibold">
            {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->isoFormat('MMMM YYYY') }}
        </h2>

        {{-- Month picker --}}
        <input  type="month"
                value="{{ $month }}"
                class="border rounded px-2 py-1 text-sm dark:bg-slate-900 dark:border-slate-600"
                wire:change="gotoMonth($event.target.value)">
    </div>

    {{-- Legend --}}
    <div class="flex gap-4 mb-4 text-sm">
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-yellow-400"></span> Reserved</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-green-500"></span> Checked-in/out</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-500"></span> Occupied</span>
    </div>

    {{-- Grid wrapper allows horizontal scroll --}}
    <div x-data
         @keydown.window.arrow-left="$wire.prevMonth()"
         @keydown.window.arrow-right="$wire.nextMonth()"
         class="overflow-x-auto" >
        <table wire:key="calendar-{{ $month }}" class="border-collapse min-w-[900px]">
            <thead class="sticky top-0 bg-white dark:bg-slate-900 z-10">
            <tr>
                <th class="w-36 border-r"></th>
                @foreach ($dates as $d)
                    <th class="w-28 text-xs py-2 border-r text-center">
                        {{ $d->format('d') }}<br><span class="text-gray-500">{{ $d->format('D') }}</span>
                    </th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @php $currentType = null; @endphp
            @foreach ($rooms as $room)
                {{-- Room type heading row --}}
                @if ($currentType !== $room->room_type_id)
                    <tr><td colspan="{{ $dates->count()+1 }}" class="bg-slate-100 dark:bg-slate-800 font-semibold px-2">
                            {{ $room->type->name }}
                        </td></tr>
                    @php $currentType = $room->room_type_id; @endphp
                @endif

                {{-- Room row --}}
                <tr class="border-b">
                    {{-- Left label col --}}
                    <td class="w-36 px-2 py-1 border-r text-sm">{{ $room->room_number }}</td>

                    {{-- Date cells --}}
                    @php
                        $dateCount = $dates->count();
                    @endphp

                    @for ($idx = 0; $idx < $dateCount; $idx++)
                        @php
                            $date         = $dates[$idx];
                            $roomBookings = $bookings->get((string) $room->id, collect());
                            $booking      = $roomBookings->first(fn ($b) =>
                                $date->between($b->check_in, $b->check_out->copy()->subDay())
                            );
                        @endphp

                        {{-- Empty cell ------------------------------------------------- --}}
                        @if (!$booking)
                            <td wire:key="cell-{{ $room->id }}-{{ $date->toDateString() }}"
                                class="w-28 h-12 border-r border-dashed cursor-pointer
                   hover:bg-sky-50 dark:hover:bg-slate-800"
                                @click="$dispatch('openQuickBooking', { roomId: {{ $room->id }}, date: '{{ $date->toDateString() }}' })">
                            </td>
                            @continue
                        @endif

                        {{-- Booking START cell (render the bar) ------------------------ --}}
                        @if ($date->isSameDay($booking->check_in))
                            @php
                                $remaining = $dateCount - $idx;
                                $span      = min($booking->nights, $remaining);
                                $colors    = [
                                    'reserved'   => ['bg'=>'bg-amber-300','bar'=>'bg-amber-500','text'=>'text-amber-900'],
                                    'checked_in' => ['bg'=>'bg-green-200','bar'=>'bg-green-500','text'=>'text-green-900'],
                                    'checked_out'=> ['bg'=>'bg-green-200','bar'=>'bg-green-500','text'=>'text-green-900'],
                                    'occupied'   => ['bg'=>'bg-blue-200' ,'bar'=>'bg-blue-500' ,'text'=>'text-blue-900'],
                                ];
                                $c = $colors[$booking->booking->status] ?? ['bg'=>'bg-slate-200','bar'=>'bg-slate-500','text'=>'text-gray-800'];
                                $names = $booking->booking->guests->pluck('full_name');
                                $label = $names->first() . ($names->count() > 1 ? ' +' . ($names->count()-1) : '');
                            @endphp

                            <td  wire:key="bar-{{ $booking->id }}"
                                 colspan="{{ $span }}"
                                 class="relative h-12 border-r border-dashed p-0">

                                <a href="{{ route('bookings.edit', $booking->booking) }}"
                                   class="flex items-center h-full pr-3 text-xs whitespace-nowrap overflow-hidden
                      {{ $c['bg'] }} {{ $c['text'] }} rounded-r-md">

                                    <span class="h-full w-1.5 mr-2 {{ $c['bar'] }} rounded-l-md"></span>

                                    <span class="truncate leading-snug">
                    <strong>{{ $label }}</strong><br>
                    <span class="opacity-70 text-[10px]">
                        {{ ucfirst($booking->booking->source->name ?? 'Direct') }}
                    </span>
                </span>

                                    <span class="ml-auto px-1 py-0.5 rounded text-[10px] font-medium
                             @class([
                                 'bg-green-600 text-white'  => $booking->payment_state === 'paid',
                                 'bg-pink-600  text-white'  => $booking->payment_state === 'part-paid',
                                 'bg-orange-600 text-white' => $booking->payment_state === 'unpaid',
                             ])">
                    {{ $booking->payment_state === 'part-paid' ? 'Part-paid' : ucfirst($booking->payment_state) }}
                </span>
                                </a>
                            </td>
                        @else
                            {{-- Inside an existing booking bar – render invisible placeholder --}}
                            <td wire:key="pad-{{ $room->id }}-{{ $date->toDateString() }}"
                                class="w-28 h-12 border-r border-dashed"></td>
                        @endif
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <livewire:booking.quick-create wire:key="quick-booking" />
</div>
