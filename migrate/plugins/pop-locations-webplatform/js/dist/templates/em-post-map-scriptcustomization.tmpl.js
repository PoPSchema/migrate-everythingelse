!function(){var l=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["em-post-map-scriptcustomization"]=l({1:function(l,n,e,t,a,u,i){var r,s,o=l.lambda,h=l.escapeExpression,c=null!=n?n:l.nullContext||{},d=e.helperMissing;return"\t<script type=\"text/javascript\">\n\t(function($){\n\t\t$(document).one('module:merged', function() {\n\n\t\t\tvar block = $('#"+h(o(null!=(r=null!=i[1]?i[1].bs:i[1])?r.bId:r,n))+"');\n\t\t\tvar pageSection = $('#"+h(o(null!=(r=null!=i[1]?i[1].pss:i[1])?r.psId:r,n))+"');\n\t\t\tpop.MapRuntime.setMarkerData(pageSection, block, '"+h((s=null!=(s=e.title||(null!=n?n.title:n))?s:d,"function"==typeof s?s.call(c,{name:"title",hash:{},data:a}):s))+"', '<div class=\"media\">"+(null!=(r=(e.withSublevel||n&&n.withSublevel||d).call(c,null!=(r=null!=i[1]?i[1].thumb:i[1])?r.name:r,{name:"withSublevel",hash:{},fn:l.program(2,a,0,u,i),inverse:l.noop,data:a}))?r:"")+'<div class="media-body"><div class="authors">'+(null!=(r=e.each.call(c,null!=n?n.authors:n,{name:"each",hash:{},fn:l.program(4,a,0,u,i),inverse:l.noop,data:a}))?r:"")+'</div><a href="'+h((s=null!=(s=e.url||(null!=n?n.url:n))?s:d,"function"==typeof s?s.call(c,{name:"url",hash:{},data:a}):s))+'"><h4 class="media-heading">'+(null!=(s=null!=(s=e.title||(null!=n?n.title:n))?s:d,r="function"==typeof s?s.call(c,{name:"title",hash:{},data:a}):s)?r:"")+"</h4></a>"+(null!=(r=(e.withModule||n&&n.withModule||d).call(c,i[1],"layout-extra",{name:"withModule",hash:{},fn:l.program(9,a,0,u,i),inverse:l.noop,data:a}))?r:"")+"</div></div>');\n\t\t});\n\t})(jQuery);\n\t<\/script>\n"},2:function(l,n,e,t,a,u,i){var r,s=l.lambda,o=l.escapeExpression,h=null!=n?n:l.nullContext||{},c=e.helperMissing;return'<a class="media-left" href="'+o(s(null!=i[1]?i[1].url:i[1],n))+'"><img src="'+o((r=null!=(r=e.src||(null!=n?n.src:n))?r:c,"function"==typeof r?r.call(h,{name:"src",hash:{},data:a}):r))+'" width="'+o((r=null!=(r=e.width||(null!=n?n.width:n))?r:c,"function"==typeof r?r.call(h,{name:"width",hash:{},data:a}):r))+'" height="'+o((r=null!=(r=e.height||(null!=n?n.height:n))?r:c,"function"==typeof r?r.call(h,{name:"height",hash:{},data:a}):r))+'" alt="'+o(s(null!=i[1]?i[1].title:i[1],n))+'"></a>'},4:function(l,n,e,t,a,u,i){var r,s=null!=n?n:l.nullContext||{};return(null!=(r=e.if.call(s,a&&a.index,{name:"if",hash:{},fn:l.program(5,a,0,u,i),inverse:l.noop,data:a}))?r:"")+(null!=(r=(e.withModule||n&&n.withModule||e.helperMissing).call(s,i[2],"authors",{name:"withModule",hash:{},fn:l.program(7,a,0,u,i),inverse:l.noop,data:a}))?r:"")},5:function(l,n,e,t,a,u,i){var r;return null!=(r=l.lambda(null!=i[2]?i[2]["authors-sep"]:i[2],n))?r:""},7:function(l,n,e,t,a,u,i){var r;return l.escapeExpression((e.enterModule||n&&n.enterModule||e.helperMissing).call(null!=n?n:l.nullContext||{},i[3],{name:"enterModule",hash:{dbObjectID:i[1],dbKey:null!=(r=null!=(r=null!=i[3]?i[3].bs:i[3])?r.dbkeys:r)?r.authors:r},data:a}))},9:function(l,n,e,t,a,u,i){return l.escapeExpression((e.enterModule||n&&n.enterModule||e.helperMissing).call(null!=n?n:l.nullContext||{},i[2],{name:"enterModule",hash:{},data:a}))},compiler:[7,">= 4.0.0"],main:function(l,n,e,t,a,u,i){var r;return null!=(r=e.with.call(null!=n?n:l.nullContext||{},null!=n?n.dbObject:n,{name:"with",hash:{},fn:l.program(1,a,0,u,i),inverse:l.noop,data:a}))?r:""},useData:!0,useDepths:!0})}();