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
    #$query->join('taxonomy_index', 'ti', 'n.nid=ti.nid');
    #$query->join('taxonomy_term_data', 't', 'ti.tid=t.tid');
    $query->fields('n', array('nid','title','created'))
          ->condition('status', 1) //publicados
          ->orderBy('created', 'DESC'); //Mas reciente primero
    $result = $query->execute();
    $articulos = array();
    
    while($registro = $result->fetchAssoc()) {
      $date=format_date($registro['created'],'custom','j M Y');
      $title=$registro['title'];
      $articulos[$registro['nid']] = array(
        'title' => $title,
        'date' => $date
      );
    }
    return new JsonResponse($articulos);
    #return [
    #    '#type' => 'markup',
    #    #'#markup' => $this->t('Implement method: Rest')
    #    '#markup' => $this->t($ss)
    #];
  }

}
