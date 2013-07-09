<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\CommentPermalink.
 */

namespace Drupal\ds\Plugin\DsField;

use Drupal\Core\Annotation\Translation;
use Drupal\ds\Annotation\DsField;

/**
 * Function field that renders the permalink of a comment.
 *
 * @DsField(
 *   id = "comment_permalink",
 *   title = @Translation("Permalink"),
 *   entity_type = "comment",
 *   module = "ds"
 * )
 */
class CommentPermalink extends PreprocessPluginBase {

}
