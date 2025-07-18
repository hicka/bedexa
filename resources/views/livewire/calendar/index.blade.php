<div>

    <x-page-heading title="Reservations"/>

    {{-- Legend --}}
    <div class="flex gap-4 mb-4 text-sm">
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-yellow-400"></span> Reserved</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-green-500"></span> Checked-in/out</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-500"></span> Occupied</span>
    </div>

    {{-- Grid wrapper allows horizontal scroll --}}
    <div class="overflow-x-auto">
        <table class="border-collapse min-w-[900px]">
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
                            $date          = $dates[$idx];
                            $roomBookings  = $bookings[$room->id] ?? collect();
                            $booking       = $roomBookings->first(fn ($b) =>
                                                $date->between($b->check_in, $b->check_out->subDay()));
                        @endphp

                        {{-- ─── Empty cell ───────────────────────────────────────── --}}
                        @if (!$booking)
                            <td  class="w-28 h-12 border-r border-dashed cursor-pointer
                    hover:bg-sky-50 dark:hover:bg-slate-800"
                                 @click="$dispatch('openQuickBooking', { roomId: {{ $room->id }}, date: '{{ $date->toDateString() }}' })">
                            </td>
                            @continue
                        @endif


                        {{-- ─── Booking START cell → render <td colspan="nights"> ───── --}}
                        @if ($date->isSameDay($booking->check_in))
                            @php
                                // how many cells remain in the month?
                                $remaining = $dateCount - $idx;
                                $span      = min($booking->nights, $remaining);

                                $colors = [
                                    'reserved'    => ['bg' => 'bg-amber-300 text-amber-900', 'bar'=>'bg-amber-500'],
                                    'checked_in'  => ['bg' => 'bg-green-200 text-green-900', 'bar'=>'bg-green-500'],
                                    'checked_out' => ['bg' => 'bg-green-200 text-green-900', 'bar'=>'bg-green-500'],
                                    'occupied'    => ['bg' => 'bg-blue-200  text-blue-900',  'bar'=>'bg-blue-500' ],
                                ];
                                $c = $colors[$booking->booking->status] ?? ['bg'=>'bg-slate-200 text-gray-800', 'bar'=>'bg-slate-500'];

                                $names = $booking->booking->guests->pluck('full_name');
                                $label = $names->first() . ($names->count() > 1 ? ' +' . ($names->count()-1) : '');
                            @endphp

                            <td  colspan="{{ $span }}"
                                 class="relative h-12 border-r border-dashed p-0">

                                <a href="{{ route('bookings.edit', $booking->booking) }}"
                                   class="flex items-center h-full pr-3 text-xs whitespace-nowrap
                      overflow-hidden {{ $c['bg'] }} {{ $c['text'] ?? '' }} rounded-r-md">

                                    <span class="h-full w-1.5 mr-2 {{ $c['bar'] }} rounded-l-md"></span>

                                    {{-- guest label --}}
                                    <span class="truncate leading-snug">
                    <strong>{{ $label }}</strong><br>
                    <span class="opacity-70 text-[10px]">
                        {{ ucfirst($booking->booking->source->name ?? 'Direct') }}
                    </span>
                </span>

                                    {{-- payment badge --}}
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

                            @php
                                // skip the cells we just spanned
                                $idx += $span - 1;
                            @endphp
                        @endif
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <livewire:booking.quick-create wire:key="quick-booking" />
</div>
