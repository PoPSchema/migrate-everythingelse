!function(){var l=Handlebars.template;(Handlebars.templates=Handlebars.templates||{}).speechbubble=l({1:function(l,e,n,t,a,u,s){var r,o=l.lambda,b=l.escapeExpression;return'\t<div class="'+b(o(null!=(r=null!=s[1]?s[1].classes:s[1])?r["bubble-wrapper"]:r,e))+'" style="'+b(o(null!=(r=null!=s[1]?s[1].styles:s[1])?r["bubble-wrapper"]:r,e))+'">\n\t\t<blockquote class="'+b(o(null!=(r=null!=s[1]?s[1].classes:s[1])?r.bubble:r,e))+'" style="'+b(o(null!=(r=null!=s[1]?s[1].styles:s[1])?r.bubble:r,e))+'">\n'+(null!=(r=(n.withModule||e&&e.withModule||n.helperMissing).call(null!=e?e:l.nullContext||{},s[1],"layout",{name:"withModule",hash:{dbObjectID:null!=e?e.id:e},fn:l.program(2,a,0,u,s),inverse:l.noop,data:a}))?r:"")+"\t\t</blockquote>\n\t</div>\n"},2:function(l,e,n,t,a,u,s){return"\t\t\t\t"+l.escapeExpression((n.enterModule||e&&e.enterModule||n.helperMissing).call(null!=e?e:l.nullContext||{},s[2],{name:"enterModule",hash:{},data:a}))+"\n"},compiler:[7,">= 4.0.0"],main:function(l,e,n,t,a,u,s){var r;return null!=(r=n.with.call(null!=e?e:l.nullContext||{},null!=e?e.dbObject:e,{name:"with",hash:{},fn:l.program(1,a,0,u,s),inverse:l.noop,data:a}))?r:""},useData:!0,useDepths:!0})}();