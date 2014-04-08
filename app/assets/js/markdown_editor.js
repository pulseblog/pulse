
function MarkdownEditor($el) { this.init($el); }

MarkdownEditor.prototype.init = function($el) {
    $el.css('opacity','0.5');
    $el.click(function(){
        screenfull.request($(this)[0]);
    })
};
