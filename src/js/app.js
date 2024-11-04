$(document).ready(function() {
    // Event delegation for delete and edit buttons
    $(document).on('click', 'button[name="btn-edit-county"]', function(e) {
        e.preventDefault();
        // Handle edit logic here
        const countyId = $(this).val();
        // Perform an AJAX request or show the edit form
        console.log("Edit county with ID:", countyId);
    });

    $(document).on('click', 'button[name="btn-del-county"]', function(e) {
        e.preventDefault();
        // Handle delete logic here
        const countyId = $(this).val();
        // Perform an AJAX request to delete the county
        console.log("Delete county with ID:", countyId);
    });

    // Show the editor for adding a new county
    $('#btn-add').click(function() {
        $('#editor').toggle(); // Show or hide the editor
    });
});