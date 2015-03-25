<?php

class ImageController extends BaseController {

	// Carga de archivo jpg
	public function uploadJPG()
	{
		// Archivo a cargar
		$img_file 			= Input::file('file');
		// Directorio de destino
		$destinationPath 	= public_path() .'/uploads/images/';
		// Extension de imagen
		$extension 			= $img_file->getClientOriginalExtension();
		// Mime Type
		$mimeType	 		= $img_file->getMimeType();
		// Nombre original del archivo
		$OriginalFileName	= $img_file->getClientOriginalName();
		// Tamaño original del archivo
		$OriginalFileSize 	= $img_file->getSize();
		// Nombre temnporal del archivo
		$HashfileName 		= md5($OriginalFileName . rand(11111,99999)) . '.' .$extension;

		// Reglas de archivo
		// Validacion de extension
		$extAllowed 			= array('jpg','jpeg');
		if(!in_array($extension,$extAllowed)) {
			return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
		}

		// Validacion de mimetype
		$mimeAllowed 			= array('image/jpeg','image/jpg');
		if(!in_array($mimeType,$mimeAllowed)) {
			return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
		}

		// Validacion de tamaño de archivo
		$maxFileSize 			= (1024 * 1024 * 5); // 5MB 
		if($OriginalFileSize > $maxFileSize) {
			return Response::json(array('status' => false, 'message' => 'Imagen demasiado grande'));
		}

		try {
    				
			// Carga de imagenes al servidor
			$uploadSuccess = $img_file->move($destinationPath, $HashfileName);

			if($uploadSuccess) return Response::json(array('status' => true, 'message' => 'Archivo cargado exitosamente','original' => $OriginalFileName,'original_size' => $OriginalFileSize,'uploaded' => $HashfileName),200);
			else return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor [' . $e->getMessage() . ']'),200);
		}

	}

	// Compresion de imagen JPG/JPEG
	public function compressJPG()
	{
		try {
			
			$command			= L4shell::get();

			$original 			= Input::get('original');
			$uploaded 			= Input::get('uploaded');
			$destinationPath 	= public_path() .'/uploads/images/';
			$mainFile 			= $destinationPath . $uploaded;

			$result 			= $command
								  ->setCommand("jpegoptim {$mainFile} -v --max=65-75 --strip-all -p -t --strip-iptc --strip-icc")
								  ->execute();

			$response 			= explode("\n", $result);
			$res_data 			= explode(" ", $response[1]);

			$compress_percent 	= $res_data[4];
			$new_file_size 		= str_replace(')','',str_replace('(', '', $res_data[5]));
			$original_size 		= $this->formatSizeUnits(Input::get('original_size'));

			if (strpos($result,'OK') !== false) {
				return Response::json(array('status' => true, 'message' => 'Imagen optimizada', 'compress_percent' => $compress_percent,'new_file_size' => $new_file_size,'original_size' => $original_size),200);
			} else {
				return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result),200);
			}

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result,'exception' => $e->getMessage()),200);
		}
	}

	// Format size
	private function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . 'gb';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . 'mb';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . 'kb';
		} elseif ($bytes > 1) {
			$bytes = $bytes . 'bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . 'byte';
		} else {
			$bytes = '0bytes';
		}
		return $bytes;
	}

}