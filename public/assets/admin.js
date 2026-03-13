
$(function () {
    // ── Sidebar toggle (mobile) ──────────────────────────
    $('#sidebar-toggle').on('click', function () {
        $('#sidebar').toggleClass('-translate-x-full translate-x-0');
        $('#sidebar-overlay').toggleClass('hidden');
    });

    $('#sidebar-overlay').on('click', function () {
        $('#sidebar').addClass('-translate-x-full').removeClass('translate-x-0');
        $(this).addClass('hidden');
    });

    // ── Avatar dropdown ───────────────────────────────────
    $('#avatar-btn').on('click', function (e) {
        e.stopPropagation();
        $('#avatar-dropdown').toggleClass('hidden');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#avatar-btn, #avatar-dropdown').length) {
            $('#avatar-dropdown').addClass('hidden');
        }
    });
});
