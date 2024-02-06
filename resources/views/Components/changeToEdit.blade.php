<script>
    $().ready(function(){
        $('form input, form textarea').attr('readonly', true);
        $('form select').attr('disabled', true);
    });

    function changeToEdit(event){
        event.preventDefault();
        $('form input, form textarea').attr('readonly', false);
        $('form select').attr('disabled', false);
        $('#submitButton').removeAttr('onclick');
        $('#submitButton').text('Simpan');

    }
</script>
