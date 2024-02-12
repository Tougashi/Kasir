<script>
    function changeToEdit(event){
        event.preventDefault();
        $('form input, form textarea').attr('readonly', false);
        $('form select').removeAttr('disabled');
        $('#submitBtn').attr('onclick', 'info("Mohon tunggu sebentar ...")');
        $('#submitBtn').text('Simpan');
    }
</script>
