<?php
/**
 * @file
 * The primary PHP file for this theme.
 */
/*Перекрываем форму поиска */
function ibf_form_alter(&$form, &$form_state, $form_id) {
    if ($form_id == 'search_block_form') {  unset($form['search_block_form']['#attributes']['placeholder']); unset($form['actions']['submit']['#attributes']['class']);
        if(arg(0)=='search' && arg(1)=='node'){
        $form['search_block_form']['#default_value']=str_replace('search/node/','',current_path());

    }

    }
    if ($form_id == 'search_block_form') {
//        dpm($form_state);
//        dpm($_POST);
    }
}

function ibf_preprocess_page(&$variables) {

  drupal_add_library('system', 'effects.slide');
}