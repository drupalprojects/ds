<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\CommentSubmitted.
 */

namespace Drupal\ds\Plugin\DsField;

use Drupal\Core\Annotation\Translation;
use Drupal\ds\Annotation\DsField;

/**
 * Function field that renders the submitted by element of a comment.
 *
 * @DsField(
 *   id = "comment_submitted",
 *   title = @Translation("Submitted"),
 *   entity_type = "comment",
 *   module = "ds"
 * )
 */
class CommentSubmitted extends PreprocessPluginBase {

}
