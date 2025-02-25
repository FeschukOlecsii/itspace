<div class="modal fade" id="reminderModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('event.updateReminder') }}">
                    @csrf
                    @method('PUT')
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
                        <input type="radio" id="update_once" name="update_recurrence" value="Once">
                        <label for="update_once">Once</label><br>
                        <input type="radio" id="update_daily" name="update_recurrence" value="Daily">
                        <label for="update_daily">Daily</label><br>
                        <input type="radio" id="update_specified_days" name="update_recurrence" value="Specified days">
                        <label for="update_specified_days">Specified days</label><br>
                        <div id="update_daysOfWeek" class="mt-1 ms-3" style="display: none;">
                            <input type="checkbox" id="update_monday" name="days[]" value="Monday">
                            <label for="update_monday">Monday</label><br>
                            <input type="checkbox" id="update_tuesday" name="days[]" value="Tuesday">
                            <label for="update_tuesday">Tuesday</label><br>
                            <input type="checkbox" id="update_wednesday" name="days[]" value="Wednesday">
                            <label for="update_wednesday">Wednesday</label><br>
                            <input type="checkbox" id="update_thursday" name="days[]" value="Thursday">
                            <label for="update_thursday">Thursday</label><br>
                            <input type="checkbox" id="update_friday" name="days[]" value="Friday">
                            <label for="update_friday">Friday</label><br>
                            <input type="checkbox" id="update_saturday" name="days[]" value="Saturday">
                            <label for="update_saturday">Saturday</label><br>
                            <input type="checkbox" id="update_sunday" name="days[]" value="Sunday">
                            <label for="update_sunday">Sunday</label><br>
                        </div>
                        <input type="radio" id="update_monthly" name="update_recurrence" value="Monthly">
                        <label for="update_monthly">Monthly</label><br>
                        <input type="radio" id="update_yearly" name="update_recurrence" value="Yearly">
                        <label for="update_yearly">Yearly</label><br>
                        <input type="hidden" id="type" value="type1" name="type">
                        <input type="hidden" id="id_reminder" value="1" name="id"> 
                        <x-input-error :messages="$errors->get('Recurrence')" class="mt-2" />
                        <input type="checkbox" name="completed_reminder" id="completed_reminder">
                        <label for="completed_reminder">Completed</label>
                    </div>

                    <button type="submit" class="btn btn-primary mb-1 mt-3">Update reminder</button><br>
                    <button type="button" class="btn btn-secondary mb-1" data-bs-dismiss="modal">Close</button>
                </form>
                
                <form method="POST" id="deleteFormReminder">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-button-reminder">Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>