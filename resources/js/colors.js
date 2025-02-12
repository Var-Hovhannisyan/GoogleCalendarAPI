document.addEventListener("DOMContentLoaded", function () {
    fetch('/colors')
        .then(response => response.json())
        .then(colors => {

            select.innerHTML = ""; // Clear existing options
            colors.forEach(color => {
                let option = document.createElement("option");
                option.value = color.id;
                option.textContent = color.name;
                option.style.backgroundColor = color.background;
                select.appendChild(option);
            });

        })
        .catch(error => console.error("Error fetching colors:", error.message));
});

const select = document.querySelector("#colors-select");
select.addEventListener("change", function () {
    const selectedOption = select.options[select.selectedIndex];
    const selectedColor = selectedOption.style.backgroundColor;
    select.style.backgroundColor = selectedColor; // Update select input background
});
