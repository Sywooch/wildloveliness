/**
 * Knob - jQuery Plugin
 * Copyright (c) 2011 Anthony Terrien
 * Under MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 */
$(function(){function t(t){return $.isNumeric(t)?t*Math.PI/180:0}var a=function(t,n){var i=null,e=t[0].getContext("2d"),r=2*Math.PI;this.onChange=function(){},this.onCancel=function(){},this.onRelease=function(){},this.val=function(t){if(null==t){var a,e;return a=e=Math.atan2(NaN,-(NaN-n.width/2))-n.angleOffset,e<0&&(a=e+r),t=Math.round(a*(n.max-n.min)/r)+n.min,t>n.max?n.max:t}n.stopper&&(t=Math.max(Math.min(t,n.max),n.min)),i=t,this.onChange(t),this.draw(t)},this.angle=function(t){return(t-n.min)*r/(n.max-n.min)},this.draw=function(t){var o=this.angle(t),s=1.5*Math.PI+n.angleOffset,l=s,d=s+this.angle(i),h=l+o,g=n.width/2,c=g*n.thickness,f=a.getCgColor(n.cgColor);e.clearRect(0,0,n.width,n.width),e.lineWidth=c,e.beginPath(),e.strokeStyle=n.bgColor,e.arc(g,g,g-c/2,0,r,!0),e.stroke(),n.displayPrevious&&(e.beginPath(),e.strokeStyle=i==t?n.fgColor:f,e.arc(g,g,g-c/2,s,d,!1),e.stroke()),e.beginPath(),e.strokeStyle=n.fgColor,e.arc(g,g,g-c/2,l,h,!1),e.stroke()}};a.getCgColor=function(t){t=t.substring(1,7);var a=[parseInt(t.substring(0,2),16),parseInt(t.substring(2,4),16),parseInt(t.substring(4,6),16)];return"rgba("+a[0]+","+a[1]+","+a[2]+",.5)"},$.fn.knob=$.fn.dial=function(n){return this.each(function(){var i,e=$(this);if(e.data("dialed"))return e;e.data("dialed",!0),i=$.extend({min:e.data("min")||0,max:e.data("max")||100,readOnly:e.data("readonly"),fgColor:e.data("fgcolor")||"#87CEEB",cgColor:e.data("cgcolor")||e.data("fgcolor")||"#87CEEB",bgColor:e.data("bgcolor")||"#EEEEEE",angleOffset:t(e.data("angleoffset"))},n);var r,o=$('<canvas width="'+i.width+'" height="'+i.width+'"></canvas>'),s=$('<div class="knob-wrapper"></div>'),l=e.val();e.wrap(s).before(o),i.displayInput&&e.css({width:i.width/2+"px"})||e.css({width:"0px",visibility:"hidden"}),(r=new a(o,i)).val(l),e.bind("change",function(t){r.val(e.val())})}).parent()}});
$(function() {
	$(".knob").knob({
		min:0,
		max:360,
		displayInput: false,
		width : 20,
		thickness: .25,
	});
});