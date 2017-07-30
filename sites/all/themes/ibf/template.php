<?php
/**
 * @file
 * The primary PHP file for this theme.
 */
/*Перекрываем форму поиска */
function ibf_form_alter(&$form, &$form_state, $form_id) {

    if ($form_id == 'search_block_form') {  unset($form['search_block_form']['#attributes']['placeholder']); unset($form['actions']['submit']['#attributes']['class']); }
}