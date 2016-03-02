<?php

/**
 * @file
 * Contains \Drupal\becrest\Tests\RestController.
 */

namespace Drupal\becrest\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the becrest module.
 */
class RestControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "becrest RestController's controller functionality",
      'description' => 'Test Unit for module becrest and controller RestController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests becrest functionality.
   */
  public function testRestController() {
    // Check that the basic functions of module becrest.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
