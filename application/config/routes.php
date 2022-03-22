<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
| example.com/class/method/id/
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = 'error_views/vwh_noencontrado';
$route['translate_uri_dashes'] = FALSE;

$route['iniciar-sesion']      = "index/vw_iniciar_sesion";
$route['iniciar-sesion/externo']      = "index/vw_iniciar_sesion_externo";
$route['iniciar-con-google']  = "usuario/logingoogle";
$route['cerrar-sesion']      = "usuario/fn_logout";
$route['gmail-cerrar-sesion']      = "usuario/fn_logout_gmail";

$route['cuentas/mi-perfil']      = "usuario/vw_mi_perfil";


$route['ayuda/docentes/videos']      = "ayuda/vw_tutoriales";//ANTIGUO
$route['ayuda/tutoriales']      = "ayuda/vw_tutoriales";
$route['contacto/sugerencia']  = "ayuda/vw_enviar_sugerencia";//ANTIGUO
$route['ayuda/ticket']  = "ayuda/vw_enviar_sugerencia";

$route['gestion/comunicados'] = "comunicados/vw_principal";
$route['gestion/comunicados/agregar']      = "comunicados/vw_agregar";
$route['gestion/comunicados/editar/(:any)']      = "comunicados/vw_editar/$1";
$route['comunicados/archivos/(:any)']      = "comunicados/vw_virtual_archivos/$1";



$route['gestion/auditoria'] = "auditoria/vw_lstgestion";
$route['gestion/auditoria/(:num)'] = "auditoria/vw_lstgestion/$1";

$route['administrador/cuentas']      = "usuario/vw_cuentas";
$route['administrador/acciones']      = "acciones";

$route['admision/ficha-personal']      = "admision";
$route['admision/inscripciones']      = "inscrito/inscripciones";
$route['admision/inscripciones/(:num)']      = "inscrito/inscripciones/$1";

$route['admision/campanias']      = "campania/vw_principal";


$route['admision/inscripcion-reportes'] = "inscrito_reportes/vw_reportes";
$route['admision/inscripcion-reportes/excel'] = "exportarexcel/dp_registro_inscripcion_excel";
$route['admision/inscripcion-reportes/pdf'] = "inscrito_reportes/get_filtrar_basico_sd_activa_report";
$route['admision/reportes-inscritos/pdf'] = "inscrito_reportes/get_datos_inscritos";




$route['admision/postulante/imprimir/(:any)/(:any)']      = "inscrito/pdf_ficha_inscripcion/$1/$2";
$route['admision/reingresos']      = "reingresos/fn_reingresos";

$route['admision/reingresos/excel']      = "Exportarexcel/dp_reingresos";

$route['admision/traslados'] = "traslados/fn_traslados";

$route['academico']  = "index/vw_academico";


$route['gestion/panel']      = "index/panel";


$route['gestion/academico/matriculas']      = "matricula/vw_matricula";



$route['academico/consulta/boleta-notas']      = "matricula/vw_matricula_boleta_notas";


$route['academico/consulta/orden-merito']      = "grupos/vw_grupos_consultas";
$route['academico/consulta/orden-merito/imprimir']      = "grupos/pdf_orden_merito";


//EXPORTACIONES A EXCEL
$route['academico/consulta/nomina-matricula/excel']      = "Exportarexcel/dp_registro_matriculados";



$route['academico/consulta/nomina-evaluaciones/excel']      = "Exportarexcel/dp_registro_evaluacion";
$route['academico/consulta/padron-evaluaciones/excel']      = "Exportarexcel/dp_registro_padron_evaluacion";
$route['academico/matricula/ficha/excel/(:any)']      = "Exportarexcel/dp_ficha_matricula/$1";
$route['academico/matricula/record-academico/pdf/(:any)']      = "matricula/pdf_record_academico/$1";
$route['academico/matriculas/campos/excel']      = "Exportarexcel/dp_matriculas_x_campos";

$route['academico/matriculas/individual']      = "matricula_independiente/vw_matricula";
$route['academico/matricula/independiente/ficha/imprimir/(:any)']      = "matricula_independiente/pdf_ficha_matricula/$1";


