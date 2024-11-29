// validate_listing.js

function checkListingName(name) {
    $.ajax({
        url: 'check_duplicate_listing.php', // PHP script to check for duplicates
        method: 'POST',
        data: { name: name },
        success: function(response) {
            if (response === 'exists') {
                $('#name-error').text('A listing with this name already exists.').show();
            } else {
                $('#name-error').hide();
            }
        }
    });
}
