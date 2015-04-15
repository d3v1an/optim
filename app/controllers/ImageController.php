<?php

class ImageController extends BaseController {

	// Funcion comun para vista principal
	public function common()
	{
		$params = array('active' => 'jpg');
		return View::make('common')->with($params);
	}

	// compresion de png
	public function commonPNG()
	{
		$params = array('active' => 'png');
		return View::make('png')->with($params);
	}

	// compresion de css
	public function commonCSS()
	{
		$params = array('active' => 'css');
		return View::make('css')->with($params);
	}

	// compresion de js
	public function commonJS()
	{
		$params = array('active' => 'js');
		return View::make('js')->with($params);
	}

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
			return Response::json(array('status' => false, 'message' => 'La imagen es demasiado grande'));
		}

		try {
    				
			// Carga de imagenes al servidor
			$uploadSuccess = $img_file->move($destinationPath, $HashfileName);

			if($uploadSuccess) {
			
				File::copy($destinationPath . $HashfileName, $destinationPath . $OriginalFileName);

				//$imageDimension = getimagesize($destinationPath . $OriginalFileName);
				list($width, $height) = getimagesize($destinationPath . $OriginalFileName);
			
				return Response::json(array('status' => true, 'message' => 'Archivo cargado exitosamente','original' => $OriginalFileName,'original_size' => $OriginalFileSize,'uploaded' => $HashfileName, 'width' => $width, 'height' => $height),200);
			
			} else return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor [' . $e->getMessage() . ']'),200);
		}

	}

	// Compresion de imagen JPG/JPEG
	public function compressJPG()
	{
		try {
			
			$command				= L4shell::get();

			$original 				= Input::get('original');
			$uploaded 				= Input::get('uploaded');
			$destinationPath 		= public_path() .'/uploads/images/';
			$mainFile 				= $destinationPath . $uploaded;
			//65-75
			$result 				= $command
									  ->setCommand("jpegoptim {$mainFile} -v --max=75-85 --strip-all -p -t --strip-iptc --strip-icc")
									  ->execute();

			$response 				= explode("\n", $result);
			$res_data 				= explode(" ", $response[0]);

			$compress_percent_r 	= str_replace(array('(',',',')'),'',$res_data[11]);
			$compress_percent_f 	= round(str_replace(array('(',',',')','%'),'',$res_data[11]));
			$new_file_size 			= $this->formatSizeUnits($res_data[9]);
			$original_size 			= $this->formatSizeUnits($res_data[7]);

			if (strpos($result,'OK') !== false) {
				if(File::exists($destinationPath.$original)) File::delete($destinationPath.$original);
				return Response::json(array('status' => true, 'message' => 'Imagen optimizada', 'image' => $uploaded, 'compress_percent_real' => $compress_percent_r,'compress_percent_fix' => $compress_percent_f, 'new_file_size' => $new_file_size,'original_size' => $original_size),200);
			} else {
				return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result),200);
			}

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result,'exception' => $e->getMessage()),200);
		}
	}

	// Carga de archivo png
	public function uploadPNG()
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
		$extAllowed 			= array('png');
		if(!in_array($extension,$extAllowed)) {
			return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
		}

		// Validacion de mimetype
		$mimeAllowed 			= array('image/png');
		if(!in_array($mimeType,$mimeAllowed)) {
			return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
		}

		// Validacion de tamaño de archivo
		$maxFileSize 			= (1024 * 1024 * 5); // 5MB 
		if($OriginalFileSize > $maxFileSize) {
			return Response::json(array('status' => false, 'message' => 'La imagen es demasiado grande'));
		}

		try {
    				
			// Carga de imagenes al servidor
			$uploadSuccess = $img_file->move($destinationPath, $HashfileName);

			if($uploadSuccess) {
			
				File::copy($destinationPath . $HashfileName, $destinationPath . $OriginalFileName);

				//$imageDimension = getimagesize($destinationPath . $OriginalFileName);
				list($width, $height) = getimagesize($destinationPath . $OriginalFileName);
			
				return Response::json(array('status' => true, 'message' => 'Archivo cargado exitosamente','original' => $OriginalFileName,'original_size' => $OriginalFileSize,'uploaded' => $HashfileName, 'width' => $width, 'height' => $height),200);
			
			} else return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Error al cargar la imagen al servidor [' . $e->getMessage() . ']'),200);
		}

	}

	// Compresion de imagen JPG/JPEG
	public function compressPNG()
	{
		$result = null;
		try {
			
			$command				= L4shell::get();

			$original 				= Input::get('original');
			$uploaded 				= Input::get('uploaded');
			$destinationPath 		= public_path() .'/uploads/images/';
			$mainFile 				= $destinationPath . $uploaded;

			$renamed_file 			= $destinationPath.$original;

			if(File::exists($destinationPath.$original)) {
				if(File::move($destinationPath.$uploaded, $destinationPath. '_' . $uploaded)) {
					$renamed_file = $destinationPath. '_' . $uploaded;
				}
			}
			
			//65-75 escapeshellarg
			$result 				= $command
									  //->setCommand("jpegoptim {$mainFile} -v --max=75-85 --strip-all -p -t --strip-iptc --strip-icc")
									  //->setCommand("pngquant -s1 -v --quality=40 {$mainFile} -o {$mainFile}")
									  ->setCommand("pngquant -s1 --quality=40-60 {$renamed_file} -o {$mainFile}")
									  ->execute();

			$response 				= explode("\n", $result);
			$res_data 				= explode(" ", $response[0]);
			return Response::json($result);

			$compress_percent_r 	= str_replace(array('(',',',')'),'',$res_data[11]);
			$compress_percent_f 	= round(str_replace(array('(',',',')','%'),'',$res_data[11]));
			$new_file_size 			= $this->formatSizeUnits($res_data[9]);
			$original_size 			= $this->formatSizeUnits($res_data[7]);

			if (strpos($result,'OK') !== false) {
				if(File::exists($destinationPath.$original)) File::delete($destinationPath.$original);
				return Response::json(array('status' => true, 'message' => 'Imagen optimizada', 'image' => $uploaded, 'compress_percent_real' => $compress_percent_r,'compress_percent_fix' => $compress_percent_f, 'new_file_size' => $new_file_size,'original_size' => $original_size),200);
			} else {
				return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result),200);
			}

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la imagen', 'res' => $result,'exception' => $e->getMessage()),200);
		}
	}

	// Dscarga de archivo
	public function download($t,$file)
	{
		try {

			$_image_path = public_path() .'/uploads/images/';

			if($t==1 || $t==2) {
				if (File::exists($_image_path . $file)) {
					return Response::download($_image_path . $file);
				}
			}
		} catch (Exception $e) {
			return Redirect::to('/')->with('message_error',$e->getMessage());
		}
	}

	// Format size
	private function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . 'GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . 'MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . 'KB';
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