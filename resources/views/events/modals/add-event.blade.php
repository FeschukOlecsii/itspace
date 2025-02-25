<div class="modal fade" id="eventsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('event.addEvent') }}">
                        @csrf
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="color" :value="__('Color')" />
                            <select id="color" name="color" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="red">Red</option>
                                <option value="green">Green</option>
                                <option value="blue">Blue</option>
                                <option value="black">Black</option>
                                <option value="orange">Orange</option>
                            </select>
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date_start" :value="__('Date start')" />
                            <x-text-input id="date_start" class="block mt-1 w-full"
                                type="date"
                                name="date_start"
                                min="<?php echo date('Y-m-d'); ?>"

                                required />
                            <x-input-error :messages="$errors->get('date_start')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="time_start" :value="__('Time start')" />
                            <x-text-input id="time_start" class="block mt-1 w-full"
                                type="time"
                                name="time_start"
                                min="00:00"
                                max="23:59"
                                required />
                            <x-input-error :messages="$errors->get('time_start')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="date_end" :value="__('Date end')" />
                            <x-text-input id="date_end" class="block mt-1 w-full"
                                type="date"
                                name="date_end"
                                min="<?php echo date('Y-m-d'); ?>"

                                required />
                            <x-input-error :messages="$errors->get('date_end')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="time_end" :value="__('Time end')" />
                            <x-text-input id="time_end" class="block mt-1 w-full"
                                type="time"
                                name="time_end"
                                min="00:00"
                                max="23:59"
                                required />
                            <x-input-error :messages="$errors->get('time_end')" class="mt-2" />
 
                        </div>
                        <input type="hidden" id="type" value="type2" name="type">

                        <button type="submit" class="btn btn-primary mb-1 mt-3">Add event</button><br>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>