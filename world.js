document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');
    const city =  document.getElementById('lookupcities');

    lookupButton.addEventListener('click', () => {
        const country = countryInput.value.trim();

        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        
        // If the input is empty, request all countries
        if (country) {
            xhr.open('GET', `world.php?country=${encodeURIComponent(country)}`, true);
        } else {
            xhr.open('GET', `world.php`, true); // Request all countries
        }

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Insert the response data into the result div
                resultDiv.innerHTML = xhr.responseText;
            } else {
                resultDiv.innerHTML = 'Error fetching data.';
            }
        };

        xhr.onerror = function() {
            resultDiv.innerHTML = 'Request failed.';
        };

        xhr.send(); // Send the request
    });

    


});