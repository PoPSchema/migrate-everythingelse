!function(){var n=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["table-inner"]=n({1:function(n,e,t,l,a,r,u){var o;return'\t<tr class="pop-structureinner">\n'+(null!=(o=t.each.call(null!=e?e:n.nullContext||{},null!=(o=null!=u[1]?u[1]["module-names"]:u[1])?o.layouts:o,{name:"each",hash:{},fn:n.program(2,a,0,r,u),inverse:n.noop,data:a}))?o:"")+"\t</tr>\n"},2:function(n,e,t,l,a,r,u){var o;return null!=(o=(t.withModule||e&&e.withModule||t.helperMissing).call(null!=e?e:n.nullContext||{},u[2],e,{name:"withModule",hash:{},fn:n.program(3,a,0,r,u),inverse:n.noop,data:a}))?o:""},3:function(n,e,t,l,a,r,u){return"\t\t\t\t<td>\n\t\t\t\t\t"+n.escapeExpression((t.enterModule||e&&e.enterModule||t.helperMissing).call(null!=e?e:n.nullContext||{},u[3],{name:"enterModule",hash:{dbObjectID:u[2],dbKey:null!=u[3]?u[3].dbKey:u[3]},data:a}))+"\n\t\t\t\t</td>\n"},compiler:[7,">= 4.0.0"],main:function(n,e,t,l,a,r,u){var o;return null!=(o=t.each.call(null!=e?e:n.nullContext||{},null!=e?e.dbObjectIDs:e,{name:"each",hash:{},fn:n.program(1,a,0,r,u),inverse:n.noop,data:a}))?o:""},useData:!0,useDepths:!0})}();