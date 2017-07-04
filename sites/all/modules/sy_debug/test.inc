<?php
function sy_debug_my_form()
{
$arr_all_page=array();
  $pointers=array();
  $in_node = node_load(7);
  dpm($in_node);
  foreach ($in_node->field_sub_page['und'] as $field_sub_page)
  {
    $sub_page_id=$field_sub_page['value'];
    $sub_page=field_collection_item_load($sub_page_id);
    $arr_sub_page=array();

  if (isset($sub_page->field_background_image['und'][0]['uri'])) {
    $bf_img = drupal_realpath($sub_page->field_background_image['und'][0]['uri']);
    $bf_img = str_replace("\\", '/', $bf_img);
    $bf_img = str_replace("C:/OpenServer/domains/ibf7.sy/", '/', $bf_img);
    $add_style = ' style="background-image: url(' . $bf_img . '); background-attachment: fixed; 
    background-repeat: no-repeat; background-position: 0 0; background-size: 100% 100%;height: 100% !important;" ';
    $add_style = ' style="background-image: url(' . $bf_img . ');" ';
    $arr_sub_page['bf_img']=$bf_img;

    foreach ($sub_page->field_labels['und'] as $collection_label) {
      $label = field_collection_item_load($collection_label['value']);
      $label_type = $label->field_label_type['und'][0]['value'];
      if (isset($label->field_point['und'][0]['value']) && $label_type > 0) {
        if ($label_type == 1 || $label_type == 2) {
          foreach ($label->field_point['und'] as $point_ar) {
            $point = drupal_json_decode('[' . $point_ar['value'] . ']');
            $pointers[] = l('', $label->field_link['und'][0]['url'], array('attributes' => array('class' => array('a-lnk' . $label_type, 'sub-page-id-'.$sub_page_id),
                'style' => "left: " . ($point[0]['x'] * 100) . "%; top: " . ($point[0]['y'] * 100) . "%;")));
          }
        }
        if ($label_type > 10 && $label_type < 15) {
          foreach ($label->field_point['und'] as $point_ar) {
            $point = drupal_json_decode('[' . $point_ar['value'] . ']');
            $position = '';
            switch ($label_type) {
              case 11;
                $position = ' style= "left: ' . ($point[0]['x'] * 100) . '%; top: ' . ($point[0]['y'] * 100) . '%;" ';
                $note_body = l('', $label->field_link['und'][0]['url'], array('attributes' => array('class' => array('a-lnk0'),)))
                    . '<div class="ibf-note-content">' . $label->field_content['und'][0]['value'] . '</div>';
                break;
              case 12;
                $position = ' style= "left: ' . ($point[0]['x'] * 100) . '%; top: auto; bottom:' . (100 - ($point[0]['y'] * 100)) . '%;" ';
                $note_body = '<div class="ibf-note-content">' . $label->field_content['und'][0]['value'] . '</div>'
                    . l('', $label->field_link['und'][0]['url'], array('attributes' => array('class' => array('a-lnk0'),)));
                break;
              case 13;
                $position = ' style= "left: auto; right:' . (100 - ($point[0]['x'] * 100)) . '%; top: auto; bottom:' . (100 - ($point[0]['y'] * 100)) . '%;" ';
                $note_body = '<div class="ibf-note-content">' . $label->field_content['und'][0]['value'] . '</div>'
                    . l('', $label->field_link['und'][0]['url'], array('attributes' => array('class' => array('a-lnk0'),)));
                break;
              case 14;
                $position = ' style= "left: auto; right:' . (100 - ($point[0]['x'] * 100)) . '%; top: ' . ($point[0]['y'] * 100) . '%;" ';
                $note_body = l('', $label->field_link['und'][0]['url'], array('attributes' => array('class' => array('a-lnk0'),)))
                    . '<div class="ibf-note-content">' . $label->field_content['und'][0]['value'] . '</div>';
                break;
            }
            $pointers[] = '<div class="ibf-note ibf-note-type-' . $label_type . ' sub-page-id-'.$sub_page_id.'" ' . $position . '>' .

                $note_body . '</div>';
          }
        }
      }
    }
    
    
   }
 
}

  $form['clear'] = array(
    '#type'  => 'submit',
    '#value' => 'Очистить1','#weight' => 50,
  );
  return $form;
}
