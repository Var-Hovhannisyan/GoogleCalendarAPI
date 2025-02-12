import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid'; // Add this line
import timeGridPlugin from '@fullcalendar/timegrid'

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
            meridiem: false
        },
        plugins: [dayGridPlugin, timeGridPlugin],
        headerToolbar: {
            start: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            end: 'prevYear,prev,next,nextYear'
        },
        timeZone: 'UTC',
        eventClick: function (e) {
            const eventId = e.event.id;
            window.location.href = `/events/${eventId}/edit`;
        },
        eventSources: [
            {
                url: '/events',
                failure: function (e) {
                    alert('there was an error while fetching events!');
                },
            }
        ],
        eventDidMount: function (info) {
            if (info.event.extendedProps.color) {
                info.el.style.backgroundColor = info.event.extendedProps.color.background;
            }
        }
    });
    calendar.render();
});

const newEventBtn = document.getElementById('new-event-btn');
newEventBtn.addEventListener('click', function () {
    openModal();
})

function openModal(e) {
    const modal = document.getElementById('new-event');
    // var eventTitle = document.getElementById('event-title-input');
    // eventTitle.value = e.event.title;
    // var eventDescription = document.getElementById('event-description-input');
    // eventDescription.value = e.event.description ?? '';
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('new-event');
    modal.classList.add('hidden');
}
function isValidDate(dateStr) {
    const date = new Date(dateStr);
    return !isNaN(date.getTime()); // Valid if it's a real date
}


document.getElementById('modal-cancel-button').addEventListener('click', closeModal);
