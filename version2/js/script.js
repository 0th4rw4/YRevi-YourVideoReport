/*
# See AUTHORS for a list of contributors
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation; either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# General Public License for more details.
#
# You should have received a copy of the GNU Affero General
# Public License along with this program.  If not, see
# <http://www.gnu.org/licenses/>.
*/

// Eliminar reportes
/*
 Al clickear sobre la X (boton de cerrar) muestra un dialogo para verificar la accion.
 Si responde "Si" entonces envia la solicitud al servidor via Ajax, caso contrario cierra la ventana que se desplego
*/
var reportDeleteButton = $("div.admin #mostrarDatos h2 a.close");
if( isNaN(reportDeleteButton) ){
for( i=0; i < reportDeleteButton.length ; i++){
	var boton = reportDeleteButton[i];
	//$(boton).preventDefault();
	boton.onclick = function(event){
		event.preventDefault();
		reportId = this.getAttribute('data-role');

		var modalMess = $('div.admin #mostrarDatos ul > li#' + reportId + ' div.modal-dialog');				
		modalMess.fadeIn('medium');
		var a = modalMess.find("div p a");

		a[0].onclick = function(event){ //opcion si
			event.preventDefault();
			var dialogo = $(this).parent().parent().parent();
			reportId = dialogo.parent().attr('id');

			$.ajax({
				type:'POST',
				sync: true,
				url:'admin.cambios.eliminar.ajax.php',
				data: 'delete='+reportId,
				success: function(respuesta){
					respuesta = JSON.parse(respuesta);

					var li = dialogo.parent();
					li.children().remove();
					var cajaTexto = dialogo.find("p");
					cajaTexto.text( respuesta.mess );
					li.append(dialogo);

					li.delay(1000).fadeOut('medium');

					}
			});
		} 
		a[1].onclick = function(event){ //opcion no
			event.preventDefault();
			var  modal = $(this).parent().parent().parent();
			modal.fadeOut('medium');
		} 
		
	};
}// -> end for
}

// Actualizar datos de usuario (y administrador)
/*
 Al clickear sobre un item de la tabla donde estan listados los usuarios, 
 se reemplaza el contenido por un campo de formularios para actulizar el dato.
 Si hace un click dentro y luego otro fuera, sin hacer cambios, se cierra el formulario 
 y aparece el campo de la tabla como estaba. Caso contrario, si se realiza un cambio, es enviado al servidor via Ajax
 quien responde con el cambio efectuado para actualizar la vista.
*/
var userChange = $("div.admin div.listUser > table tbody tr > td");
if( isNaN(userChange) ){
for( i=0; i < userChange.length; i++){
	var fieldTd = $(userChange[i]);
	fieldA = fieldTd.find("a");
	fieldA.click(function(event){
		event.preventDefault();
		fieldA = $(this);
		fieldTd = fieldA.parent();
		var clienteId = fieldTd.parent().attr('data-role');
		
		var form = $.parseHTML('<form name="userUpdate" enctype="multipart/form-data" action="#" method="post"></form>');
		var fieldHidden = $.parseHTML('<input type="hidden" name="clienteId" value="'+ clienteId +'" />');

		dataRole = fieldTd.attr('data-role');
		switch(dataRole){
			case 'changeLogo': field = $.parseHTML('<input type="file" data-role="'+ dataRole +'" name="'+dataRole+'" />'); break;
			case 'changeName': field = $.parseHTML('<input type="text" data-role="'+ dataRole +'" name="'+dataRole+'" placeholder="Ingrese el nuevo Nombre" />'); break;
			case 'changeUrl': field = $.parseHTML('<input type="text" data-role="'+ dataRole +'" name="'+dataRole+'" placeholder="Ingrese el nuevo dominio" />'); break;
			case 'changeStatus': field = false; break; 
			case 'changePassword': 
				pass = fieldTd.find('a').attr('title');
				field = $.parseHTML('<input type="text" data-role="'+ dataRole +'" name="'+dataRole+'" placeholder="'+pass+'" value="'+pass+'" />'); 
				break;
		}
		if(field){
			fieldA.addClass('invisible');
			form = $(form);
			field = $(field);
			fieldTd.append(form);
			form.append(fieldHidden, field);

			field.focusout(function(){
					a = $(this).parent().parent().find('a');
					aText = a.removeClass('invisible');

					$(this).parent().remove();
				});

			if( field.attr('data-role') == 'changeLogo' ){
				field.fileupload({
        			dataType: 'json',
        			done: function (e, data) {
            			$.each(data.result.files, function (index, file) {
                			$('<p/>').text(file.name).appendTo(document.body);
	            		});
        			}
	    		});
				//field.change(function(){
				//file = $(this);
				//file = file[0].files[0];
				//});
			}else {
				field.change(function(){
					field = $(this);
					fieldTd = field.parent().parent();
					fieldA = fieldTd.find("a");
					form = field.parent();

					clientId = fieldTd.find('form input')[0].value;
					fieldInput = fieldTd.find('form input')[1];
					inputName = $(fieldInput).attr('data-role');
					inputValue = fieldInput.value;

					
					form.submit(function(event){ 
						event.preventDefault(); });

					$.ajax({
						type:'POST',
						sync: true,
						url:'admin.cambios.eliminar.ajax.php',
						data: 'userChange='+clientId+'&'+inputName+'='+inputValue,
						success: function(respuesta){
							respuesta = JSON.parse(respuesta);

							form.remove();
							fieldA.text(respuesta.valor);
							fieldA.removeClass('invisible');
							/*
							var li = dialogo.parent();
							li.children().remove();
							var cajaTexto = dialogo.find("p");
							cajaTexto.text( respuesta.mess );
							li.append(dialogo);
							
							li.delay(1000).fadeOut('medium');
							*/
							}
					}); 
					
				}); //end fieldTd.change
			} //--> end else
		} //--> end if(field)
		else if(dataRole == 'changeStatus'){
				statusButton = fieldA;
				statusValue = statusButton.attr('data-role');

					$.ajax({
						type:'POST',
						sync: true,
						url:'admin.cambios.eliminar.ajax.php',
						data: 'userChange='+clienteId+'&changeStatus='+statusValue,
						success: function(respuesta){
							respuesta = JSON.parse(respuesta);
							
							if(respuesta.valor == 1){
								statusButton.text('Activo');
								statusButton.attr('data-role', '2');
								statusButton.removeClass('inactivo');
								statusButton.addClass('activo');
							}
							if(respuesta.valor == 2){
								statusButton.text('Inactivo');
								statusButton.attr('data-role', '1');
								statusButton.removeClass('activo');
								statusButton.addClass('inactivo');
							}
							if(respuesta.valor == 'deleted'){
								statusButton.parent().parent().remove();
							}
					}	});
		}
	});
}//-->end for
}