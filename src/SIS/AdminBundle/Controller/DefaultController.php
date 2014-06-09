<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use AD\ArticuloBundle\Entity\Sismo;
use AD\ArticuloBundle\Entity\ZonaMacrosismica;
use AD\ArticuloBundle\Entity\Localidad;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
	/**
     * Index.
     *
     * @Route("", name="index")
     * @Template()
     */
    public function indexAction()
    {
//        return $this->render('SISAdminBundle:Default:index.html.twig');
		return array();
    }

	/**
	* @Route("searchFecha", name="searchFecha")
	*/
	public function getSearchFecha()
	{
        $em = $this->getDoctrine()->getEntityManager();

		$fecha = $this->get('request')->query->get('fecha_');
		$anioini = $this->get('request')->query->get('anioini_');
		$aniofin = $this->get('request')->query->get('aniofin_');
		$zonaMacro = $this->get('request')->query->get('zonaMacro_');
		$lonini = $this->get('request')->query->get('lonini_');
		$latini = $this->get('request')->query->get('latini_');
		$lonfin = $this->get('request')->query->get('lonfin_');
		$latfin = $this->get('request')->query->get('latfin_');
		$estado = $this->get('request')->query->get('estado_');
		$localidad = $this->get('request')->query->get('localidad_');

		$hasFecha = ($fecha == "") ? false : true;
		$hasPeriodo = ($anioini != "" && $aniofin != "") ? true : false;
		$hasZonaMacro = ($zonaMacro == "") ? false : true;
		$hasLatLon = ($lonini != "" && $latini != "" && $lonfin != "" && $latfin != "") ? true : false;
		$hasEstado = ($estado == "") ? false : true;
		$hasLocalidad = ($localidad == "") ? false : true;

		$fechaDT = new \DateTime($fecha);

		$queryString = "SELECT p, c, d FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE ";

//		array_push($array, 'sismo' => 'Mexico');

		if($hasFecha == true){
			$queryString = $queryString."d.anio =:anio1 AND d.mes =:mes1 AND d.dia =:dia1 AND ";
		}
		if($hasPeriodo == true){
			$queryString = $queryString."d.anio >=:anioini1 AND d.anio <=:aniofin1 AND ";
		}
		if($hasZonaMacro == true){
			$queryString = $queryString."d.zonaMacrosismica =:zona1 AND ";
		}
		if($hasLatLon == true){
			$queryString = $queryString."c.latitud > :latini1 AND c.latitud < :latfin1 AND c.longitud > :lonini1 AND c.longitud < :lonfin1 AND ";
//			$queryString = $queryString."c.latitud < :latini1 AND ";
		}
		if($hasEstado == true){
			$queryString = $queryString."c.estado =:estado1 AND ";
		}
		if($hasLocalidad == true){
			$queryString = $queryString."p.localidad =:localidad1 AND ";
		}

		$queryString = $queryString."p.id <>0 group by p.sismo";

//		$queryString = "SELECT p, c FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE c.estado <> '' group by p.sismo";

//		$query = $em->createQuery('SELECT p FROM SISAdminBundle:Sismo p WHERE p.zonaMacrosismica =:zona')->setParameter('zona', $zonaMacro);
//		$query = $em->createQuery('SELECT p FROM SISAdminBundle:Sismo p WHERE p.fecha = :fecha1')->setParameter('fecha1', $fechaDT);
		$query = $em->createQuery($queryString);

		if($hasFecha == true){
			$parts = explode('-', $fecha);
			$query->setParameter('anio1', $parts[0]);
			$query->setParameter('mes1', $parts[1]);
			$query->setParameter('dia1', $parts[2]);
		}
		if($hasPeriodo == true){
			$query->setParameter('anioini1', $anioini);
			$query->setParameter('aniofin1', $aniofin);
		}
		if($hasZonaMacro == true){
			$query->setParameter('zona1', $zonaMacro);
		}
		if($hasLatLon == true){
			$query->setParameter('latini1', $latini);
			$query->setParameter('latfin1', $latfin);
			$query->setParameter('lonini1', $lonini);
			$query->setParameter('lonfin1', $lonfin);
		}
		if($hasEstado == true){
			$query->setParameter('estado1', $estado);
		}
		if($hasLocalidad == true){
			$query->setParameter('localidad1', $localidad);
		}

//        $entities = $em->getRepository('SISAdminBundle:Sismo')->findByFecha($fechaDT);
//		$entities = $em->getRepository('SISAdminBundle:Sismo')->findBy($array);

		$entities = $query->getResult();

/*		$html = '';
		foreach($entities as $sismo)
		{
//			$html = $html.sprintf("<tr><td width='100px'>%s</td><td width='300px'>%s</td><td width='100px'>%s</td><td width='100px'>%s</td><td width='100px'>%s</td></tr>", $sismo->getFecha()->format('Y-m-d'), $sismo->getZonaMacrosismica(), $sismo->getMagnitudEstimada(), $sismo->getIntensidadMaxima(), "Puntos pendientes");

			$html = $html.sprintf("<tr><td width='100px'>%s</td><td width='300px'>%s</td><td width='100px'>%s</td><td width='100px'>%s</td><td width='100px'>%s</td></tr>", $sismo->getSismo()->getAnio(), $sismo->getSismo()->getZonaMacrosismica(), $sismo->getSismo()->getMagnitudEstimada(), $sismo->getSismo()->getIntensidadMaxima(), $sismo->getPuntos());
		}

		return new Response($html);
*/

		$lista = array();

		foreach($entities as $sismo){
			$sismo = array("sismo" =>  $sismo->getSismo()->getSismo(), "anio" =>  $sismo->getSismo()->getAnio(), "mes" =>  $sismo->getSismo()->getMes(), "dia" =>  $sismo->getSismo()->getDia(), "zona" =>$sismo->getSismo()->getZonaMacrosismica()->getZonaMacrosismica(), "magnitud" => $sismo->getSismo()->getMagnitudEstimada(), "intensidad" => $sismo->getSismo()->getIntensidadMaxima(), "localidades" => $sismo->getPuntos(), "sismoId" => $sismo->getSismo()->getId() );
			array_push($lista, $sismo);
		}

		$named_array = array("list" => $lista);

		$response = new Response(json_encode($named_array));

		return $response;
	}

	/**
	* @Route("searchDetalle", name="searchDetalle")
	*/
	public function getSearchDetalle()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$sismoId = $this->get('request')->query->get('sismoId_');

		$queryString = "SELECT p, c, d FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE p.sismo =:id_ ";

