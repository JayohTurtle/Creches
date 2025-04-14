document.addEventListener('DOMContentLoaded', function () {
    const calendar = new FullCalendar.Calendar(document.getElementById('day-agenda'), {
        initialView: 'listDay',
        locale: 'fr',
        events: 'index.php?action=getEvents',
        headerToolbar: false,
        height: 'auto',
        dayMaxEvents: true
    })
    calendar.render()
})

function ouvrirPopup(id) {
    document.getElementById(id).style.display = "block"
}

function fermerPopup(id) {
    document.getElementById(id).style.display = "none"
}

document.getElementById('eventForm').addEventListener('submit', function (e) {
    e.preventDefault()

    const form = e.target
    const data = {
        user_id: form.user_id.value,
        title: form.title.value,
        description: form.description.value,
        location: form.location.value,
        start: form.start.value,
        end: form.end.value,
        allDay: form.allDay.checked ? 1 : 0
    }

    fetch('index.php?action=addEvent', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert("Événement ajouté !")
            form.reset()
            fermerPopup('popupAjoutEvenement')
            location.reload() // Ou : calendar.refetchEvents()
        } else {
            alert("Erreur lors de l'ajout.")
        }
    })
})