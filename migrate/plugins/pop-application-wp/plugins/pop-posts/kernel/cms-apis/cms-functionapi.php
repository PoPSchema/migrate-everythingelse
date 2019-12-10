<?php
namespace PoP\Application\WP;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class PostsFunctionAPI extends \PoP\Posts\WP\FunctionAPI
{
    public function getExcerpt($post_id)
    {
        $post = $this->getPost($post_id);
	    $readmore = sprintf(
	        TranslationAPIFacade::getInstance()->__('... <a href="%s">Read more</a>', 'pop-application'),
	        $this->getPermalink($post_id)
	    );
	    $value = empty($post->post_excerpt) ? limitString(strip_tags(strip_shortcodes($post->post_content)), $this->getExcerptLength(), $readmore) : $post->post_excerpt;

	    return HooksAPIFacade::getInstance()->applyFilters('get_the_excerpt', $value, $post_id);
    }
}

/**
 * Initialize
 */
new PostsFunctionAPI();
