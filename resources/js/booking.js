document.addEventListener("DOMContentLoaded", function () {
    const checkInInput = document.getElementById("checkin");
    const checkOutInput = document.getElementById("checkout");

    // Fetch unavailable dates (excluding canceled bookings)
    fetch("/get-unavailable-dates")
        .then(response => response.json())
        .then(data => {
            let unavailableDates = data.unavailable_dates.map(date => new Date(date).toISOString().split("T")[0]);

            checkInInput.addEventListener("change", function () {
                const selectedDate = checkInInput.value;

                

                // Allow check-out on the same date as previous check-ins
                let availableCheckOutDates = [...unavailableDates];

                // Remove the last day of any previous bookings from unavailable list
                for (let i = 0; i < unavailableDates.length; i++) {
                    let nextDay = new Date(unavailableDates[i]);
                    nextDay.setDate(nextDay.getDate() + 1); // Add one day
                    let formattedNextDay = nextDay.toISOString().split("T")[0];

                    if (!unavailableDates.includes(formattedNextDay)) {
                        availableCheckOutDates.push(formattedNextDay);
                    }
                }

                // Set the min value for check-out date
                checkOutInput.setAttribute("min", selectedDate);

                // Prevent selection of an unavailable check-in date
                if (unavailableDates.includes(selectedDate)) {
                    alert("This date is already booked. Please select another date.");
                    checkInInput.value = "";
                }
            });

            checkOutInput.addEventListener("change", function () {
                const selectedDate = checkOutInput.value;

                // Prevent selection of unavailable check-out dates except those that are check-in dates
                if (unavailableDates.includes(selectedDate) && !unavailableDates.includes(checkInInput.value)) {
                    alert("This date is already booked. Please select another date.");
                    checkOutInput.value = "";
                }

                // Ensure check-out date is after check-in date
                if (new Date(checkOutInput.value) <= new Date(checkInInput.value)) {
                    alert("Check-out date must be after the check-in date.");
                    checkOutInput.value = ""; // Reset invalid input
                }
            });
        })
        .catch(error => console.error("Error fetching unavailable dates:", error));
});
