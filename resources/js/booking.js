document.addEventListener("DOMContentLoaded", function () {
    const checkInInput = document.getElementById('checkin');
    const checkOutInput = document.getElementById('checkout');

    // Fetch unavailable dates (excluding canceled bookings)
    fetch("/get-unavailable-dates")
        .then(response => response.json())
        .then(data => {
            let unavailableDates = data.unavailable_dates.map(date => new Date(date).toISOString().split("T")[0]);

            checkInInput.addEventListener("change", function () {
                const selectedDate = checkInInput.value;

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

                // Prevent selection of an unavailable check-out date
                if (unavailableDates.includes(selectedDate)) {
                    alert("This date is already booked. Please select another date.");
                    checkOutInput.value = "";
                }
            });
        })
        .catch(error => console.error("Error fetching unavailable dates:", error));
});
   // ✅ Add this part to prevent check-out from being before check-in
   checkOutInput.addEventListener("input", function () {
    if (new Date(checkOutInput.value) <= new Date(checkInInput.value)) {
        alert("Check-out date must be after the check-in date.");
        checkOutInput.value = ""; // Reset invalid input
    }

});