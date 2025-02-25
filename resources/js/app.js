import './bootstrap';
import Alpine from 'alpinejs';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() { 
    $('input[name="update_recurrence"]').change(function() {
        if ($('#update_specified_days').is(':checked')) {
            $('#update_daysOfWeek').show();
        } else  {
            $('#update_daysOfWeek').hide();
        }
    });
    $('input[name="recurrence"]').change(function() {
        if ($('#specified_days').is(':checked')) {
            $('#daysOfWeek').show();
        } else  {
            $('#daysOfWeek').hide();
        }
    });

    $('#daysOfWeek input[type="checkbox"]').change(function() {
        if ($('#daysOfWeek input[type="checkbox"]:checked').length === 7) {
            $('#daily').prop('checked', true);
            $('#sunday').prop('checked', false);
            $('#monday').prop('checked', false);
            $('#tuesday').prop('checked', false);
            $('#wednesday').prop('checked', false);
            $('#thursday').prop('checked', false);
            $('#friday').prop('checked', false);
            $('#saturday').prop('checked', false);
            $('#daysOfWeek').hide();
        }
    });
    $('#update_daysOfWeek input[type="checkbox"]').change(function() {
        if ($('#update_daysOfWeek input[type="checkbox"]:checked').length === 7) {
            $('#update_daily').prop('checked', true);
            $('#update_sunday').prop('checked', false);
            $('#update_monday').prop('checked', false);
            $('#update_tuesday').prop('checked', false);
            $('#update_wednesday').prop('checked', false);
            $('#update_thursday').prop('checked', false);
            $('#update_friday').prop('checked', false);
            $('#update_saturday').prop('checked', false);
            $('#update_daysOfWeek').hide();
        }
        
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin ],
        headerToolbar: {
            start: 'prev next today',
            center: 'title',
            end: 'customButton1 customButton2'
        },
        customButtons: {
            customButton1: {
                text: '➕Reminder',
                click: function() {
                    $('#reminderModal').modal('toggle');
                },
            },
            customButton2: {
                text: '➕Event',
                className: 'btn-reminder',
                click: function() {
                    $('#eventsModal').modal('toggle');
                },
            }
        },
        editable: true,
        events: [], 
        eventContent: function(info) {
            if (info.event.extendedProps.type === 'type2') {
                
                let titleEl = document.createElement('div');
                titleEl.innerHTML = info.event._def.title;
                if (info.event.extendedProps.completed) {
                    titleEl.style.textDecoration = 'line-through';
                    titleEl.style.opacity = '0.5';
                }
                return { domNodes: [titleEl] };
            } else {
                let timeEl = document.createElement('div');
                timeEl.innerHTML = info.timeText;
                let titleEl = document.createElement('div');
                titleEl.innerHTML = info.event.title;
                titleEl.style.marginLeft = '5px';
                if(info.event._instance.defId == 219) {
                    titleEl.style.textDecoration = 'line-through';
                    timeEl.style.textDecoration = 'line-through';
                    timeEl.style.opacity = '0.5';
                    titleEl.style.opacity = '0.5';
                    titleEl.style.marginLeft = '0px';
                }
                if (info.event.extendedProps.completed) {
                    titleEl.style.textDecoration = 'line-through';
                    timeEl.style.textDecoration = 'line-through';
                    timeEl.style.opacity = '0.5';
                    titleEl.style.opacity = '0.5';
                    titleEl.style.marginLeft = '0px';
                }
                return { domNodes: [timeEl, titleEl] };
            }
        },
        eventDidMount: function(info) {
            info.el.style.backgroundColor = info.backgroundColor;
            info.el.style.color = 'white'; 
        },
        eventClick: function(info){
            var eventType = info.event.extendedProps.type;
            console.log(info);
            if (eventType === 'type1') {
                $('#reminderModal2').modal('toggle');
                $('#reminderModal2').find('#id_reminder').val(info.event._def.publicId);
                $('#reminderModal2').find('#delete_id_reminder').val(info.event._def.publicId);
                $('#reminderModal2').find('#title').val(info.event.title);
                $('#reminderModal2').find('#color').val(info.event.backgroundColor);
                var d = new Date(info.event.start);
                var months = '' + (d.getMonth() + 1);
                var days = '' + d.getDate();
                var years = d.getFullYear();
                if (months.length < 2) months = '0' + months;
                if (days.length < 2) days = '0' + days;
                $('#reminderModal2').find('#date').val([years, months, days].join('-'));
                var hours = '' + d.getHours();
                var minutes = '' + d.getMinutes();
                if (hours.length < 2) hours = '0' + hours;
                if (minutes.length < 2) minutes = '0' + minutes;
                $('#reminderModal2').find('#time').val([hours, minutes].join(':'));                
                $('#reminderModal2').find('input[name="update_recurrence"][id="update_' + info.event.extendedProps.recurrence + '"]').prop('checked', true);
                if(info.event.extendedProps.recurrence === "specified_days") {
                    $('#update_daysOfWeek').show();
                    var days_of_weeks = JSON.parse(info.event.extendedProps.recurrence_days);
                    days_of_weeks.forEach(el =>  $('#reminderModal2').find('input[name="days[]"][value="' + el + '"]').prop('checked', true),
                    );
                } else {
                    $('#update_daysOfWeek').hide();
                }
                $('#reminderModal2').find('input[name="completed_reminder"]').prop('checked', info.event._def.extendedProps.completed)
            } else {
                $('#eventsModal2').modal('toggle');
                $('#eventsModal2').find('#id_event').val(info.event._def.publicId);
                $('#eventsModal2').find('#title').val(info.event.title);
                $('#eventsModal2').find('#color').val(info.event.backgroundColor);
                var d = new Date(info.event.start);
                var months = '' + (d.getMonth() + 1);
                var days = '' + d.getDate();
                var years = d.getFullYear();
                if (months.length < 2) months = '0' + months;
                if (days.length < 2) days = '0' + days;
                $('#eventsModal2').find('#date_start').val([years, months, days].join('-'));
                var hours = '' + d.getHours();
                var minutes = '' + d.getMinutes();                
                if (hours.length < 2) hours = '0' + hours;
                if (minutes.length < 2) minutes = '0' + minutes;
                $('#eventsModal2').find('#time_start').val([hours, minutes].join(':'));
                var d = new Date(info.event.end);
                var monthe = '' + (d.getMonth() + 1);
                var daye = '' + d.getDate();
                var yeare = d.getFullYear();
                if (monthe.length < 2) monthe = '0' + monthe;
                if (daye.length < 2) daye = '0' + daye;
                $('#eventsModal2').find('#date_end').val([yeare, monthe, daye].join('-'));
                var houre = '' + d.getHours();
                var minutee = '' + d.getMinutes();                
                if (houre.length < 2) houre = '0' + houre;
                if (minutee.length < 2) minutee = '0' + minutee;
                $('#eventsModal2').find('#time_end').val([houre, minutee].join(':'));
                $('#eventsModal2').find('input[name="completed_event"]').prop('checked', info.event._def.extendedProps.completed)   
            }   
            document.querySelector('.delete-button-reminder').addEventListener('click', function() {
                const reminderId = info.event._def.publicId;
                document.getElementById('deleteFormReminder').action = `/event/destroyReminder/${reminderId}`; 
                document.getElementById('deleteFormReminder').submit();
            });
            document.querySelector('.delete-button-event').addEventListener('click', function() {
                const eventId = info.event._def.publicId; 
                document.getElementById('deleteFormEvent').action = `/event/destroyEvent/${eventId}`; 
                document.getElementById('deleteFormEvent').submit();
            });
        }
    });
    
    axios.get('/setevents')
        .then(response => {
            const events = response.data;
            events.forEach(event => {
                calendar.addEvent(event);
            });
            calendar.render(); // Рендер календаря після додавання подій
        })
        .catch(error => {
            console.error('Error fetching events:', error);
            calendar.render();
});
});