//		$queryString = $queryString."p.id <>0 group by p.sismo";

		$query = $em->createQuery($queryString);

		$query->setParameter('id_', $sismoId);

		$entities = $query->getResult();

		$localidades = array();
		$datosSismo = array();

		$count = 0;

		foreach($entities as $sismo){
			if($count == 0){
				$datos = array("citaRepresentativa" =>  $sismo->getSismo()->getCitaRepresentativa(), "interpretacion" =>  $sismo->getSismo()->getInterpretacion(), "fenomenos" =>  $sismo->getSismo()->getFenomenosAsociados(), "citaTextual" =>$sismo->getSismo()->getCitaTextual(), "sismo" =>  $sismo->getSismo()->getSismo(), "anio" =>  $sismo->getSismo()->getAnio(), "mes" =>  $sismo->getSismo()->getMes(), "dia" =>  $sismo->getSismo()->getDia(), "zona" =>$sismo->getSismo()->getZonaMacrosismica()->getZonaMacrosismica(), "magnitud" => $sismo->getSismo()->getMagnitudEstimada(), "intensidad" => $sismo->getSismo()->getIntensidadMaxima(), "localidades" => $sismo->getPuntos(), "sismoId" => $sismo->getSismo()->getId() );
				array_push($datosSismo, $datos);
			}else{
				$localidad = array("localidad" =>  $sismo->getLocalidad()->getLocalidad(), "nombreOficial" =>  $sismo->getLocalidad()->getNombreOficial(), "latitud" =>  $sismo->getLocalidad()->getLatitud(), "longitud" =>$sismo->getLocalidad()->getLongitud(), "intensidad" => $sismo->getIntensidad(), "comentario" => $sismo->getComentario() );
				array_push($localidades, $localidad);
			}
			$count ++;
		}

		$array_result = array("localidades" => $localidades, "datos" => $datosSismo);

		$response = new Response(json_encode($array_result));

		return $response;


	}

	/**
	* @Route("cargaZona", name="cargaZona")
	*/
	public function getCargaZona(){
		$em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->findAll();

		$html = '<option value="">Selecciona una zona</option>';
		foreach($entities as $zona)
		{
			if($zona->getZonaMacrosismica() != 'NULL'){
				$html = $html.sprintf('<option value="%s">%s</option>', $zona->getId(), $zona->getZonaMacrosismica());
			}
		}

		return new Response($html);
	}

	/**
	* @Route("cargaLocalidad", name="cargaLocalidad")
	*/
	public function getCargaLocalidad(){
		$em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Localidad')->findAll();

		$html = '<option value="">Selecciona una localidad</option>';
		foreach($entities as $localidad)
		{
			if($localidad->getLocalidad() != 'NULL'){
				$html = $html.sprintf('<option value="%s">%s</option>', $localidad->getId(), $localidad->getLocalidad()." - ".$localidad->getNombreOficial());
			}
		}

		return new Response($html);
	}

	/**
	* @Route("cargaEstado", name="cargaEstado")
	*/
	public function getCargaEstado(){
		$em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Estado')->findAll();

		$html = '<option value="">Selecciona un estado</option>';
		foreach($entities as $estado)
		{
			if($estado->getEstado() != 'NULL' && $estado->getEstado() != ''){
				$html = $html.sprintf('<option value="%s">%s</option>', $estado->getId(), $estado->getEstado());
			}
		}

		return new Response($html);
	}

	/**
	* @Route("pruebas", name="pruebas")
	*/
	public function getPruebas(){

	$lista = array();

	for($i = 0; $i < 5; $i++){
		$sismo = array("anio" => "2000", "mes" => "febrero");
		array_push($lista, $sismo);
	}

	$named_array = array("list" => $lista);

		$response = new Response(json_encode($named_array));

//		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}


/**
* @Route("descarga/{id}", name="descarga")
*/
public function generaKml($id) {
    $file_name = "mapa.kml";

	$em = $this->getDoctrine()->getEntityManager();

	$queryString = "SELECT p, c, d FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE p.sismo =:id_ AND p.localidad <> 736";
	$query = $em->createQuery($queryString);
	$query->setParameter('id_', $id);

	$entities = $query->getResult();

	if (!$entities) {
        $file_open = fopen($file_name,"w+");

		if($file_open){
			fwrite($file_open, '<?xml version="1.0" encoding="UTF-8"?>
			<kml xmlns="http://www.opengis.net/kml/2.2"><Document><name>Document.kml</name>
			<open>1</open>
			<Style id="exampleStyleDocument">
			<LabelStyle>
			<color>ff0000cc</color>
			</LabelStyle>
			</Style><LookAt>
			<longitude>-99.4975</longitude>
			<latitude>21.19</latitude>
			<altitude>0</altitude>
			<range>2000000</range>
			<tilt>0</tilt>
			<heading>0</heading>
			<altitudeMode>relativeToGround</altitudeMode>
			</LookAt>
			</Document>
			</kml>');
			fclose($file_open);
			header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
			header("Last-Modified: ".gmdate("D,d M YH:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=\"" . $file_name . "\"" );
			readfile($file_name);
			unlink($file_name);
		}
		return new Response(' ');
    }

	$count = 0;
	$latitud = 0;
	$longitud = 0;
	$marks = "";

	foreach($entities as $sismo){
		if($sismo->getLocalidad()->getLatitud() != NULL && $sismo->getLocalidad()->getLongitud() != NULL){
			$marks = $marks.'<Placemark><name>'.$sismo->getLocalidad()->getLocalidad().'</name>
			<styleUrl>#exampleStyleDocument</styleUrl>
			<Point>
			<coordinates>-'.$sismo->getLocalidad()->getLongitud().','.$sismo->getLocalidad()->getLatitud().',0</coordinates>
			</Point>
			</Placemark>';

			$latitud = $latitud + $sismo->getLocalidad()->getLatitud();
			$longitud = $longitud + $sismo->getLocalidad()->getLongitud();
			$count ++;
		}
	}

	$latitud = $latitud/$count;
	$longitud = $longitud/$count;

	$lookAt = '<LookAt>
		<longitude>-'.$longitud.'</longitude>
		<latitude>'.$latitud.'</latitude>
		<altitude>0</altitude>
		<range>1000000</range>
		<tilt>0</tilt>
		<heading>0</heading>
		<altitudeMode>relativeToGround</altitudeMode>
		</LookAt>';

	$stringKml = '<?xml version="1.0" encoding="UTF-8"?>
		<kml xmlns="http://www.opengis.net/kml/2.2"><Document><name>Document.kml</name>
		<open>1</open>
		<Style id="exampleStyleDocument">
		<LabelStyle>
		<color>ff0000cc</color>
		</LabelStyle>
		</Style>'.$lookAt.$marks.'</Document>
		</kml>';

	$kml_file = '<?xml version="1.0" encoding="UTF-8"?>
		<kml xmlns="http://www.opengis.net/kml/2.2">
		<Placemark>
		<name>Simple placemark</name>
		<description>Attached to the ground. Intelligently places itself at the height of the underlying terrain.</description>
		<Point>
		<coordinates>-122.0822035425683,37.42228990140251,0</coordinates>
		</Point>
		</Placemark>
		</kml>';

    $file_open = fopen($file_name,"w+");

	if($file_open){
		fwrite($file_open, $stringKml);
		fclose($file_open);
		header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Content-type: text/plain");
		header("Content-Disposition: attachment; filename=\"" . $file_name . "\"" );
		readfile($file_name);
		unlink($file_name);
	}

		return new Response(' ');
	}

	/**
	* @Route("descargaExcel/{id}", name="descargaExcel")
	*/
	public function excelAction($id) {
	$em = $this->getDoctrine()->getEntityManager();

	$queryString = "SELECT p, c, d FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE p.sismo =:id_ ";
	$query = $em->createQuery($queryString);
	$query->setParameter('id_', $id);

	$entities = $query->getResult();

	if (!$entities) {
		return new Response(' ');
	}

	$xls_service = $this->get('xls.service_xls5');
	$xls_service->excelObj->getProperties()->setCreator("Maadix")
	->setLastModifiedBy("Maadix_Dev")
	->setTitle("Resumen de datos")
	->setSubject("Este es un reporte de datos de un sismo")
	->setDescription("Reporte en excel con datos de un sismo")
	->setKeywords("Office 2005 openxml php")
	->setCategory("Test");

	$contCell = 13;
	foreach($entities as $sismo){

			$xls_service->excelObj->setActiveSheetIndex(0)
			->setCellValue('A1', 'RESUMEN')
			->setCellValue('A2', 'ID Sismo')
			->setCellValue('A3', 'Nombre del sismo')
			->setCellValue('A4', 'Fecha')
			->setCellValue('A5', 'Zona Macrosísmica')
			->setCellValue('A6', 'Magnitud Estimada')
			->setCellValue('A7', 'Intensidad Maxima')
			->setCellValue('A11', 'LISTA DE LOCALIDADES')
			->setCellValue('A12', 'Localidad')
			->setCellValue('B12', 'Nombre Oficial')
			->setCellValue('C12', 'Latitud')
			->setCellValue('D12', 'Longitud')
			->setCellValue('E12', 'Intensidad')
			->setCellValue('F12', 'Comentario')
			->setCellValue('B2', ''.$sismo->getSismo()->getId())
			->setCellValue('B3', ''.$sismo->getSismo()->getSismo())
			->setCellValue('B4', ''.$sismo->getSismo()->getAnio().'/'.$sismo->getSismo()->getMes().'/'.$sismo->getSismo()->getDia())
			->setCellValue('B5', ''.$sismo->getSismo()->getZonaMacrosismica()->getZonaMacrosismica())
			->setCellValue('B6', ''.$sismo->getSismo()->getMagnitudEstimada())
			->setCellValue('B7', ''.$sismo->getSismo()->getIntensidadMaxima());

		if($sismo->getLocalidad()->getId() != 736){
			$xls_service->excelObj->setActiveSheetIndex(0)
			->setCellValue('A'.$contCell, $sismo->getLocalidad()->getLocalidad())
			->setCellValue('B'.$contCell, $sismo->getLocalidad()->getNombreOficial())
			->setCellValue('C'.$contCell, $sismo->getLocalidad()->getLatitud())
			->setCellValue('D'.$contCell, $sismo->getLocalidad()->getLongitud())
			->setCellValue('E'.$contCell, $sismo->getIntensidad())
			->setCellValue('F'.$contCell, $sismo->getComentario());
		}

		$contCell ++;
/*		$xls_service->excelObj->setActiveSheetIndex(0)
		->setCellValue('A1', 'Hola')
		->setCellValue('B2', 'mundo!');*/
	}

		$xls_service->excelObj->setActiveSheetIndex(0)
		->setCellValue('D1', '')
		->setCellValue('E1', '');
		$xls_service->excelObj->getActiveSheet()->setTitle('Resumen');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$xls_service->excelObj->setActiveSheetIndex(0);
		//crear la respuesta
		$response = $xls_service->getResponse();
		$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment;filename=ResumenDeDatos.xls');
		// Si usa una conexión https debe configurar estos dos header para compatibilidad con IE headers->set('Pragma', 'public');
		$response->headers->set('Cache-Control', 'maxage=1');
		return $response;
	}

	/**
	* @Route("searchTexto", name="searchTexto")
	*/
	public function getSearchTexto()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$texto = $this->get('request')->query->get('texto_');

		$queryString = "SELECT p, c, d FROM SISAdminBundle:Temblor p JOIN p.localidad c JOIN p.sismo d WHERE d.fenomenosAsociados LIKE :text_ 
			OR d.resumenDanos LIKE :text_ OR d.citaRepresentativa LIKE :text_ OR d.bibliografia LIKE :text_ OR d.interpretacion LIKE :text_ OR d.citaTextual LIKE :text_ group by p.sismo";

//		$queryString = $queryString."p.id <>0 group by p.sismo";

		$query = $em->createQuery($queryString);

		$query->setParameter('text_', '%'.$texto.'%');

		$entities = $query->getResult();

//		if(!$entities){
//		}

		$lista = array();

		foreach($entities as $sismo){
			$sismo = array("sismo" =>  $sismo->getSismo()->getSismo(), "anio" =>  $sismo->getSismo()->getAnio(), "mes" =>  $sismo->getSismo()->getMes(), "dia" =>  $sismo->getSismo()->getDia(), "zona" =>$sismo->getSismo()->getZonaMacrosismica()->getZonaMacrosismica(), "magnitud" => $sismo->getSismo()->getMagnitudEstimada(), "intensidad" => $sismo->getSismo()->getIntensidadMaxima(), "localidades" => $sismo->getPuntos(), "sismoId" => $sismo->getSismo()->getId() );
			array_push($lista, $sismo);
		}

		$named_array = array("list" => $lista);

		$response = new Response(json_encode($named_array));

		return $response;


	}

}
