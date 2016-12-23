$(document).ready(function() {
    $(".dropdown-menu").on('click', 'li a', function() {});

    $('#myModal').on('hidden.bs.modal', function() {
        $(this).removeData('bs.modal');
    });
    
});
