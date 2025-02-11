import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';  // Add this line

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        plugins: [dayGridPlugin],
        eventClick: function (e) {
            // openModal(e);
        },
        eventSources: [
            {
                url: '/events',
                method: 'GET',
                editable: true,
                success: function () {
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
            }
        ]

    });
    calendar.render();
});

var newEventBtn = document.getElementById('new-event-btn');
newEventBtn.addEventListener('click', function () {
    openModal();
})

function openModal(e) {
    var modal = document.getElementById('exampleModal');
    // var eventTitle = document.getElementById('event-title-input');
    // eventTitle.value = e.event.title;
    // var eventDescription = document.getElementById('event-description-input');
    // eventDescription.value = e.event.description ?? '';
    modal.classList.remove('hidden');
}

// Example to close the modal
function closeModal() {
    var modal = document.getElementById('exampleModal');
    modal.classList.add('hidden');
}

document.getElementById('modal-cancel-button').addEventListener('click', closeModal);