$route['academico/matricula/independiente/boleta/imprimir/(:any)']      = "matricula_independiente/pdf_boleta_notas/$1";
$route['academico/matricula/independiente/boletas/imprimir']      = "matricula_independiente/pdf_boletas_notas";
$route['academico/consulta/boleta-notas/imprimir-one/(:any)']      = "atricula_independiente/pdf_boleta_notas/$1";
$route['academico/consulta/boletas-notas/imprimir-sel']      = "matricula_independiente/pdf_boletas_notas";

$route['academico/matricula/record-academico/excel/(:any)']      = "Exportarexcel/dp_record_academico/$1";

$route['admision/inscripciones/excel']      = "Exportarexcel/dp_inscripciones";




$route['academico/matriculas/excel']      = "Exportarexcel/dp_matriculas";
$route['academico/grupos-matriculados']      = "grupos/vw_grupos";
$route['academico/grupos/descargar-notas'] = "grupos_descargar_notas/vw_notas_principal";


$route['academico/matricula/imprimir/(:any)']      = "matricula/pdf_ficha_matricula/$1";

$route['gestion/academico/carga-academica/panel']      = "cargasubseccion/vw_carga_subseccion_principal";
$route['gestion/academico/carga-academica/grupo']      = "cargaacademica/vw_carga_por_grupo";
$route['gestion/academico/carga-academica/docente']      = "cargaacademica/vw_carga_por_docente";
$route['gestion/academico/carga-academica/miembros/enrolar/(:any)/(:any)']      = "miembros/vw_enrolar/$1/$2";


//REPORTES ACADEMICO

$route['academico/reportes/carga-x-estudiante-filial/excel']      = "academico_reportes/excel_matriculas_total_carga_filiales";
$route['academico/reportes/cuadro-horas-docentes/excel']      = "academico_reportes/excel_cuadro_horas_docentes";


//SEGUIMIENTO
$route['seguimiento/alumnos']      = "supervisor/alumnos";


$route['seguimiento/docentes']      = "supervisor/docentes";
$route['seguimiento/docentes/(:any)']      = "supervisor/docentes/$1";
$route['seguimiento/docente/(:any)/(:any)/cursos']      = "supervisor/vw_cursos_docente/$1/$2";
$route['seguimiento/docente/curso/(:any)/(:any)/evaluaciones']      = "supervisor/vw_curso_evaluaciones/$1/$2";
$route['seguimiento/docente/curso/(:any)/(:any)/asistencias']      = "supervisor/vw_curso_asistencias/$1/$2";
$route['seguimiento/docente/curso/(:any)/(:any)/sesiones']      = "supervisor/vw_curso_sesiones/$1/$2";
$route['seguimiento/docente/curso/(:any)/(:any)/aula-virtual']      = "supervisor/vw_curso_virtual/$1/$2";

$route['seguimiento/grupos']      = "supervisor/grupos";

$route['seguimiento/egresados']      = "egresadosdts/egresados";
$route['seguimiento/estudiantes']      = "egresadosdts/estudiantes";



//MONITOREO*******************************************************************
$route['monitoreo/estudiantes']      = "monitoreo_alumno/vw_principal";
$route['monitoreo/estudiantes/encuesta/crear']       = "monitoreo_alumno/vw_crear_cuestionario";
$route['monitoreo/estudiantes/encuesta/editar/(:any)']       = "monitoreo_alumno/vw_editar_cuestionario/$1";
$route['monitoreo/estudiantes/encuesta/preguntas/(:any)']       = "cuestionario_general/vw_encuesta_preguntas/$1";
$route['monitoreo/estudiantes/encuesta/poblacion/(:any)']       = "cuestionario_general/vw_encuesta_poblacion/$1";


$route['monitoreo/docentes']      = "monitoreo_docente/vw_principal";
//$route['monitoreo/docentes/encuesta/crear']       = "cuestionario_general/vw_crear_cuestionario";


//$route['monitoreo/docentes/(:any)']      = "monitoreo_docente/vw_principal/$1";

$route['monitoreo/docentes/encuesta-dd/crear']       = "monitoreo_docente/vw_crear_cuestionario_dd";
$route['monitoreo/docentes/encuesta-dd/editar/(:any)']       = "monitoreo_docente/vw_editar_cuestionario_dd/$1";
$route['monitoreo/docentes/encuesta-dd/preguntas/(:any)']       = "cuestionario_general/vw_encuesta_preguntas/$1";
$route['monitoreo/docentes/encuesta-dd/poblacion/(:any)']       = "cuestionario_general/vw_encuesta_poblacion/$1";
$route['monitoreo/docentes/encuesta-dd/resultados/(:any)']       = "monitoreo_docente/vw_resultados_cuestionario_dd/$1";


