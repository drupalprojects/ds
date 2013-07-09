<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\CommentUserSignature.
 */

namespace Drupal\ds\Plugin\DsField;

use Drupal\Core\Annotation\Translation;
use Drupal\ds\Annotation\DsField;

/**
 * Function field that renders the user signature of a comment.
 *
 * @DsField(
 *   id = "comment_user_signature",
 *   title = @Translation("User signature"),
 *   entity_type = "comment",
 *   module = "ds"
 * )
 */
class CommentUserSignature extends PreprocessPluginBase {

}
