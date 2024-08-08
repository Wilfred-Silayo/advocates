$(document).ready(function() {
    const currentPath = window.location.pathname;

    if (currentPath.includes('/login')) {
        $('#loginOffcanvas').offcanvas('show');
    } else if (currentPath.includes('/register')) {
        $('#registerOffcanvas').offcanvas('show');
    }

    $('#chatBubbleContainer .btn-close').click(function() {
        $('#chatBubbleContainer').hide();
    });
    
});
