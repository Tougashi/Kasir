<script>
    function changeToEdit(event){
        event.preventDefault();
        $('form input, form textarea, form select').attr('readonly', false);
        $('#submitBtn').attr('onclick', 'info("Mohon tunggu sebentar ...")');
        $('#submitBtn').text('Simpan');
    }
</script>