$route['monitoreo/docente/(:any)/(:any)/cursos']      = "monitoreo_docente/vw_cursos_docente/$1/$2";
$route['monitoreo/docente/(:any)/(:any)/cursos/estadistica']      = "monitoreo_docente/vw_cursos_docente_estadistica/$1/$2";
$route['monitoreo/docente/curso/(:any)/(:any)/evaluaciones']      = "monitoreo_docente/vw_curso_evaluaciones/$1/$2";
$route['monitoreo/docente/curso/(:any)/(:any)/asistencias']      = "monitoreo_docente/vw_curso_asistencias/$1/$2";
$route['monitoreo/docente/curso/(:any)/(:any)/sesiones']      = "monitoreo_docente/vw_curso_sesiones/$1/$2";

$route['monitoreo/docente/curso/(:any)/(:any)/aula-virtual']      = "monitoreo_docente/vw_curso_virtual/$1/$2";

//MONITOREO DE AULA VIRTUAL
$route['monitoreo/docente/curso/virtual/tarea/(:any)/(:any)/(:any)']      = "monitoreo_docente/vw_curso_virtual_tarea/$1/$2/$3";
$route['monitoreo/docente/curso/virtual/foro/(:any)/(:any)/(:any)']      = "monitoreo_docente/vw_curso_virtual_foro/$1/$2/$3";


$route['monitoreo/docente/curso/miembros/(:any)/(:any)']      = "monitoreo_docente/vw_curso_miembros/$1/$2";
$route['monitoreo/docente/curso/miembros/excel/(:any)/(:any)']      = "Exportarexcel/dp_lista_simple_curso/$1/$2";

$route['monitoreo/grupos']      = "supervisor/grupos";

$route['monitoreo/egresados']      = "egresadosdts/egresados";


//$route['monitoreo/encuesta/crear']      = "cuestionario_general/vw_crear_cuestionario";

$route['gestion/rrhh/ficha-personal']      = "persona";
$route['gestion/rrhh/docentes']      = "docentes/vw_docentes";

$route['docente/mis-cursos']      = "docentes/vw_miscursos";
$route['docente/horario/descargar']      = "docentes/horario_pdf";


$route['curso/panel/(:any)/(:any)']      = "curso/vw_curso_panel/$1/$2";
$route['curso/configuracion/(:any)/(:any)']      = "curso/vw_curso_configuracion/$1/$2";
$route['curso/evaluaciones/(:any)/(:any)']      = "curso/vw_curso_evaluaciones/$1/$2";
$route['curso/recuperacion/(:any)/(:any)']      = "curso/vw_curso_recuperacion/$1/$2";
$route['curso/documentos/(:any)/(:any)']      = "curso/vw_curso_documentos/$1/$2";

$route['curso/documentos/acta-final-evaluacion-excel/(:any)/(:any)']      = "Exportarexcel/dp_acta_final_evaluacion/$1/$2";
$route['curso/documentos/acta-final-evaluacion-pdf/(:any)/(:any)']      = "curso/vw_acta_evaluacion_final_pdf/$1/$2";
$route['curso/documentos/registro-auxiliar-excel/(:any)/(:any)']      = "Exportarexcel/dp_registro_auxiliar_curso/$1/$2";

$route['curso/asistencias/(:any)/(:any)']      = "curso/vw_curso_asistencias/$1/$2";
$route['curso/asistencia-sesion/(:any)/(:any)/(:any)']      = "curso/vw_curso_asistencias_diario/$1/$2/$3";
$route['curso/asistencias/excel/(:any)/(:any)'] = "exportarexcel/dp_registro_asistencias/$1/$2";
$route['curso/evaluaciones/excel/(:any)/(:any)'] = "exportarexcel/dp_registro_auxiliar_evaluaciones/$1/$2";
$route['curso/sesiones/(:any)/(:any)']      = "curso/vw_curso_sesiones/$1/$2";
$route['curso/miembros/(:any)/(:any)']      = "curso/vw_curso_miembros/$1/$2";
$route['curso/indicadores/(:any)/(:any)']      = "curso/vw_curso_indicadores/$1/$2";
$route['curso/indicadores-only/(:any)/(:any)']      = "curso/vw_curso_indicadores_only/$1/$2";
$route['curso/registro-final-pdf/(:any)/(:any)']      = "curso/vw_registro_final_pdf/$1/$2";
$route['curso/registro-final-clasico-excel/(:any)/(:any)']      = "Exportarexcel/vw_registro_final_clasico_excel/$1/$2";

