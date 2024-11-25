$(document).ready(function () {
    const slotsTable = $("#available-slots tbody");

    // Show loading spinner while fetching slots
    slotsTable.html("<tr><td colspan='3'>Loading available slots...</td></tr>");

    // Fetch available slots for property valuation
    $.getJSON("../actions/get_slots.php?table=property_valuation_slots", function (data) {
        slotsTable.empty(); // Clear previous rows

        if (data.length > 0) {
            data.forEach(slot => {
                let actionButton;

                // Determine the action button based on the slot status
                if (slot.status === "available") {
                    actionButton = `<button onclick="bookSlot(${slot.id})" class="book-btn">Book</button>`;
                } else if (slot.status === "booked") {
                    actionButton = `<button onclick="cancelSlot(${slot.id})" class="cancel-btn">Cancel</button>`;
                }

                slotsTable.append(`
                    <tr>
                        <td>${slot.date}</td>
                        <td>${slot.time}</td>
                        <td>${actionButton}</td>
                    </tr>
                `);
            });
        } else {
            slotsTable.append("<tr><td colspan='3'>No slots available</td></tr>");
        }
    }).fail(function () {
        slotsTable.html("<tr><td colspan='3'>Error loading slots. Please try again.</td></tr>");
    });

    // Book a slot
    window.bookSlot = function (slotId) {
        const userId = 1; // Replace with session user ID if logged in

        $.post("../actions/book_slot.php", { 
            slot_id: slotId, 
            user_id: userId, 
            table: 'property_valuation_slots' 
        }, function (response) {
            alert(response);
            location.reload(); // Refresh the page to show updated slots
        }).fail(function () {
            alert("Error booking slot. Please try again.");
        });
    };

    // Cancel a slot
    window.cancelSlot = function (slotId) {
        const userId = 1; // Replace with session user ID if logged in

        $.post("../actions/cancel_slot.php", { 
            slot_id: slotId, 
            user_id: userId, 
            table: 'property_valuation_slots' 
        }, function (response) {
            alert(response);
            location.reload(); // Refresh the page to show updated slots
        }).fail(function () {
            alert("Error canceling slot. Please try again.");
        });
    };
});
