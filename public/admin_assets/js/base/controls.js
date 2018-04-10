
window.controls = {
    colorpicker: function(textfield, customParms){
        var parms = {
            format: 'hex'
        };
        $.extend(parms, customParms);

        return textfield.colorpicker(parms);
    },
    datatable: function(table, customParms){
        var parms = {
            responsive: true,
            colreorder: true,
            order: [[0, 'desc']]
        };
        $.extend(parms, customParms);

        return table.DataTable(parms);
    },
    datetimepicker: function(textfield, customParms){
        var parms = {
            format: 'YYYY-MM-DD HH:mm A'
        };
        $.extend(parms, customParms);

        return textfield.datetimepicker(parms);
    },
    selectpicker: function(textfield, customParms){
        var parms = {

        };
        $.extend(parms, customParms);

        return textfield.selectpicker(parms);
    },
    tags: function(textfield, customParms){
        var parms = {
            availableTags: [], allowSpaces: true
        };
        $.extend(parms, customParms);

        return textfield.tagit(parms);
    }
}
