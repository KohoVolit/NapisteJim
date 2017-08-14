// http://www.brian-driscoll.com/2010/11/jqueryui-plugin-highlight-and-error.html

(function($){
     $.fn.writeError = function(message){
        return this.each(function(){
           var $this = $(this);

           var errorHtml = "<div class=\"ui-widget\">";
           errorHtml+= "<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;\">";
           errorHtml+= "<p>";
           errorHtml+= "<span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin-right: .3em;\"></span>";
           errorHtml+= message;
           errorHtml+= "</p>";
           errorHtml+= "</div>";
           errorHtml+= "</div>";

           $this.html(errorHtml);
        });
     }
})(jQuery);

(function($){
     $.fn.writeAlert = function(message){
        return this.each(function(){
           var $this = $(this);

           var alertHtml = "<div class=\"ui-widget\">";
           alertHtml+= "<div class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0 .7em;\">";
           alertHtml+= "<p>";
           alertHtml+= "<span class=\"ui-icon ui-icon-info\" style=\"float:left; margin-right: .3em;\"></span>";
           alertHtml+= message;
           alertHtml+= "</p>";
           alertHtml+= "</div>";
           alertHtml+= "</div>";

           $this.html(alertHtml);
        });
     }
})(jQuery);
