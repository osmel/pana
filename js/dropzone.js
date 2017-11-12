$(document).ready(function()
	{
		Dropzone.autoDiscover = false;

		$("#dropzone").dropzone({
			url: "uploadify/upload", ///"+$("#id_proyecto").val(),
			addRemoveLinks: true,
			dictDefaultMessage: "Fotografía de credencial. Arrastre una imagen o toque aquí para seleccionarla.",	  
			dictCancelUpload: "Eliminar archivo",
			maxFileSize: 1000,
			//maxFiles: 1,

			maxFiles: 1,
            //enqueueForUpload: false,

            // http://stackoverflow.com/questions/26322947/dropzone-replace-image-in-init

            maxfilesexceeded: function (file) {

               this.removeAllFiles();

                           	var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;

                this.addFile(file);

                
                
            },
            ////
            addRemoveLinks: true,
            uploadMultiple: false,
            dictRemoveFile: "Eliminar",



			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
			complete: function(file) {
				
				//alert(file.name);
				if(file.status == "success") {
					$('#foto').val(file.name);
					return true;
					//alert("El siguiente archivo ha subido correctamente: " + file.name);
				}
			},
			/*
			success:  function(file,response) {
				file.name = 'osmel.jpg';
				alert(file.name);
				console.log(response);
			},
			*/
			error: function(file) {

				//alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName) {
				var name = file.name;
				$.ajax({
					type: "POST",
					url: "uploadify/upload_delete", ///"+$("#id_proyecto").val(),
					data: "filename="+name,
					success: function(data)
					{
						var json = JSON.parse(data);
						if(json.res == true)
						{
							var element;
							element = file.previewElement;
							(element != null ) ? 
							element.parentNode.removeChild(file.previewElement) : false;
							$('#foto').val('');
							//alert("El elemento fué eliminado: " + name); 
						}
					}
				});
			}

		});

	});