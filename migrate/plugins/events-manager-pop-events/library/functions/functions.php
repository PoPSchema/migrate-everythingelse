<?php
use PoP\Hooks\Facades\HooksAPIFacade;

// Function that returns true if the event has attendees
function gdEventHasAttendees($event)
{
    foreach ($event->get_bookings() as $EM_Booking) {
        if ($EM_Booking->status == 1) {
            return true;
        }
    }
    
    return false;
}


// Indicates if the event takes place on day $day
function gdEmEventEventOnGivenDay($day, $event)
{
    $event_dates = array();
    $event_start_date = strtotime($event->start_date);
    $event_end_date = mktime(0, 0, 0, $month_post, date('t', $event_start_date), $year_post);
    if ($event_end_date == '') {
        $event_end_date = $event_start_date;
    }
    while ($event_start_date <= $event->end) {
        //Ensure date is within event dates, if so add to eventful days array
        $event_eventful_date = date('Y-m-d', $event_start_date);
        $event_dates[] = $event_eventful_date;
        $event_start_date += (86400); //add a day
    }
    
    return in_array($day, $event_dates);
}

/**
 * Needed to add the "All" category to all events, to list them for the Latest Everything Block
 */

// Do always add the 'All' Category when adding a new event
HooksAPIFacade::getInstance()->addAction('em_event_save_pre', 'gdEmEventSavePreAddAllCategory', 10, 1);
function gdEmEventSavePreAddAllCategory($EM_Event)
{
    
    // Only do it if filtering by taxonomy is enabled. Otherwise no need
    if (defined('POP_TAXONOMYQUERY_INITIALIZED') && PoP_Application_TaxonomyQuery_ConfigurationUtils::enableFilterAllcontentByTaxonomy()) {
        if (defined('POP_EVENTS_CAT_ALL') && POP_EVENTS_CAT_ALL) {
            if (!$EM_Event->get_categories()->terms[POP_EVENTS_CAT_ALL]) {
                $EM_Event->get_categories()->terms[POP_EVENTS_CAT_ALL] = new EM_Category(POP_EVENTS_CAT_ALL);
            }
        }
    }
}
