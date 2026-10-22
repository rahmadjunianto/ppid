<script>
(function() {
    var linkType = document.getElementById('link_type');
    var fieldFile = document.getElementById('field-file');
    var fieldLink = document.getElementById('field-link');

    if (!linkType || !fieldFile || !fieldLink) {
        return;
    }

    function toggle() {
        if (linkType.value === 'link') {
            fieldFile.classList.add('d-none');
            fieldLink.classList.remove('d-none');
        } else {
            fieldFile.classList.remove('d-none');
            fieldLink.classList.add('d-none');
        }
    }

    linkType.addEventListener('change', toggle);
    toggle();
})();
</script>
