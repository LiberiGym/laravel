
window.uploader = {
    zones: [],
    add: function (zone, parms, callback) {

        var config = {
            type: 'image',
            url: 'upload',
            trigger: false,
            formData: {}
        }
        $.extend(config, parms);

        var dragIcon = "upload";
        var dragText = "Upload your files";
        switch (config.type) {
            case "image":
                dragIcon = "picture-o";
                dragText = "Drop here a JPG image";
                break;
            case "excel":
                dragIcon = "file-excel-o";
                dragText = "Arrastre aquí un archivo de Excel";
                break;
        }

        var dragInfoText = '<i class="fa fa-' + dragIcon + '"></i>' + dragText;
        //var dragInfo = '<div class="dragInfo"><div class="dragInfoBg"><div class="dragInfoText">' + dragInfoText + '</div></div></div>';
        var dragInfo = '<div class="dragInfo"><div class="dragInfoBg"></div></div>';
        var dragZone = $("#" + zone).append(dragInfo);

        if(config.trigger){
            config.trigger.on({
                click: function(e){
                    e.preventDefault();
                    dragZone.trigger('click');
                }
            })
        }

        uploader.zones[zone] = new Dropzone("#" + zone, {
            paramName: "file",
            url: config.url,
            maxFilesize: 20,
            sending: function (file, xhr, formData) {
                $.each(config.formData, function(key, value){
                    formData.append(key, value);
                });
            },
            success: function (file, response) {
                callback(response);
            }
        });
    }
};
