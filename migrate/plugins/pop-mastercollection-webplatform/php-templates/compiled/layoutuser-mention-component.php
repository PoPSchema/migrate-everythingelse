<?php
 function lcr5bbdeb9b8afe2ifvar($cx, $v, $zero)
 {
     return ($v !== null) && ($v !== false) && ($zero || ($v !== 0) && ($v !== 0.0)) && ($v !== '') && (is_array($v) ? (count($v) > 0) : true);
 }

 function lcr5bbdeb9b8afe2encq($cx, $var)
 {
     if ($var instanceof LS) {
         return (string)$var;
     }

     return str_replace(array('=', '`', '&#039;'), array('&#x3D;', '&#x60;', '&#x27;'), htmlspecialchars(lcr5bbdeb9b8afe2raw($cx, $var), ENT_QUOTES, 'UTF-8'));
 }

 function lcr5bbdeb9b8afe2raw($cx, $v, $ex = 0)
 {
     if ($ex) {
         return $v;
     }

     if ($v === true) {
         if ($cx['flags']['jstrue']) {
             return 'true';
         }
     }

     if (($v === false)) {
         if ($cx['flags']['jstrue']) {
             return 'false';
         }
     }

     if (is_array($v)) {
         if ($cx['flags']['jsobj']) {
             if (count(array_diff_key($v, array_keys(array_keys($v)))) > 0) {
                 return '[object Object]';
             } else {
                 $ret = array();
                 foreach ($v as $k => $vv) {
                     $ret[] = lcr5bbdeb9b8afe2raw($cx, $vv);
                 }
                 return join(',', $ret);
             }
         } else {
             return 'Array';
         }
     }

     return "$v";
 }

if (!class_exists("LS")) {
    class LS
    {
        public static $jsContext = array(
            'flags' =>
            array(
                'jstrue' => 1,
                'jsobj' => 1,
            ),
        );
        public function __construct($str, $escape = false)
        {
            $this->string = $escape ? (($escape === 'encq') ? static::encq(static::$jsContext, $str) : static::enc(static::$jsContext, $str)) : $str;
        }
        public function tostring()
        {
            return $this->string;
        }
        public static function stripExtendedComments($template)
        {
            return preg_replace(static::EXTENDED_COMMENT_SEARCH, '{{! }}', $template);
        }
        public static function escapeTemplate($template)
        {
            return addcslashes(addcslashes($template, '\\'), "'");
        }
        public static function raw($cx, $v, $ex = 0)
        {
            if ($ex) {
                return $v;
            }

            if ($v === true) {
                if ($cx['flags']['jstrue']) {
                    return 'true';
                }
            }

            if (($v === false)) {
                if ($cx['flags']['jstrue']) {
                    return 'false';
                }
            }

            if (is_array($v)) {
                if ($cx['flags']['jsobj']) {
                    if (count(array_diff_key($v, array_keys(array_keys($v)))) > 0) {
                        return '[object Object]';
                    } else {
                        $ret = array();
                        foreach ($v as $k => $vv) {
                            $ret[] = static::raw($cx, $vv);
                        }
                        return join(',', $ret);
                    }
                } else {
                    return 'Array';
                }
            }

            return "$v";
        }
        public static function enc($cx, $var)
        {
            return htmlspecialchars(static::raw($cx, $var), ENT_QUOTES, 'UTF-8');
        }
        public static function encq($cx, $var)
        {
            return str_replace(array('=', '`', '&#039;'), array('&#x3D;', '&#x60;', '&#x27;'), htmlspecialchars(static::raw($cx, $var), ENT_QUOTES, 'UTF-8'));
        }
    }
}
return function ($in = null, $options = null) {
    $helpers = array();
    $partials = array();
    $cx = array(
        'flags' => array(
            'jstrue' => true,
            'jsobj' => true,
            'jslen' => true,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'lambda' => false,
            'mustlok' => false,
            'mustlam' => false,
            'mustsec' => false,
            'echo' => true,
            'partnc' => false,
            'knohlp' => false,
            'debug' => isset($options['debug']) ? $options['debug'] : 1,
        ),
        'constants' =>  array(
            'DEBUG_ERROR_LOG' => 1,
            'DEBUG_ERROR_EXCEPTION' => 2,
            'DEBUG_TAGS' => 4,
            'DEBUG_TAGS_ANSI' => 12,
            'DEBUG_TAGS_HTML' => 20,
        ),
        'helpers' => isset($options['helpers']) ? array_merge($helpers, $options['helpers']) : $helpers,
        'partials' => isset($options['partials']) ? array_merge($partials, $options['partials']) : $partials,
        'scopes' => array(),
        'sp_vars' => isset($options['data']) ? array_merge(array('root' => $in), $options['data']) : array('root' => $in),
        'blparam' => array(),
        'partialid' => 0,
        'runtime' => '\LightnCandy\Runtime',
    );
    
    $inary=is_array($in);
    ob_start();
    echo '<span class="media clearfix">
';
    if (lcr5bbdeb9b8afe2ifvar($cx, (($inary && isset($in['avatar-40'])) ? $in['avatar-40'] : null), false)) {
        echo '		<span class="media-left">
			<img width="',lcr5bbdeb9b8afe2encq($cx, ((isset($in['avatar-40']) && is_array($in['avatar-40']) && isset($in['avatar-40']['size'])) ? $in['avatar-40']['size'] : null)),'" height="',lcr5bbdeb9b8afe2encq($cx, ((isset($in['avatar-40']) && is_array($in['avatar-40']) && isset($in['avatar-40']['size'])) ? $in['avatar-40']['size'] : null)),'" src="',lcr5bbdeb9b8afe2encq($cx, ((isset($in['avatar-40']) && is_array($in['avatar-40']) && isset($in['avatar-40']['src'])) ? $in['avatar-40']['src'] : null)),'">
		</span>
';
    } else {
        echo '';
    }
    echo '	<span class="media-body">
		<h4 class="media-heading">',lcr5bbdeb9b8afe2raw($cx, (($inary && isset($in['display-name'])) ? $in['display-name'] : null)),'<br/><small>',lcr5bbdeb9b8afe2encq($cx, (($inary && isset($in['nicename'])) ? $in['nicename'] : null)),'</small></h4>
	</span>
</span>';
    return ob_get_clean();
};
