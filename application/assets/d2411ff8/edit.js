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
    
    $('.ajax-btn').click(function(event) {
        event.preventDefault();

        var alias = $('#Contents_alias').val();
        if(!alias)
        {
            $('#Contents_alias').next(".form-error").html("Поле обязательно для заполнения");
            return false;
        }
        
        var page_id = $('#Pages_id').val();
        
        $.ajax({
            type  : "POST",
            url   : '/admin/pages/default/addContent',
            data  : {
                YII_CSRF_TOKEN : globalCsrfToken,
                page_id : page_id,
                alias : $('#Contents_alias').val(),
                text : CKEDITOR.instances.ContentsLang_text.getData(),
            },
            cashe : false,
            error : function () {
                alert('Ошибка запроса. Обновите страницу и попробуйте ещё разз.');
            },
            dataType : 'json',
            success : function(object) {

                if(!jQuery.isEmptyObject(object)) 
                {
                    $(".form-error").html("");
                    $.each(object, function(arrayID,el) {
                        $("#"+arrayID).next(".form-error").html(el[0]);
                    });
                }
                else 
                {
                    location.href = '/admin/pages/default/edit/id/'+page_id;
                }
            },
        });
    });

    
});

function onPictureDelete()
{
    $('#create-pages-form').off();
}

function onDeleteContent()
{
    $('#create-pages-form').off();
}