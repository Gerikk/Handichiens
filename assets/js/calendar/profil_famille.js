import { Calendar } from "@fullcalendar/core";
import frLocale from '@fullcalendar/core/locales/fr';
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";

import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

import "./index.css";

//if(familleId){

document.addEventListener("DOMContentLoaded", () => {

    let calendarEl = document.getElementById("calendar-holder");

    let eventsUrl = calendarEl.dataset.eventsUrl;

    let calendar = new Calendar(calendarEl, {
        locale: frLocale,
        nowIndicator: true,
        defaultView: "dayGridMonth",
        editable: false,
        weekNumberCalculation: 'ISO',
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Friday
            forceEventDuration: true,
            startTime: '8:00', // a start time (8am in this example)
            endTime: '18:00', // an end time (6pm in this example)
        },
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({ "calendar-id": "profil-famille-calendar", "famille_id": familleId }),
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek",
        },
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin], // https://fullcalendar.io/docs/plugin-index
        timeZone: "UTC",
    });

    calendar.render();


});
