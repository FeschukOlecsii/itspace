<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('event.addReminder') }}">
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
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full"
                                type="date"
                                name="date"
                                min="<?php echo date('Y-m-d'); ?>"

                                required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Time')" />
                            <x-text-input id="time" class="block mt-1 w-full"
                                type="time"
                                name="time"
                                min="00:00"
                                max="23:59"
                                required />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>

                        <div class="mt-4 ">
                            <x-input-label :value="__('Recurrence')" />
                            <input type="radio" id="once" name="recurrence" value="Once">
                            <label for="once">Once</label><br>
                            <input type="radio" id="daily" name="recurrence" value="Daily">
                            <label for="daily">Daily</label><br>
                            <input type="radio" id="specified_days" name="recurrence" value="Specified days">
                            <label for="specified_days">Specified days</label><br>
                            <div id="daysOfWeek" class="mt-1 ms-3" style="display: none;">
                                <input type="checkbox" id="monday" name="days[]" value="Monday">
                                <label for="monday">Monday</label><br>
                                <input type="checkbox" id="tuesday" name="days[]" value="Tuesday">
                                <label for="tuesday">Tuesday</label><br>
                                <input type="checkbox" id="wednesday" name="days[]" value="Wednesday">
                                <label for="wednesday">Wednesday</label><br>
                                <input type="checkbox" id="thursday" name="days[]" value="Thursday">
                                <label for="thursday">Thursday</label><br>
                                <input type="checkbox" id="friday" name="days[]" value="Friday">
                                <label for="friday">Friday</label><br>
                                <input type="checkbox" id="saturday" name="days[]" value="Saturday">
                                <label for="saturday">Saturday</label><br>
                                <input type="checkbox" id="sunday" name="days[]" value="Sunday">
                                <label for="sunday">Sunday</label><br>
                            </div>
                            <input type="radio" id="monthly" name="recurrence" value="Monthly">
                            <label for="monthly">Monthly</label><br>
                            <input type="radio" id="yearly" name="recurrence" value="Yearly">
                            <label for="yearly">Yearly</label><br>
                            <input type="hidden" id="type" value="type1" name="type">
                            
                            <x-input-error :messages="$errors->get('Recurrence')" class="mt-2" />
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 mb-1">Add reminder</button><br>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>