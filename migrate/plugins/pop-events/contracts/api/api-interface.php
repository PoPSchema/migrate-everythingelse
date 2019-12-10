<?php

use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;

interface PoP_Events_API
{
    public function isFutureEvent($post_or_post_id);
    public function isCurrentEvent($post_or_post_id);
    public function isPastEvent($post_or_post_id);
    public function getEvent($event_id/* = false, $search_by = 'event_id'*/);
    public function getEventByPostId($post_id);
    public function get($args = array(), array $options = []);
    public function getCategories($event): array;
    public function isEvent($post);
    public function getPostId($event);
    public function getLocation($event);
    public function getDates($event);
    public function getTimes($event);
    public function getStartDate($event);
    public function getEndDate($event);
    public function getFormattedStartDate($event, $format);
    public function getFormattedEndDate($event, $format);
    public function isAllDay($event);
    public function getGooglecalendarUrl($event);
    public function getIcalUrl($event);
    public function populate(&$event, $post_data);

    // This function is not ideal, since it ties the interface to WordPress logic,
    // however it is needed currently because the Delelegator TypeResolver (PostConvertibleTypeResolver::class)
    // decides what typeResolver to use based on the object's post type
    public function getEventPostType();
    public function getEventPostTypeSlug();
    public function getEventCategoryTaxonomy();
}
