(function ($) { 
    $(function () {
        console.log(params);

        if(params != null){
            $(document.body).snowfall({
                deviceorientation : true,
                flakeCount : (params.flakeCount) ? parseInt(params.flakeCount) : 100,
                round : (params.round) ? Boolean(params.round) : false, 
                shadow : (params.shadow) ? Boolean(params.shadow) : false,
                minSize: (params.minSize) ? parseInt(params.minSize) : 5, 
                maxSize:(params.maxSize) ? parseInt(params.maxSize) : 8,
                image :(params.image != "") ? params.image : "",
                collection : (params.collection) ? params.collection : '',
            });
        }
    });
 })(jQuery);