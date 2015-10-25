$(document).ready(function(){
    
    $('.acc-title').click(function(){
        p = $(this).closest('.acc-item');
        c = p.find('.acc-content');
        if(c.css('display') == 'none')
        {
            $(this).closest('.acc').find('.acc-content').slideUp(500);
            c.slideDown(500);
        }
    });
    
    var fileName;
    
    $('#News_image').change(function() {
        if(fileName == this.value) {
            $('#image-error').show();
        }
        fileName = this.value;
    });
    
    $('#link-change').bind('click', function() {
        $('#image-is-miss').hide();
        $('#link-change').hide();
        $('#form-block').show();
        $('#link-cancel').show();
    });

    $('#link-cancel').bind('click', function() {
        $('#image-field').val('');
        $('#News_image').val('');
        $('#image-error').hide();
        $('#form-block').hide();
        $('#link-cancel').hide();
        $('#image-is-miss').show();
        $('#link-change').show();
    });
    
    $('.add-btn').click(function(e){
        e.preventDefault();
        $('#addForm').attr('action', $(this).attr('href'));
        $('#addTitle').text('"' + $(this).closest('tr').find('.item-title').text() + '"');
        $('#addModal').modal('show');
        return false;
    });
});

function onPictureDelete()
{
    $('#create-pages-form').off();
}