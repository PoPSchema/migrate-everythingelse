<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class EM_PoP_Events_API extends PoP_Events_API_Base implements PoP_Events_API
{
    protected function getEventFromObjectOrId($post_or_post_id)
    {
        return is_object($post_or_post_id) ? $post_or_post_id : em_get_event($post_or_post_id, 'post_id');
    }

    public function isFutureEvent($post_or_post_id)
    {
        $EM_Event = $this->getEventFromObjectOrId($post_or_post_id);
        return POP_CONSTANT_CURRENTTIMESTAMP < $EM_Event->start;
    }

    public function isCurrentEvent($post_or_post_id)
    {
        $EM_Event = $this->getEventFromObjectOrId($post_or_post_id);
        return $EM_Event->start <= POP_CONSTANT_CURRENTTIMESTAMP && POP_CONSTANT_CURRENTTIMESTAMP < $EM_Event->end;
    }

    public function isPastEvent($post_or_post_id)
    {
        $EM_Event = $this->getEventFromObjectOrId($post_or_post_id);
        return $EM_Event->end < POP_CONSTANT_CURRENTTIMESTAMP;
    }

    public function getEvent($event_id/* = false, $search_by = 'event_id'*/)
    {
        return em_get_event($event_id/*, $search_by*/);
    }

    public function getEventByPostId($post_id)
    {
        return em_get_event($post_id, 'post_id');
    }

    public function get($args = array(), array $options = [])
    {
        // To bring all results, limit is 0, not -1
        if ($args['limit'] == -1) {
            $args['limit'] = 0;
        }
        $return_type = $options['return-type'];
        if ($return_type == POP_RETURNTYPE_ARRAY || $return_type == POP_RETURNTYPE_IDS) {
            // Watch out: $query has the format needed by Events Manager for EM_Locations::get($args)
            $args['array'] = true;
        }
        if (isset($args['post-id'])) {

            $args['post_id'] = $args['post-id'];
            unset($args['post-id']);
        }
        elseif (isset($args['include'])) {

            $args['post_id'] = implode(',', $args['include']);
            unset($args['include']);
        }

        if ($args['post-status']) {
            $args['status'] = $args['post-status'];
            unset($args['post-status']);
        }

        // Tags
        if ($args['tag-ids']) {
            $args['tag'] = implode(',', $args['tag-ids']);
            unset($args['tag-ids']);
        }
        if ($args['tags']) {
            $args['tag'] = implode(',', $args['tags']);
            unset($args['tags']);
        }

        // Category
        if ($args['categories']) {
            $args['category'] = implode(',', $args['categories']);
            unset($args['categories']);
        }

        // Profile
        $args['owner'] = false;
        if ($args['authors']) {
            // Make sure it is an array of integers
            $args['owner'] = array_map('intval', $args['authors']);
            unset($args['authors']);
        }

        // Allow CoAuthors Plus to modify the query to add the coauthors
        $args = HooksAPIFacade::getInstance()->applyFilters(
            'EM_PoP_Events_API:get:query',
            $args
        );

        $results = EM_Events::get($args);

        return ($return_type == POP_RETURNTYPE_IDS) ? array_map(function($value) {
            return $value['post_id'];
        }, $results) : $results;
    }

    public function getCategories($EM_Event): array
    {
        // Returns an array of (term_id => category_object)
        return $EM_Event->get_categories()->terms;
    }

    public function isEvent($post_or_post_id)
    {
        if (is_numeric($post_or_post_id)) {
            $post_id = $post_or_post_id;
        } else {
            $cmspostsresolver = \PoP\Posts\ObjectPropertyResolverFactory::getInstance();
            $post = $post_or_post_id;
            $post_id = $cmspostsresolver->getPostId($post);
        }
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        return $cmspostsapi->getPostType($post_id) == $this->getEventPostType();
    }

    public function getPostId($EM_Event)
    {
        return $EM_Event->post_id;
    }

    public function getLocation($EM_Event)
    {
        return $EM_Event->output('#_LOCATIONPOSTID');
    }

    public function getDates($EM_Event)
    {
        return $EM_Event->output('#_EVENTDATES');
    }

    public function getTimes($EM_Event)
    {
        return $EM_Event->output('#_EVENTTIMES');
    }

    public function getStartDate($EM_Event)
    {
        return $EM_Event->output('#_EVENTDATESTART');
    }

    public function getEndDate($EM_Event)
    {
        return $EM_Event->output('#_EVENTDATEEND');
    }

    public function getFormattedStartDate($EM_Event, $format)
    {
        return date_i18n($format, $EM_Event->start);
    }

    public function getFormattedEndDate($EM_Event, $format)
    {
        return date_i18n($format, $EM_Event->end);
    }

    public function isAllDay($EM_Event)
    {
        
        // This returns a string. Return a bool instead
        $value = $EM_Event->output('#_EVENTALLDAY');
        return $value ? true : false;
    }
        
    public function getGooglecalendarUrl($EM_Event)
    {
        return $EM_Event->output('#_EVENTGCALURL');
    }

    public function getIcalUrl($EM_Event)
    {
        return $EM_Event->output('#_EVENTICALURL');
    }

    public function populate(&$EM_Event, $post_data)
    {

        // Copied from function get_post($validate = true) in events-manager/classes/em-event.php
        $EM_Event->post_content = $post_data['post-content'];
        $EM_Event->event_name = $post_data['post-title'];
        $EM_Event->post_type = EM_POST_TYPE_EVENT;

        // Comment Leo 13/03/2016: this line is MANDATORY! When it is not there, the post_except will be set as NULL,
        // and it fails to create the event, giving error "Column 'post_excerpt' cannot be null" on wp_insert_post()
        $EM_Event->post_excerpt = '';

        // Comment Leo 04/01/2018: Since EM 5.8.1.1, we must explicity set these values as below, or else saving the event fails
        $EM_Event->event_rsvp = 0;
        $EM_Event->recurrence = null;
        // $EM_Event->event_rsvp_date = null;
        $EM_Event->event_rsvp_time = null;
        $EM_Event->recurrence_days = null;
        
        // Comment Leo 04/01/2018: this line is MANDATORY! Since EM 5.8.1.1, if we don't add this line, we get the following PHP error when
        // executing getPostType($EM_Event) (in file `wp-content/plugins/poptheme-wassup/plugins/events-manager/pop-library/dataload/fieldresolvers/typeResolver-posts-hook.php`) after creating an event:
        // <b>Warning</b>:  array_map(): Argument #2 should be an array in <b>/Users/leo/Sites/PoP/wp-includes/post.php</b> on line <b>1980</b><br />
        $EM_Event->ancestors = array();

        // post_status might be empty (for publish)
        if ($status = $post_data['post-status']) {
            $EM_Event->force_status = $status;
        }
        
        // Copied from function get_post_meta($validate = true) in events-manager/classes/em-event.php
        // Start/End date and time
        $EM_Event->event_start_date = $post_data['when']['from'];
        $EM_Event->event_end_date = $post_data['when']['to'];

        // Location
        if ($post_data['location']) {
            $EM_Location = em_get_location($post_data['location'], 'post_id');
            $EM_Event->location_id = $EM_Location->location_id;
        }
        // No location
        else {
            $EM_Event->location_id = 0;
        }
        
        // TODO: Fix this: the "All Day" status should be selected in the Bootstrap daterange picker
        // Right now horrible fix: if fromtime and totime are both '00:00' then it's all day
        $EM_Event->event_all_day = ($post_data['when']['fromtime'] == '00:00' && $post_data['when']['totime'] == '00:00') ? 1 : 0;
        $EM_Event->event_start_time = $post_data['when']['fromtime'] . ':00';
        $EM_Event->event_end_time = $post_data['when']['totime'] . ':00';

        //Start/End times should be available as timestamp
        $EM_Event->start = strtotime($EM_Event->event_start_date." ".$EM_Event->event_start_time);
        $EM_Event->end = strtotime($EM_Event->event_end_date." ".$EM_Event->event_end_time);
        
        //Set Blog ID
        if (is_multisite()) {
            $EM_Event->blog_id = get_current_blog_id();
        }

        //group id
        $EM_Event->group_id = 0;
    }

    public function getEventPostType()
    {
        return EM_POST_TYPE_EVENT;
    }

    public function getEventPostTypeSlug()
    {
        return EM_POST_TYPE_EVENT_SLUG;
    }

    public function getEventCategoryTaxonomy()
    {
        return EM_TAXONOMY_CATEGORY;
    }
}

/**
 * Initialize
 */
new EM_PoP_Events_API();
