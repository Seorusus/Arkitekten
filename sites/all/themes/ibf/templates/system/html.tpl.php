<?php
/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or
 *   'rtl'.
 * - $html_attributes:  String of attributes for the html element. It can be
 *   manipulated through the variable $html_attributes_array from preprocess
 *   functions.
 * - $html_attributes_array: An array of attribute values for the HTML element.
 *   It is flattened into a string within the variable $html_attributes.
 * - $body_attributes:  String of attributes for the BODY element. It can be
 *   manipulated through the variable $body_attributes_array from preprocess
 *   functions.
 * - $body_attributes_array: An array of attribute values for the BODY element.
 *   It is flattened into a string within the variable $body_attributes.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see bootstrap_preprocess_html()
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup templates
 */
?><!DOCTYPE html>
<html<?php print $html_attributes;?><?php print $rdf_namespaces;?>>
<head>
  <link rel="profile" href="<?php print $grddl_profile; ?>" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <!-- HTML5 element support for IE6-8 -->
  <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
  <![endif]-->
  <?php print $scripts; ?>
</head>
<?php
global $base_path;
$sub_page_tag_cnt=0;
$sub_page_tag='';
$image_tag='';
$pointers=array();
if( arg(0)=='node' && (int) arg(1)>0 )
{
  $in_node=node_load(arg(1));
  if(is_object($in_node) && $in_node->type=='combo_page' && (isset($in_node->field_sub_page['und']) && count($in_node->field_sub_page['und'])>0) )
  {
      $pointers=array();

      $sub_page_tag='<sub_page_tag ';
      $sub_page_tag_cnt=1;
      foreach ($in_node->field_sub_page['und'] as $field_sub_page)
      {
          $sub_page_id=$field_sub_page['value'];
          $sub_page=field_collection_item_load($sub_page_id);

          if (isset($sub_page->field_background_image['und'][0]['uri'])) {
              $bf_img = file_create_url($sub_page->field_background_image['und'][0]['uri']);

              $sub_page_tag.=' tagid'.$sub_page_tag_cnt.'='.$sub_page_id.' ';
                  $sub_page_tag_cnt=$sub_page_tag_cnt+1;
              $image_tag.='<markimg'.$sub_page_id.' value="'.$bf_img.'"></markimg'.$sub_page_id.'>'."\n";
              if(isset($sub_page->field_labels['und'])) {
                  foreach ($sub_page->field_labels['und'] as $collection_label) {
                      $label = field_collection_item_load($collection_label['value']);
                      $label_type = $label->field_label_type['und'][0]['value'];
                      if (isset($label->field_point['und'][0]['value']) && $label_type > 0) {
                          $labe_url = '/';
                          if (isset($label->field_link['und'][0]['url'])) $labe_url = $label->field_link['und'][0]['url'];
                          if ($label_type == 1 || $label_type == 2) {
                              foreach ($label->field_point['und'] as $point_ar) {
                                  $point = drupal_json_decode('[' . $point_ar['value'] . ']');
                                  $pointers[] = l('', $labe_url, array('attributes' => array(/* 'target'=>'_blank', */
                                      'class' => array('a-lnk' . $label_type, 'element-invisible', 'ibf-lnk', 'sub-page-id-' . $sub_page_id),
                                      'style' => "left: " . ($point[0]['x'] * 100) . "%; top: " . ($point[0]['y'] * 100) . "%;")));
                              }
                          }
                          if ($label_type > 10 && $label_type < 16) {
                              foreach ($label->field_point['und'] as $point_ar) {
                                  $point = drupal_json_decode('[' . $point_ar['value'] . ']');
                                  $content_value='Empty field ...';
                                  if(isset($label->field_content['und'][0]['value'])) $content_value=$label->field_content['und'][0]['value'];
                                  $position = '';
                                  switch ($label_type) {
                                      case 11;
                                          $position = ' style= "left: ' . ($point[0]['x'] * 100) . '%; top: ' . ($point[0]['y'] * 100) . '%;" ';
                                          $note_body = l('', $labe_url, array('attributes' => array('class' => array('a-lnk0'),)))
                                              . '<div class="ibf-note-content">' . $content_value. '</div>';
                                          break;
                                      case 12;
                                          $position = ' style= "left: ' . ($point[0]['x'] * 100) . '%; top: auto; bottom:' . (100 - ($point[0]['y'] * 100)) . '%;" ';
                                          $note_body = '<div class="ibf-note-content">' .$content_value. '</div>'
                                              . l('', $labe_url, array('attributes' => array('class' => array('a-lnk0'),)));
                                          break;
                                      case 13;
                                          $position = ' style= "left: auto; right:' . (100 - ($point[0]['x'] * 100)) . '%; top: auto; bottom:' . (100 - ($point[0]['y'] * 100)) . '%;" ';
                                          $note_body = '<div class="ibf-note-content">' . $content_value. '</div>'
                                              . l('', $labe_url, array('attributes' => array('class' => array('a-lnk0'),)));
                                          break;
                                      case 14;
                                          $position = ' style= "left: auto; right:' . (100 - ($point[0]['x'] * 100)) . '%; top: ' . ($point[0]['y'] * 100) . '%;" ';
                                          $note_body = l('', $labe_url, array('attributes' => array('class' => array('a-lnk0'),)))
                                              . '<div class="ibf-note-content">' . $content_value. '</div>';
                                          break;
                                      case 15;
                                          $position = ' style= "left: ' . ($point[0]['x'] * 100) . '%; top: ' . ($point[0]['y'] * 100) . '%;" ';
                                          $note_body =  '<div class="ibf-note-content">' . $content_value. '</div>';
                                          break;
                                  }
                                  $pointers[] = '<div class="ibf-note element-invisible ibf-note-type-' . $label_type . ' sub-page-id-' . $sub_page_id . '" ' . $position . '>' .

                                      $note_body . '</div>';
                              }
                          }
                      }
                  }

              }
          }

      }
      $sub_page_tag_cnt=$sub_page_tag_cnt-1;
      $sub_page_tag.=' tagcount='.$sub_page_tag_cnt.' tagcurent=1 ></sub_page_tag>';

  }
}
?>
<body<?php print $body_attributes; ?> >
<?php if($sub_page_tag_cnt>1){ ?>
<div id="arrow-sub-page-left"></div>
<div id="arrow-sub-page-right"></div>
<?php } ?>
<?php  print $sub_page_tag.$image_tag.implode("\n",$pointers); ?>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>