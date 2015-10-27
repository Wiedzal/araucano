const ALL_TYPES = -1;

function saveFilter()
{
    $.ajax({
        url	: app.createAbsoluteUrl('admin/translate/Ajaxdefault/saveFilter'),
        error	: function ()
        {
            alert(T('Ошибка запроса'));
        },
        success	: function(data)
        {   
            location.href = '/' + app.langUri + '/admin/translate/default/index/subsession/' + data.subsession;
        },
        data	:
        {
            YII_CSRF_TOKEN      : app.csrfToken,
            alias               : 'admin_translate_default',
            form                : $('form#filterform').serializeArray()
        },
        async		: false,
        cache		: false
    });
}

function editTranslate(id)
{
    $('h4.alert_error').remove();
    $('h4.alert_success').remove();
    $('div#original-text').html($('td#orig-text-table-' + id).html());
    $('div#original-context').html($('td#orig-context-table-' + id).html());
    $('input#text_id').val(id);
    
    
    $.each($('span.translate-text'), function(){
        if ($(this).attr('translateId') == id)
        {
            $('textarea#translate-form-' + $(this).attr('langalias')).val($(this).html());
        }
    });                        
    
    $('#form_translate').dialog({
        'title'  : T('Перевод'),
        'width' : 900,
        'height' : 700,
        'buttons': [{
            text    : T('Сохранить'),
            'id'    : 'btnOk',
            click   : function() {
                saveForm();
                $(this).dialog( "close" );
            }}, {
            text    : T('Отмена'),
            'id'    : 'Cancel',
            click   : function() {
                $( this ).dialog( "close" );
            },
        }]            
    });
}

function saveForm()
{
    $('form#translate-from').ajaxSubmit(
        {
            error   : function(){
                showAjaxMessage(T('Ошибка сохранения. Обновите страницу и попробуйте ещё раз'), 'error');
            },
            success : function(json){
                if ((json.result != undefined) && (json.result == true))
                {
                    showAjaxMessage(T('Перевод сохранен'), 'success');
                    if (json.texts != undefined)
                    {
                        $.each(json.texts, function(index, value){
                            if (value == '')
                            {
                                var html = '<span class="no-translate"></span><span id="translate-text-' + $('input#text_id').val() + '_' + index + '" langalias=' + index + ' translateId = ' + $('input#text_id').val() + ' class="translate-text"></span>'
                            }
                            else
                            {
                                var html = '<span class="translate"></span><span id="translate-text-' + $('input#text_id').val() + '_' + index + '" langalias=' + index + ' translateId = ' + $('input#text_id').val() + ' class="translate-text">' + value + '</span>'
                            }
                            
                            $('td#orig-switch-table-' + $('input#text_id').val() + '-' + index).html(html);
                        });                         
                    }
                }
            }
        }
    );    
}

function showAjaxMessage(text, type)
{
    var html = '<h4 class="alert_' + type + '">' + text + '</h4>';
    $('div.content_header').first().after(html);
    scroll(0, 0);
}
function switchLang(object, alias)
{
    if ($(object).is(':checked'))
    {
        $('th.table-lang-' + alias).show();
        $('td.table-lang-' + alias).show();
    }
    else
    {
        $('th.table-lang-' + alias).hide();
        $('td.table-lang-' + alias).hide();
    }    
}

function fliterSwitchAll()
{
    $('input.filter-switch-checkbox').attr('checked', 'checked');
    $('th.table-context').show();
    $('td.table-context').show(); 
    $('th.table-lang').show();
    $('td.table-lang').show();    
}

function fliterSwitchNone()
{
    $('input.filter-switch-checkbox').removeAttr('checked');
    $('th.table-context').hide();
    $('td.table-context').hide(); 
    $('th.table-lang').hide();
    $('td.table-lang').hide();        
}

function fliterLangAll()
{
    $('input.filter-lang-checkbox').attr('checked', 'checked');
}

function fliterLangNone()
{
    $('input.filter-lang-checkbox').removeAttr('checked');
}

$(function(){
    $('#form_translate_accordion').accordion();
    
    $("#content_filter_header").click(function(){
        $("#content_filter").toggle(500);
    });    
    
    $('input#modal-context-switch').bind('change', function(){
        if ($(this).is(':checked'))
        {
            $('div.modal-context-wrapper').show();
        }
        else
        {
            $('div.modal-context-wrapper').hide();
        }
    });
    
    if ($('input#filter-switch-context').is(':checked'))
    {
        $('th.table-context').show();
        $('td.table-context').show();
    }
    else
    {
        $('th.table-context').hide();
        $('td.table-context').hide();
    }    
    
    $('input#filter-switch-context').bind('change', function(){
        if ($(this).is(':checked'))
        {
            $('th.table-context').show();
            $('td.table-context').show();
        }
        else
        {
            $('th.table-context').hide();
            $('td.table-context').hide();
        }
    });
    
    if ($('select#filter-lang-type').val() != ALL_TYPES)
    {
        $('div#filter-langs').css('display', 'inline-block');
    }
    else
    {
        $('div#filter-langs').css('display', 'none');
    }    
    
    $('select#filter-lang-type').bind('change', function(){
        if ($(this).val() != ALL_TYPES)
        {
            $('div#filter-langs').css('display', 'inline-block');
        }
        else
        {
            $('div#filter-langs').css('display', 'none');
        }
    });
    
    $.each($('input.filter-switch-checkbox'), function(){
        if ($(this).attr('langalias') != undefined)
        {
            switchLang(this, $(this).attr('langalias'));
        }
    });     
    
})