$(function() {
    if (navigator.appName == 'Microsoft Internet Explorer' ||  !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1)) {
        $("html").addClass("ie");
    }

    if ((/Edge\/\d./i.test(navigator.userAgent))) {
        $("html").addClass("edge");
    }
    var Editor = function(pages) {
        $("#save").click(save);
        $('#saveProjectForm').validate({
            rules: {
                projectName: {
                    required: true,
                    remote: {
						url: BASE_URL + "/projects/remoteCheck",
						type:"post",
						data: {
							type: "name",
							_token: $("#saveProjectForm input[name='_token']").val(),
						},
					}
                }
            },
            errorClass: "ajax-error",
            messages: {
            	projectName: {
            		remote: "This name is taken. Choose another one."
            	}
            },
            submitHandler: function() {
                var data = $('#saveProjectForm').serializeArray();

                var pages = JSON.stringify(editorUI.getCanvasPages());
                data.push({name: 'pages', value: pages});
                $.post(BASE_URL + '/project', data, function(responseData) {
                    project.id = responseData;
                    if (responseData != "false") {
                        $('#saveProjectModal').modal('hide');
                        openInfoModal('PROJECT', 'Project succesfully saved!', "success");
                    } else if (responseData == "false") {
                        $('#saveProjectModal').modal('hide');
                        openInfoModal('PROJECT', 'An error has occured while trying to save the project!', "error");
                    }

                    $("#saveProjectForm").find("button[type=reset]").click();
                    $('#saveProjectForm [type=submit]').removeAttr('disabled');
                });
            }
        });

        $('#saveTemplateForm').validate({
            rules: {
                templateName: {
                    required: true,
                    remote: {
						url: BASE_URL+"/admin/templates/remoteCheck",
						type:"post",
						data: {
							type: "name",
							_token: $("#saveTemplateForm input[name='_token']").val(),
						},

					}
                }, 
                templateCategory: {
                    required: true
                }
            },
            errorClass: "ajax-error",
            messages: {
            	templateName: {
            		remote: "This name is taken. Choose another one."
            	}
            },
            submitHandler: function() {
                var data = $('#saveTemplateForm').serializeArray();
                var pages = JSON.stringify(editorUI.getCanvasPages()[0]);
                var templatePNG = editorUI.getCanvasPages()[0].toDataURL('png');
                data.push({name: 'content', value: pages});
                data.push({name: 'templatePNG', value: templatePNG});
                $.post(BASE_URL + '/admin/templates', data, function(responseData) {
                    if (responseData != "false") {
                        project.id = responseData;
                        $('#saveTemplateModal').modal('hide');
                        openInfoModal('TEMPLATE', 'Template succesfully saved!', "success");
                    } else if (responseData == "false") {
                        $('#saveTemplateModal').modal('hide');
                        openInfoModal('TEMPLATE', 'An error has occured while trying to save the template!', "error");
                    }

                    $("#saveTemplateForm").find("button[type=reset]").click();
                    $('#saveTemplateForm [type=submit]').removeAttr('disabled');
                });
            }
        });

        function saveTemplate() {
            var content         = JSON.stringify(editorUI.getCanvasPages()[0]);
            var templatePNG     = editorUI.getCanvasPages()[0].toDataURL('png');
            var postData        = {
                content: content, 
                templatePNG: templatePNG,
                _token: $("#_token").val(),
                _method: "PUT"
            };

            var URL  = BASE_URL + '/admin/templates/' + project.id;
            $.post(URL, postData, function(data) {
                if (data == "true") {
                    openInfoModal('TEMPLATE', 'Template succesfully saved!', "success");
                } else if (data == "false") {
                    openInfoModal('TEMPLATE', 'An error has occured while trying to save the template!', "error");
                }
            });
        }

        function saveProject() {
            var pages = JSON.stringify(editorUI.getCanvasPages());
            var data = {"pages": pages, _method: "PUT", _token: $("#_token").val()};
            if (project.id) {
                $.post(BASE_URL + '/projects/' + project.id, data, function(responseData) {
                    if (data != "false") {
                        openInfoModal('PROJECT', 'Project succesfully saved!', "success");
                    } else if (data == "false") {
                        openInfoModal('PROJECT', 'An error has occured while trying to save the project!', "error");
                    }
                   
                });
            } else {
                $("#saveProject").modal('show');
            }
        }

        function openInfoModal(title, message, type) {
            $("#confirmationModal.title").text(title);
            $("#confirmationModal .message").text(message);
            $("#confirmationModal").removeClass("error");
            $("#confirmationModal").removeClass("success");
            $("#confirmationModal").addClass(type);
            $("#confirmationModal").modal(true);

            $("#saveBtn-success").click(function() {
                $('#confirmationModal').modal('hide');
            });
        }

        function save() {
            if (userId == null && PROJECT_TYPE == "project") {
                $("#loginModal").modal(true);
                return;
            }
            if (PROJECT_TYPE == "template") {
                if (project.id) {
                    saveTemplate();
                } else {
                    $("#saveTemplateModal").modal(true);
                }
            } else if (PROJECT_TYPE == "project") {
                if (project.id) {
                    saveProject();
                } else {
                    $("#saveProjectModal").modal(true);
                }
            }
        }

        function initComponents(data) {
            editorUI                = new EditorUI(data);
            var editorMenu          = new EditorMenu();
            var editorStyles        = new EditorStyles();
            var editorLeftBar       = new EditorLeftBar();
        }

        var editorUI;

        initComponents(pages);
    }

    var EditorPreloader = function() {

        function init() {
            var clientHeight            = window.innerHeight;
            var menuBarHeight           = document.getElementById("menuBarID").offsetHeight;
            var editorContainerHeight   = clientHeight - menuBarHeight;

            document.getElementById('editorContainer').style.height = editorContainerHeight +"px";
            document.getElementById('workbench-leftComponentsID').style.height = editorContainerHeight +"px";
            document.getElementById('workbench-rightComponentsID').style.height = editorContainerHeight +"px";


            if (PROJECT_TYPE == "project") {
                if (! jQuery.isEmptyObject(project)) {
                    loadProject(project.id);
                } else {
                    EditorOptions.backgroundImage = BASE_URL + "/images/defaultWhiteBoard.png";
                    initEditor([]);
                }
            } else if (PROJECT_TYPE == "template") {
                if (! jQuery.isEmptyObject(project)) {
                    loadTemplate();
                } else {
                   	EditorOptions.backgroundImage = BASE_URL + "/images/defaultWhiteBoard.png";
                    initEditor([]);
                }
            } 
        }

        function loadProject(projectId) {
            var pages = [];
            for (var i = 0; i < project.contents.length; i++) {
                pages.push(project.contents[i].content);
            }
            initEditor(pages);
        }

        function loadTemplate() {
            console.log('loading template');
            var pages = [];
            pages.push(project.content);
            initEditor(pages);
        }

        function initEditor(pages) {
            new Editor(pages);
        }

        init();

    }

    fabric.Canvas.prototype.getItemByCustomId = function(customId) {
      var object = null,
          objects = this.getObjects();

      for (var i = 0, len = this.size(); i < len; i++) {
        if (objects[i].customId && objects[i].customId === customId) {
          object = objects[i];
          break;
        }
      }

      return object;
    };

    new EditorPreloader();
});