$route['curso/registro-final-nuevo-excel/(:any)/(:any)']      = "Exportarexcel/vw_registro_final_nuevo_excel/$1/$2";

$route['curso/virtual/archivos/(:any)/(:any)']      = "virtual/vw_virtual_archivos/$1/$2";
$route['curso/virtual/reportes/excel'] = "exportarexcel/dp_virtual_notas_unidad";
$route['curso/virtual/(:any)/(:any)']      = "virtual/vw_virtual/$1/$2";
$route['curso/virtual/agregar/(:any)/(:any)']      = "virtual/vw_virtual_add_etiqueta/$1/$2";
$route['curso/virtual/editar/(:any)/(:any)/(:any)']      = "virtual/vw_virtual_edit_etiqueta/$1/$2/$3";
//TAREA
$route['curso/virtual/tarea/(:any)/(:any)/(:any)']      = "virtualtarea/vw_docente_virtual_tarea/$1/$2/$3";
$route['curso/virtual/tarea/revisar/(:any)/(:any)/(:any)']      = "virtualtarea/vw_virtual_tarea_entregas/$1/$2/$3";
//TAREA
$route['curso/virtual/tarea/excel/(:any)/(:any)/(:any)'] = "Exportarexcel/vir_tareas_excel/$1/$2/$3";
//TAREA
$route['curso/virtual/tarea/pdf/(:any)/(:any)/(:any)']      = "virtualtarea/vw_evaluacion_tarea_pdf/$1/$2/$3";

