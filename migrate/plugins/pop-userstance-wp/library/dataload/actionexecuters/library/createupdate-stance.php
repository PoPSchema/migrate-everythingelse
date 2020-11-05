<?php

class GD_WP_CreateOrUpdate_Stance extends GD_CreateOrUpdate_Stance
{
    protected function getCreatepostData($form_data)
    {
        $post_data = parent::getCreatepostData($form_data);

        // Allow to order the Author Thoughts Carousel, so that it always shows the General thought first, and the then article-related ones
        // For that, General thoughts have menu_order "0" (already default one), article-related ones have menu_order "1"
        if ($form_data['stancetarget']) {
            $post_data['menu-order'] = 1;
        }

        return $post_data;
    }
}
