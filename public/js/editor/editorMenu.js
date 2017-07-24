var EditorMenu = function() {

    init();
    function init() {
        addListeners();
        setSelectedDisabled(true);
        $.subscribe('objectSelected', onObjectSelected);
        $.subscribe('selectionCleared', onSelectionCleared);

        $('#templatesSection').jplist({             
            itemsBox: '.list', 
            itemPath: '.list-item', 
            panelPath: '.jplist-panel'    
        });   

        $('#shapesSection').jplist({             
            itemsBox: '.list', 
            itemPath: '.list-item', 
            panelPath: '.jplist-panel'    
        });

        $('#clipartsSection').jplist({             
            itemsBox: '.list', 
            itemPath: '.list-item', 
            panelPath: '.jplist-panel'    
        });
    }

    function onObjectSelected() {
        setSelectedDisabled(false);
    }

    function onSelectionCleared() {
        setSelectedDisabled(true);
    }

    function setSelectedDisabled(value) {
        $('#copy, #paste, #removeSelected, #bringForward, #sendBackwards, #viewMirror').prop('disabled', value);
    }

    function addListeners() {
        $("#addText").click(function(){dispatchCommand("addText")});
        $("#bringForward").click(function(){dispatchCommand("bringForward")});
        $("#removeSelected").click(function(){dispatchCommand("removeSelected")});
        $("#clearCanvas").click(function() { $("#clearCanvasModal").modal(true);});
        $("#clearCanvasModal .btn-ok").click(function() {dispatchCommand("clearCanvas")});
        $("#copy").click(function(){dispatchCommand("copy")});
        $("#fileImage").change(function(e) { dispatchCommand("addImage", e.target.files[0]);});
        $('html').click(function() { $('#zoom_content').hide();})
        $("#image").click(function() { console.log("clicked image"); $("#fileImage").click();});
        $("#paste").click(function(){dispatchCommand("paste")});
        $("#redo").click(function(){dispatchCommand("redo");});
        $("#sendBackwards").click(function(){dispatchCommand("sendBackwards")});
        $("#undo").click(function(){dispatchCommand("undo");});
        $("#viewMirror").click(function(){dispatchCommand("viewMirror")});
        $("#zoom").click(function() { toggleClass($(this).attr('id')); });


        
        $("#templates").click(function(event) {$("#templatesModal").modal(true);});
        $("#shapes").click(function(event) { $("#shapesModal").modal(true); });
        $("#cliparts").click(function(event) { $("#clipartsModal").modal(true);});

        $("body").on('click', ".useTemplate", function() {
            var templateId = $(this).data('template-id');
            $.get(BASE_URL + '/getTemplateContent/' + templateId, function(data) {
                $.publish('templateUse', {'content': JSON.parse(data)});
                $("#templatesModal").modal('hide');
            });
        })

        $("body").on('click', '.useShape', function() {
            var imgSrc = $(this).siblings('.imgDiv').find('img:first').attr('src');
            var parameters = {path: imgSrc, left: 0, top: 0};
            $.publish('shapeUse', parameters);
            $("#shapesModal").modal('hide');
        })

        $("body").on('click', '.useClipart', function() {
            var imgSrc = $(this).siblings('.imgDiv').find('img:first').attr('src');
            var parameters = {path: imgSrc, left: 0, top: 0};
            $.publish('clipartUse', parameters);
            $("#clipartsModal").modal('hide');
        })
    }

    function toggleClass(id) {
        var el  = document.getElementById(id + "_content"),
        icon    = document.getElementById(id + "_ic");

        if (el.style.display == "none") {
            el.style.display = "block";
            $(icon).addClass('fa-rotate-90');
        } else {
            el.style.display = "none";
            $(icon).removeClass('fa-rotate-90');
        }
    }

    function dispatchCommand(commandName, value) {
        $.publish("menuCommand", {"command": commandName, "value" : value});
    }
}