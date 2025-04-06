<script>
hidePopUps();

function hidePopUps()
{
    const popups = document.querySelectorAll(".form-popup");
    popups.forEach(popup => {
        popup.style.display = "none";
        });
}

function showCalendar(select)
{
  dateSelect = document.getElementById('dateSelect');

  if (select.options[select.selectedIndex].value == "Specific Date") {
    dateSelect.style.display = 'block';
  }

  else {
    dateSelect.style.display = 'none';
  }
}

window.onload = showCalendar;


// adding hovering to table rows
document.addEventListener("DOMContentLoaded", function()
{
    const tableRows = document.querySelectorAll("tbody tr");
    const popups = document.querySelectorAll("form-popup");
    
    tableRows.forEach(row => {
        row.style.cursor = "context-menu"; // keep the pointer as context-menu even when hovering over text
        
        row.addEventListener("mouseenter", function() {
            this.style.backgroundColor = "lightgray"; // set the bg color to light gray on hover
        });
        
        row.addEventListener("mouseleave", function() {
            this.style.backgroundColor = "";
        });
        
        row.addEventListener("click", function() {
            hidePopUps();
            const rowData = this.children;
            const sessionName = rowData[0].textContent;
            const date = rowData[2].textContent;
            const time = rowData[3].textContent.split(" - ")[0];
            
            // Find and show the corresponding popup
            const popupId = sessionName + date + time;
            const popup = document.getElementById(popupId);
            if (popup) {
                popup.style.display = "block";
            }
        });
    });
});
</script>