/**
 * Created by arnaud on 04/05/2016.
 */
(function($){
    function Ged(container, options){
        this.container = container;
        this.dropzone = null;
        this.options = $.extend({
            dropzone: {
                paramName: "form[file]",
                maxFilesize: 6,
                acceptedFiles: "image/jpeg, image/png, image/gif, application/pdf, application/x-pdf, text/plain, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.wordprocessingml.template, application/vnd.ms-excel, application/vnd.ms-excel, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.spreadsheetml.template, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.openxmlformats-officedocument.presentationml.template, application/vnd.openxmlformats-officedocument.presentationml.slideshow, application/octet-stream"
            }
        }, options);
        this.init();
    }

    Ged.prototype = {

        init: function(){
            Dropzone.options.dropzone = false;
            this.attachEvents();
            this.createDropzone();
        },
        createDropzone: function(){
            this.dropzone = new Dropzone("#dropzone", this.options.dropzone);
            this.dropzone.on('queuecomplete', this.reload.bind(this));
        },
        update: function(data){
            $(this.container).find('.card-ged').replaceWith($(data).find('.card-ged'));
            this.createDropzone();
        },
        navigate: function(event){
            event.stopPropagation();
            event.preventDefault();

            $.ajax({
                url: event.target.href,
                success: this.update.bind(this)
            })

        },
        remove: function(event){
            event.stopPropagation();
            event.preventDefault();

            $.ajax({
                url: event.currentTarget.href,
                method: 'get',
                success: this.update.bind(this)
            })

        },
        add: function(event){
            event.stopPropagation();
            event.preventDefault();

            $.ajax({
                url: event.currentTarget.action,
                type: 'post',
                data: $(event.currentTarget).serialize(),
                success: this.update.bind(this)
            });
        },
        reload: function(){
            $.ajax({
                url: $(this.container).find('.card-ged').data('uri'),
                success: this.update.bind(this)
            });
        },
        attachEvents: function(){
            $(this.container).on('click', '[data-type="link"]', this.navigate.bind(this) );
            $(this.container).on('click', '[data-type="remove-dir"]', this.remove.bind(this) );
            $(this.container).on('click', '[data-type="remove-doc"]', this.remove.bind(this) );
            $(this.container).on('submit', '[data-type="ged-add"]', this.add.bind(this) );
        }
    }

    $.fn.ged = function(options){
        return this.each(function(){
            new Ged(this, options);
        });
    }

    $(document).ready(function($) {
        $('[data-model="ged"]').ged();
    });
})(jQuery);