!function(){var l=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["contentsingle-inner"]=l({1:function(l,e,n,a,t,s,u){var r;return null!=(r=(n.withModule||e&&e.withModule||n.helperMissing).call(null!=e?e:l.nullContext||{},u[1],e,{name:"withModule",hash:{},fn:l.program(2,t,0,s,u),inverse:l.noop,data:t}))?r:""},2:function(l,e,n,a,t,s,u){return"\t\t\t"+l.escapeExpression((n.enterModule||e&&e.enterModule||n.helperMissing).call(null!=e?e:l.nullContext||{},u[2],{name:"enterModule",hash:{dbObjectID:null!=u[2]?u[2].dbObjectIDs:u[2],dbKey:null!=u[2]?u[2].dbKey:u[2]},data:t}))+"\n"},compiler:[7,">= 4.0.0"],main:function(l,e,n,a,t,s,u){var r,i,o=null!=e?e:l.nullContext||{},c=n.helperMissing,d=l.escapeExpression;return'<div class="'+d((i=null!=(i=n.class||(null!=e?e.class:e))?i:c,"function"==typeof i?i.call(o,{name:"class",hash:{},data:t}):i))+" "+d((i=null!=(i=n["runtime-class"]||(null!=e?e["runtime-class"]:e))?i:c,"function"==typeof i?i.call(o,{name:"runtime-class",hash:{},data:t}):i))+' pop-structureinner" style="'+d((i=null!=(i=n.style||(null!=e?e.style:e))?i:c,"function"==typeof i?i.call(o,{name:"style",hash:{},data:t}):i))+d((i=null!=(i=n["runtime-style"]||(null!=e?e["runtime-style"]:e))?i:c,"function"==typeof i?i.call(o,{name:"runtime-style",hash:{},data:t}):i))+'">\n'+(null!=(r=n.each.call(o,null!=(r=null!=e?e["module-names"]:e)?r.layouts:r,{name:"each",hash:{},fn:l.program(1,t,0,s,u),inverse:l.noop,data:t}))?r:"")+"</div>"},useData:!0,useDepths:!0})}();