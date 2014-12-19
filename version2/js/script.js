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
var reportDeleteButton = $("div.admin #mostrarDatos h2 a.close");
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
}

var userChange = $("div.admin div.listUser > table tbody tr > td");
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
			case 'changePassword': field = $.parseHTML('<input type="password" data-role="'+ dataRole +'" name="'+dataRole+'" placeholder="Nueva Clave" />'); break;
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
							
							if(statusValue == 1){
								statusButton.text('Activo');
								statusButton.attr('data-role', '2');
								statusButton.removeClass('inactivo');
								statusButton.addClass('activo');
							}
							if(statusValue == 2){
								statusButton.text('Inactivo');
								statusButton.attr('data-role', '1');
								statusButton.removeClass('activo');
								statusButton.addClass('inactivo');
							}
					}	});
		}
	});
}//-->end for