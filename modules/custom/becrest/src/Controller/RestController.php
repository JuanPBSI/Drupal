<?php

/**
 * @file
 * Contains \Drupal\becrest\Controller\RestController.
 */

namespace Drupal\becrest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use \stdClass;
use Drupal\Core\Entity\EntityInterface;
use Drupal\comment\Entity\Comment;

/**
 * Class RestController.
 *
 * @package Drupal\becrest\Controller
 */
class RestController extends ControllerBase {
  /**
   * Rest.
   *
   * @return string
   *   Return Hello string.
   */
  public function Rest()
  {
    $query = db_select('node_field_data', 'n');
    $query->fields('n', array('nid','title','created'))
          ->condition('status', 1) //publicados
          ->orderBy('created', 'DESC'); //Mas reciente primero
    $result = $query->execute();
    $articulos = array();
    
    while($registro = $result->fetchAssoc()) {
      $date=format_date($registro['created'],'custom','j M Y');
      $title=$registro['title'];
      $idioma=$registro['langcode'];
      $articulos[$registro['nid']] = array(
        'title' => $title,
        'date' => $date
      );
    }
    return new JsonResponse($articulos);
  }

  public function Rest_comentarios($nodo)
  {
    $query = db_select('comment_field_data', 'cfd');
    $query->join('comment__comment_body', 'ccb', 'cfd.cid=ccb.entity_id');
    $query->fields('cfd', array('cid','created','status','subject','entity_id'))
          ->fields('ccb', array('comment_body_value'))
          ->condition('cfd.status', 1)
          ->condition('cfd.entity_id', $nodo);
    $result = $query->execute();
    $articulos = array();
    
    while($registro = $result->fetchAssoc()) {
      $date=format_date($registro['created'],'custom','j M Y');
      $subject=$registro['subject'];
      $nodo=$registro['entity_id'];
      $content=$registro['comment_body_value'];
      $articulos[$registro['cid']] = array(
        'NodeId' => $nodo,
        'subject' => $subject,
        'date' => $date,
        'contenido' => $content
      );
    }
    return new JsonResponse($articulos);
  }
  
  public function Rest_nodo($nodo)
  {
    $query = db_select('node_field_data', 'n');
    $query->join('node__body', 'nb', 'n.nid=nb.entity_id');
    $query->fields('n', array('nid','title','created','langcode'))
          ->fields('nb', array('body_value'))
          ->condition('n.status', 1)
          ->condition('nid', $nodo)
          ->orderBy('created', 'DESC');
    $result = $query->execute();
    $articulos = array();
    
    while($registro = $result->fetchAssoc()) {
      $date=format_date($registro['created'],'custom','j M Y');
      $title=$registro['title'];
      $idioma=$registro['langcode'];
      $content=$registro['body_value'];
      $articulos[$registro['nid']] = array(
        'title' => $title,
        'date' => $date,
        'lang' => $idioma,
        'contenido' => $content,
      );
    }
    return new JsonResponse($articulos);
  }
  
  public function Rest_img($nodo)
  {
    $query = db_select('node_field_data', 'n');
    $query->join('node__body', 'nb', 'n.nid=nb.entity_id');
    $query->join('node__field_image', 'nfi', 'n.nid=nfi.entity_id');
    $query->join('file_managed', 'fm', 'nfi.field_image_target_id=fm.fid');
    $query->fields('n', array('nid','title','created','langcode'))
          ->fields('nb', array('body_value'))
          ->fields('fm', array('uri','filename'))
          ->condition('n.status', 1)
          ->condition('nid', $nodo)
          ->orderBy('created', 'DESC');
    $result = $query->execute();
    $articulos = array();
    
    while($registro = $result->fetchAssoc()) {
      $date=format_date($registro['created'],'custom','j M Y');
      $title=$registro['title'];
      $idioma=$registro['langcode'];
      $content=$registro['body_value'];
      $imagenSRC=$registro['uri'];
      $imagenFile=$registro['filename'];
      $articulos[$registro['nid']] = array(
        'title' => $title,
        'date' => $date,
        'lang' => $idioma,
        'contenido' => $content,
        'img_src' => $imagenSRC,
        'img_filename' => $imagenFile
      );
    }
    return new JsonResponse($articulos);
  }
  
  public function Rest_comentar()
  {
    $com = $_POST['comentario'];
    $nid = $_POST['nodo'];

    if (empty($nid))
    {
      return [
        '#type' => 'markup',
        '#markup' => $this->t("Error al publicar comentario")
      ];  
    }
    //-----------------------------
    $query = db_select('comment', 'c');
    $query->fields('c', array('cid'))
          ->orderBy('cid', 'ASC');
    $result = $query->execute();
    
    if (!empty($result))
    {
      while($registro = $result->fetchAssoc()) {
        $cid=$registro['cid'];
      }
      $cidNuevo=strval(intval($cid)+1);
    }
    else
      $cidNuevo="1";
    //-----------------------------
    $comentarioNuevo=array(
        'cid' => $cidNuevo,
        'entity_id' => $nid,
        'langcode' => 'en',
        'subject' => "Mensaje Anonimo",
        'name' => "Anonimo",
        "status" => "1",
        "thread" => "02\/",
        "entity_type" => "node",
        "field_name" => "comment",
        "comment_body" => $com
    );
    
    $comment2=Comment::create($comentarioNuevo);
    $comment2->save();
    return [
        '#type' => 'markup',
        '#markup' => $this->t("Comentario posteado")
    ];
  }
}