
/*
Script para cargar combos dependientes.
*/
function loadSelectField(url, data, destination, current_data = "", url2 = "get-by-params"){
    var dest = destination;
    var current = current_data;
    $('#'+dest).html('');
    
    $('#'+destination).load('/'+url+'/'+url2+'/'+$('#'+data).val(), '', function (response, status, request) {
        opciones = '<option value="">Seleccione...</option>';
        items = $.parseJSON(response);
        /*items.sort(function (a, b) {
            return a.name.localeCompare(b.name);
        });
        console.log(items);*/
        var countKey = Object.keys(items).length;
        if(countKey > 0){
            $.each(items, function( index, value ) {
                if(current == index){
                    opciones += '<option selected="selected" value="'+index+'">'+value+'</option>';
                }
                else{
                    opciones += '<option value="'+index+'">'+value+'</option>';
                }
            });
        }
        $('#'+dest).html(opciones);
    });
}

/*
Script para cargar via ajax un request a una capa definida
*/
function loadUrl(url, data, destination){
    var dest = destination;
    $('#'+destination).load(url, data, function (response, status, request) {
        $('#'+dest).html(response);
    });
}
/*
Script para enlazar un anchor con la clase "ajax-request" para hacer un request ajax tipo GET
Se toma el atributo href como url, el atributo target es el id de la capa en la que se va a cargar el html
<a href="URL" target="#capa" class="ajax-request"></a>
*/
$(document).on("click",".ajax-request",function(e){
    e.preventDefault();
    obj_actual = $(this);
    loadUrl(obj_actual.prop("href"),'', obj_actual.prop("target"));
})
/*
Script para enlazar un boton con la clase "submit-post-ajax" para hacer un request ajax tipo POST y enviar los datos de
un formulario para su procesamiento
Se toma el atributo action del form padre como url, la funciona serialize para la data
*/
$(document).on("click",".submit-post-ajax",function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    var obj = $(this);
    $.ajax({
        url: form.prop('action'),
        method: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function (xhr) { 
        },
        success: function (data) {
            $('.cancel-button').click();
            setTimeout(function(){
                $(obj.data('target')).prepend('<div class="alert alert-success fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+data.message+'</div>');
            },1000);
        }
    }).fail( function( jqXHR, textStatus, errorThrown ) { 
        var jsonResponseText = $.parseJSON(jqXHR.responseText);
        messagge_error = "";
        
        $.each(jsonResponseText.errors, function(name, val) {
            messagge_error += val[0] + "<br>";
        })
        $(obj.data('target')).prepend('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+messagge_error+'</div>');
        setTimeout(function(){
            $(obj.data('target')+' button.close').click();
        },5000);
    });
})
/*
Script para enlazar un boton con la clase "submit-post-ajax" para hacer un request ajax tipo POST y enviar los datos de
un formulario para su procesamiento
Se toma el atributo action del form padre como url, la funciona serialize para la data
*/
$(document).on("click",".submit-patch-ajax",function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    var obj = $(this);
    $.ajax({
        url: form.prop('action'),
        method: 'PATCH',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function (xhr) { 
        },
        success: function (data) {
            $('.cancel-button').click();
            setTimeout(function(){
                $(obj.data('target')).prepend('<div class="alert alert-success fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+data.message+'</div>');
            },1000);
        }
    }).fail( function( jqXHR, textStatus, errorThrown ) { 
        var jsonResponseText = $.parseJSON(jqXHR.responseText);
        messagge_error = "";
        
        $.each(jsonResponseText.errors, function(name, val) {
            messagge_error += val[0] + "<br>";
        })
        $(obj.data('target')).prepend('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+messagge_error+'</div>');
        setTimeout(function(){
            $(obj.data('target')+' button.close').click();
        },5000);
    });
})
/*
Script para enlazar un boton con la clase "submit-post-ajax" para hacer un request ajax tipo POST y enviar los datos de
un formulario para su procesamiento
Se toma el atributo action del form padre como url, la funciona serialize para la data
*/
$(document).on("click",".submit-delete-ajax",function(e){
    e.preventDefault();
    if(confirm('Esta seguro?')){
        var form = $(this).closest('form');
        var obj = $(this);
        $.ajax({
            url: form.prop('action'),
            method: 'DELETE',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function (xhr) { 
            },
            success: function (data) {
                $(obj.data('tab')).click();
                setTimeout(function(){
                    $(obj.data('target')).prepend('<div class="alert alert-success fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+data.message+'</div>');
                },1000);
            }
        }).fail( function( jqXHR, textStatus, errorThrown ) { 
            var jsonResponseText = $.parseJSON(jqXHR.responseText);
            messagge_error = "";
            
            $.each(jsonResponseText.errors, function(name, val) {
                messagge_error += val[0] + "<br>";
            })
            $(obj.data('target')).prepend('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>'+messagge_error+'</div>');
            setTimeout(function(){
                $(obj.data('target')+' button.close').click();
            },5000);
        });
    }
})