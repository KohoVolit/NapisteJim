/**
 * jQuery-Plugin "clearField"
 *
 * @version: 1.1, 04.12.2010
 *
 * @author: Stijn Van Minnebruggen
 *          stijn@donotfold.be
 *          http://www.donotfold.be
 *
 * @example: $('selector').clearField();
 * @example: $('selector').clearField({ blurClass: 'myBlurredClass', activeClass: 'myactiveClass' });
 *
 */

	(function($){$.fn.clearField=function(s){s=jQuery.extend({blurClass:'clearFieldBlurred',activeClass:'clearFieldActive',attribute:'rel',value:''},s);return $(this).each(function(){var el=$(this);s.value=el.val();if(el.attr(s.attribute)==undefined){el.attr(s.attribute,el.val()).addClass(s.blurClass)}else{s.value=el.attr(s.attribute)}el.focus(function(){if(el.val()==el.attr(s.attribute)){el.val('').removeClass(s.blurClass).addClass(s.activeClass)}});el.blur(function(){if(el.val()==''){el.val(el.attr(s.attribute)).removeClass(s.activeClass).addClass(s.blurClass)}})})}})(jQuery);