//EVALUACIONES
$route['curso/virtual/evaluaciones/pdf/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_evaluaciones_pdf/$1/$2/$3";
$route['curso/virtual/evaluaciones/individual/pdf/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_evaluaciones_pdf_individual/$1/$2/$3/$4";
$route['curso/virtual/evaluaciones/individual/pdf-descargar/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_evaluaciones_pdf_individual_download/$1/$2/$3/$4";

//EVALUACIONES
$route['curso/virtual/evaluacion/excel/(:any)/(:any)/(:any)'] = "Exportarexcel/vir_evaluacion_excel/$1/$2/$3";
//EVALUACIONES
$route['curso/virtual/evaluacion/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_docente_virtual_evaluacion/$1/$2/$3";
$route['curso/virtual/evaluacion/revisar/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_entregas/$1/$2/$3";

$route['curso/virtual/evaluacion/revisado/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_revisado/$1/$2/$3/$4";

$route['curso/virtual/evaluacion/preguntas/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_preguntas/$1/$2/$3";


$route['curso/virtual/foro/(:any)/(:any)/(:any)']      = "virtual/vw_foro_virtual/$1/$2/$3";



$route['alumno/mis-cursos'] = "alumno/historial__mis_boletas_notas";//reemplazado por "alumno/historial/boleta-de-notas"
$route['alumno/historial/boleta-de-notas'] = "alumno/historial__mis_boletas_notas";


$route['alumno/historial/matriculas'] = "alumno/historial__mi_registro_matriculas";
$route['alumno/historial/pagos'] = "alumno/historial__mis_pagos";
$route['alumno/historial/deudas'] = "alumno/historial__mis_deudas";
$route['alumno/historial/notas'] = "alumno/historial__mis_notas";
$route['alumno/historial/notas/imprimir'] = "alumno/historial__mis_notas_imprimir";

$route['alumno/mis-pagos'] = "alumno/vwmispagos";
$route['alumno/mis-deudas'] = "alumno/vwmisdeudas";
$route['alumno/encuestas'] = "monitoreo_alumno/vw_encuestas";
$route['alumno/encuesta/(:any)'] = "monitoreo_alumno/vw_encuesta/$1";

$route['alumno/historial/reporte/deudas/pdf'] = "alumno/rp_deudas_estudiante_pdf";


$route['alumno/mis-deudas/notificar-error'] = "alumno/vwmisdeudas_notificar_error";

$route['alumno/mi-curso/(:any)/(:any)/detalle/(:any)/(:any)/(:any)/(:any)'] = "alumno/vw_micurso/$1/$2/$3/$4/$5/$6";
$route['alumno/historial/curso/(:any)/(:any)/detalle/(:any)/(:any)/(:any)/(:any)'] = "alumno/vw_micurso/$1/$2/$3/$4/$5/$6";


$route['alumno/aula-virtual']      = "virtualalumno/vw_cursos_visibles_x_carnet";

$route['alumno/curso/virtual/archivos/(:any)/(:any)']      = "virtualalumno/vw_virtual_archivos/$1/$2";
$route['alumno/curso/virtual/(:any)/(:any)/(:any)'] = "virtualalumno/vw_virtual/$1/$2/$3";
//tareas
$route['alumno/curso/virtual/tarea/(:any)/(:any)/(:any)/(:any)']      = "virtualtarea/vw_alumno_virtual_tarea/$1/$2/$3/$4";
$route['alumno/curso/virtual/tarea/entregar/(:any)/(:any)/(:any)/(:any)']      = "virtualtarea/vw_virtual_tarea_entregar/$1/$2/$3/$4";
$route['alumno/curso/virtual/tarea/editar/(:any)/(:any)/(:any)/(:any)']      = "virtualtarea/vw_virtual_tarea_editar/$1/$2/$3/$4";
//evaluaciones
$route['alumno/curso/virtual/evaluacion/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_alumno_virtual_evaluacion/$1/$2/$3/$4";
$route['alumno/curso/virtual/evaluacion/entregar/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_entregar/$1/$2/$3/$4";
$route['alumno/curso/virtual/evaluacion/entregada/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_entregada/$1/$2/$3/$4";
$route['alumno/curso/virtual/evaluacion/revisado/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_alumno_revisado/$1/$2/$3/$4";

//$route['alumno/curso/virtual/evaluacion/editar/(:any)/(:any)/(:any)/(:any)']      = "virtualevaluacion/vw_virtual_evaluacion_editar/$1/$2/$3/$4";


//route foro ynga
$route['alumno/curso/virtual/foro-virtual/(:any)/(:any)/(:any)/(:any)']      = "virtualalumno/vw_foro_virtual/$1/$2/$3/$4";
$route['alumno/curso/virtual/foro/(:any)/(:any)/(:any)/(:any)']      = "virtualalumno/vw_foro_virtual/$1/$2/$3/$4";


//$route['alumno/virtual/foro-virtual/reply/(:any)/(:any)/(:any)']      = "virtualalumno/vw_foro_reply/$1/$2/$3";
//fin route foro ynga


$route['biblioteca/virtual']	= "biblioteca";
$route['biblioteca/historial']  = "biblioteca/vwhistorial_libro";
$route['biblioteca/ejemplares']  = "biblioteca/vwhistorial_ejemplares";
$route['biblioteca/editorial']  = "editorial";
$route['biblioteca/autores']  = "autor";
$route['biblioteca/prestamos-libros']  = "prestamos";
$route['biblioteca/devolucion-libros']  = "prestamos/devuelve_libros";
$route['biblioteca/buscar-libros']  = "biblioteca/search_libro";




$route['academico/plan-estudios']  = "plancurricular/vw_plan_estudios";
$route['academico/modulo-educativo']  = "moduloeducativo";
$route['academico/unidad-didactica']  = "unidaddidactica";


$route['gestion/tramites']  = "index/index_tramites";
$route['gestion/tramites/mesa-de-partes']  = "mesa_partes/vw_administrativo_mesa";
$route['gestion/tramites/mesa-de-partes/agregar']  = "mesa_partes/vw_crear";
$route['gestion/tramites/mesa-de-partes/detalle']  = "mesa_partes/vw_administrativo_solicitud_detalle";
$route['tramites/consultar/expediente'] = "mesa_partes/vw_consultar_expediente";

$route['tramites/externo/mesa-de-partes/agregar'] = 'mesa_partes/vw_crear_externo';
$route['mesa-de-partes'] = 'mesa_partes/vw_crear_externo';
$route['tramites/externo/mesa-de-partes/pdf'] = "mesa_partes/mesa_parte_pdf";

$route['tramites/mesa-de-partes']  = "mesa_partes/vw_mi_mesa";
$route['tramites/mesa-de-partes/agregar']  = "mesa_partes/vw_crear_propio";
$route['tramites/mesa-de-partes/detalle']  = "mesa_partes/vw_solicitud_detalle";








$route['portal-web']  = "index/index_portal";

$route['portal-web/programa-estudios']      = "carrera_web/vw_principal";
$route['portal-web/programa-estudios/editar/(:any)/(:any)']      = "carrera_web/vw_editar/$1/$2";

$route['portal-web/bolsa-de-trabajo']      = "bolsa/vw_principal";
$route['portal-web/bolsa-de-trabajo/editar']      = "bolsa/vw_editar";
$route['portal-web/bolsa-de-trabajo/agregar']      = "bolsa/vw_agregar";

$route['portal-web/transparencia']      = "transparencia/vw_principal";
$route['portal-web/transparencia/agregar']      = "transparencia/vw_agregar";
$route['portal-web/transparencia/editar/(:any)/(:any)']      = "transparencia/vw_editar/$1/$2";
$route['portal-web/archivos/(:any)/(:any)']      = "transparencia/vw_virtual_archivos/$1/$2";


$route['portal-web/noticias']      = "noticias";
$route['portal-web/noticias/agregar']  = "noticias/vw_crear";
$route['portal-web/noticias/editar']  = "noticias/update_noticias";

$route['portal-web/eventos'] = "eventos/vw_principal";
$route['portal-web/eventos/agregar'] = "eventos/vw_agregar";
$route['portal-web/eventos/editar'] = "eventos/vw_editar";

$route['portal-web/banner'] = "banner/index";
$route['portal-web/banner/agregar'] = "banner/vw_agregar";
$route['portal-web/banner/editar/(:any)'] = "banner/vw_editar/$1";

$route['portal-web/transparencia-categoria'] = "categoria_transparencia/vw_categoria";


$route['portal-web/repositorio']      = "repositorio/vw_principal";
$route['portal-web/repositorio/agregar']      = "repositorio/vw_agregar";
$route['portal-web/repositorio/editar/(:any)/(:any)']      = "repositorio/vw_editar/$1/$2";

$route['portal-web/convocatorias'] = "convocatorias/vw_principal";
$route['portal-web/convocatorias/agregar']      = "convocatorias/vw_agregar";
$route['portal-web/convocatorias/editar/(:any)']      = "convocatorias/vw_editar/$1";
$route['portal-web/convocatorias/archivos/(:any)']      = "convocatorias/vw_convocatoria_archivos/$1";

$route['portal-web/lecturas-recomendadas']      = "lecturas_recomendadas/vw_principal";
$route['portal-web/lecturas-recomendadas/agregar']      = "lecturas_recomendadas/vw_agregar";
$route['portal-web/lecturas-recomendadas/editar/(:any)/(:any)']      = "lecturas_recomendadas/vw_editar/$1/$2";
$route['portal-web/lecturas/archivos/(:any)/(:any)']      = "lecturas_recomendadas/vw_lecturas_archivos/$1/$2";

$route['portal-web/slider']      = "Slider";
$route['portal-web/slider/agregar'] = "slider/vw_agregar";
$route['portal-web/slider/editar/(:any)'] = "slider/vw_editar/$1";

$route['portal-web/galeria-institucional'] = "galeria";
$route['portal-web/galeria/agregar'] = "galeria/vw_agregar";
$route['portal-web/galeria/editar/(:any)'] = "galeria/vw_editar/$1";

//YNGA
$route['pre-inscripcion'] = "prematricula";
$route['admision/ficha-pre-inscripcion'] = "prematricula/vw_ficha_pre_inscripcion";
$route['admision/pre-inscripcion'] = "prematricula/lts_prematricula";
$route['admision/pre-inscripciones/excel']      = "Exportarexcel/dp_pre_inscripciones";
$route['admision/ficha-pre-inscripcion/editar/(:any)'] = "prematricula/vw_update_ficha_pre_inscripcion/$1";
$route['ficha-pre-inscripcion/pdf-descargar/(:any)'] = "prematricula/pdf_ficha_preinscripcion/$1";



$route['gestion/tramites/denuncias']  = "incidencia/lstincidencia_adm";
$route['gestion/tramites/denuncias/agregar']  = "mesa_partes/vw_crear";
$route['gestion/tramites/denuncias/detalle/(:any)']  = "incidencia/deta_incidencia/$1";
//$route['gestion/tramites/denuncias/exportar/pdf/(:any)']  = "incidencia/pdf_rp_dncs_general_xfiltro/$1";



$route['tramites/incidencias'] = "incidencia/lstincidencia";
$route['tramites/incidencia/agregar'] = "incidencia";

$route['tramites/incidencia/constancia-pdf'] = "incidencia/incidencia_pdf";

$route['tramites/incidencia/listado-incidencia'] = "incidencia/lstincidencia_adm";
$route['tramites/incidencia/constancia-detalle/(:any)'] = "incidencia/deta_incidencia/$1";



$route['gestion/area'] = "area";


$route['mantenimiento']  = "index/vw_mantenimiento";
$route['mantenimiento/institucion']  = "iestp";
$route['mantenimiento/carreras'] = "carrera/vw_sprincipal";
$route['mantenimiento/sedes'] = "sede/vw_principal";
$route['mantenimiento/carreras-sedes'] = "carrera_sede/vw_ltsprincipal";
$route['mantenimiento/discapacidad'] = "discapacidad";

$route['gestion-institucion'] = "nosotros";

$route['documentos/pagos'] = "documentos_pago/vw_principal";
$route['documentos/pagos/agregar']      = "documentos_pago/vw_agregar";
$route['documentos/pagos/editar/(:any)']      = "documentos_pago/vw_editar/$1";
$route['documentos/pagos/archivos/(:any)']      = "documentos_pago/vw_virtual_archivos/$1";


$route['alumno/mis-cursos-panel'] = "alumno/vw_mis_cursos_panel";
$route['alumno/curso/panel/(:any)/(:any)/(:any)'] = "alumno/vw_panel_cursos/$1/$2/$3";
$route['alumno/curso/sesiones/(:any)/(:any)/(:any)'] = "alumno/vw_sesiones_curso/$1/$2/$3";
$route['alumno/sesion/descargar-file/(:any)/(:any)/(:any)'] = "alumno/fn_download_file/$1/$2/$3";

$route['tesoreria']      = "index/vw_facturacion";
$route['tesoreria/facturacion/documentos-de-pago']      = "facturacion/vw_documentos_de_pago";
$route['tesoreria/facturacion/crear-documento']      = "facturacion/vw_documentos_crear";

$route['tesoreria/facturacion/pagante']      = "pagante";
$route['tesoreria/facturacion/sede']      = "tipodoc_sede";
$route['tesoreria/facturacion/gestion']      = "gestion";

$route['tesoreria/facturacion/generar/pdf/(:any)'] = "facturacion_impresion/doc_pago_pdf/$1";
$route['tesoreria/facturacion/generar/rpgrafica/(:any)'] = "facturacion_impresion/doc_pago_imp/$1";
$route['tesoreria/matriculas/bloqueos'] = "tesoreria_matricula/vw_matricula";
$route['tesoreria/facturacion/reporte/estado/cuenta/pdf'] = "facturacion_reportes/rp_estado_cuenta_individual_pdf";
$route['tesoreria/facturacion/reporte/estado/cuenta/excel'] = "exportarexcel_facturacion/rp_estado_cuenta_individual_excel";

$route['tesoreria/facturacion/reporte/deudas/estudiante/pdf'] = "facturacion_reportes/rp_deudas_estudiante_individual_pdf";
$route['tesoreria/facturacion/reporte/deudas/estudiante/excel'] = "exportarexcel_facturacion/rp_deudas_estudiante_individual_excel";

$route['tesoreria/facturacion/reporte/pagos/estudiante/pdf'] = "matricula/rp_pagos_estudiante_individual_pdf";

//$route['tesoreria/facturacion/reportes/sedes'] = "graficos";


//REPORTES POR SEDE
$route['tesoreria/facturacion/reportes/sede'] = "facturacion_reportes/vw_rp_xsede";
$route['tesoreria/facturacion/reporte/consolidado/mes/pdf'] = "facturacion_reportes/rp_consolidado_docemitidos_xmes_pdf";

$route['academico/reportes/sede'] = "academico_reportes/vw_rp_xsede";

$route['tesoreria/facturacion/reportes/documentos-emitidos/excel'] = "exportarexcel_facturacion/rpsede_documentos_emitidos";
$route['tesoreria/facturacion/reportes/documentos-emitidos/pdf'] = "facturacion_reportes/rpsede_docemitidos_pdf";

$route['tesoreria/facturacion/reportes/documentos-emitidos-detalle-concepto/excel'] = "exportarexcel_facturacion/rpsede_docemitidos_detalle_concepto";
$route['tesoreria/facturacion/reportes/documentos-emitidos-detalle-concepto/pdf'] = "facturacion_reportes/rpsede_docemitidos_detalle_concepto_pdf";

$route['tesoreria/facturacion/reportes/documentos-emitidos-items/excel'] = "exportarexcel_facturacion/rpsede_documentos_emitidos_filtro_items";
$route['tesoreria/facturacion/reportes/documentos-emitidos-items/pdf'] = "facturacion_reportes/rpsede_documentos_emitidos_filtro_items_pdf";

//Documentos emitidos - cuadro por conceptos
$route['tesoreria/facturacion/reportes/documentos-emitidos-cudaro-conceptos/excel'] = "exportarexcel_facturacion/rpsede_documentos_emitidos_cuadro_x_conceptos";





$route['tesoreria/facturacion/reportes/documentos-emitidos-detalle-medios/pdf'] = "facturacion_reportes/rpsede_docemitidos_detalle_mediodpago_pdf";
$route['tesoreria/facturacion/reportes/documentos-emitidos-detalle-medios/excel'] = "exportarexcel_facturacion/rpsede_documentos_detalle_mediodpago";


$route['tesoreria/facturacion/reportes/deudas_xcuotas_grupo/excel'] = "exportarexcel/dp_matriculas_deudas_xgrupo";




//DEUDAS
$route['tesoreria/deudas'] = "deudas_individual/vw_principal";
$route['tesoreria/deudas/individual'] = "deudas_individual/vw_principal";


$route['tesoreria/deudas/calendario'] = "deudas_calendario/vw_principal";

$route['tesoreria/deudas/grupo'] = "deudas_grupo/vw_principal";

//vw_principal
$route['mantenimiento/tramites/tipos']      = "tramitestipos";




//FORMACION CONTINUA
$route['formacion-continua/cursos'] = "curso_web/vw_principal";
$route['formacion-continua/cursos/agregar'] = "curso_web/vw_agregar";
$route['formacion-continua/cursos/editar/(:any)'] = "curso_web/vw_editar/$1";
$route['formacion-continua/pre-inscripcion'] = "curso_web/vw_pre_inscripcion";
$route['formacion-continua/cursos/inscripciones'] = "curso_web/vw_lista_inscripcion";
$route['formacion-continua/curso/inscripcion/pdf'] = "curso_web/ficha_pdf";
$route['formacion-continua/ficha-pre-inscripcion'] = "curso_web/vw_ficha_pre_inscripcion";
$route['formacion-continua/ficha-pre-inscripcion/editar/(:any)'] = "curso_web/vw_update_ficha_pre_inscripcion/$1";

$route['gestion/academico/filtro-datos'] = "matricula_persona/vw_filtrar_persona";




$route['academico/practicas/empresas'] = "empresas";
$route['academico/practicas/modalidad'] = "practicas_modalidad";
$route['academico/practicas/etapas'] = "practicas_etapas";
$route['academico/practicas/etapas-plan'] = "practicas_etapas_plan";
$route['academico/practicas'] = "practicas/vw_principal_practicas";
$route['academico/practicas/detalle-practica/(:any)/(:any)/(:any)'] = "practicas/vw_detalles_practicas/$1/$2/$3";

$route['academico/egresados'] = "egresados/vw_egresados";


$route['capacitaciones/lista'] = "capacitaciones/vw_principal";
$route['capacitaciones/agregar'] = "capacitaciones/vw_agregar";
$route['capacitaciones/editar/(:any)'] = "capacitaciones/vw_editar/$1";



$route['calendario'] = "calendario/vw_principal";


$route['monitoreo/reporte-asistencia-docente'] = "asistencias_sesiones/vw_asistencias_docentes";
$route['monitoreo/reporte-asistencia-docente/pdf'] = "asistencias_sesiones/vw_asistencias_docentes_pdf";

//$route['monitoreo/docentes/encuesta-dd/crear']       = "monitoreo_docente/vw_crear_cuestionario_dd";

$route['enviar-correos'] = "prematricula/vw_administrativo_envio_correos";