<?php

class ImageController extends BaseController {

	public function uploadJPG()
	{
		// Archivo a cargar
		$file 				= Input::file('file');
		// Directorio de destino
		$destinationPath 	= public_path() .'/uploads/images/';
		// Extension de imagen
		$extension 			= $file->getClientOriginalExtension();
		// Nombre original del archivo
		$OriginalFileName	= $file->getClientOriginalName();
		// Tamaño original del archivo
		$OriginalFileSize 	= $file->getSize();
		// Nombre temnporal del archivo
		$HashfileName 		= md5($OriginalFileName . rand(11111,99999)) . '.' .$extension;

		// Reglas de archivo
		$rules = array('file' => 'required|image|mimes:jpg,jpeg|max:5000');

		// Validacion de archivo
        $validator = Validator::make(array('file'=> $file), $rules);

        // Validamos el archivo a cargar
        if (!$validator->passes()) {

			// Si el archivo no es valido retornamos un error
			return Response::json(array('status' => false, 'message' => '1 Error en la carga del archivo', 'error' => $validator));
		} else {
			
			// Verificamos que la imagen sea valida.
    		if ($file->isValid()) {

    			try {
    				
    				// Carga de imagenes al servidor
					$uploadSuccess = $file->move($destinationPath, $HashfileName);

					if($uploadSuccess) return Response::json(array('status' => true, 'message' => 'Archivo cargado exitosamente'),200);
					else return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor'),200);

    			} catch (Exception $e) {
    				return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor [' . $e->getMessage() . ']'),200);
    			}
    		}
		}

		return Response::json($extension,200);
	}

}
