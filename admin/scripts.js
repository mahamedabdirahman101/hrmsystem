// This JavaScript code should be placed in a separate .js file (e.g., script.js)
// and then linked to your HTML file using the <script> tag.

document.addEventListener('DOMContentLoaded', function() { // Wait for the DOM to load
    const viewButton = document.getElementById('viewButton');
  
    if (viewButton) { // Check if the button exists on the page
      viewButton.addEventListener('click', function(event) {
        event.preventDefault();
  
        window.open('', '_blank');
  
        // Optional: Add content to the new page
        /*
        const newWindow = window.open('', '_blank');
        newWindow.document.write("<h1>New Page Content</h1>");
        newWindow.document.close();
        */
      });
    } else {
      console.error("View button not found. Check the element's ID.");
    }
  });
  