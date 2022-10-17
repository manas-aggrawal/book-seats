<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Display Seats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session()->has('message'))
                        <div class="alert alert-success" style="color: red;">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div>
                        <form action="{{ route('select.seats') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="number" name="num_of_seats_req">
                            <button type="submit">Book</button>
                        </form>
                    </div>

                    <div>
                        <?php
                        $count = 0;
                        foreach ($seats as $seat) {
                            ++$count;
                            if($count > 7){
                                ?><br><?php
                                $count = 1;
                            }
                    ?>
                        <button
                            @if ($seat['status'] == 1) style="color: green;"
                            
                        @else
                            style="color: red;" @endif
                            width="10px" value="{{ $seat['seat_id'] }}" disabled>{{ $seat['seat_id'] }}</button>

                        <?php
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
