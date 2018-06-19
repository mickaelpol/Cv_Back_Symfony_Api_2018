$(function(){

            var idCat = $('.idCategorie');
            var btnDelete = $('#boutonSuppression');
            var translateDelete = $('#transDelete').data('delete');
            
            idCat.on('click', function(e){
                var dataRoute = $(this).data('cat');
                var bouton = '<a href="'+ dataRoute +'" type="button" class="btn btn-danger btn-block">\
                                <i class="fa fa-warning"></i>\
                                '+ translateDelete +'\
                            </a>';
                btnDelete.html(bouton);
                $('#myModal').modal("show");

            });

            
            var msg = $('#message');
            var type = $("#message").attr("data-type");
            var alert;
            var message = $("#message").attr("data-flash");
            if (type === "dangering") {
                alert = '<i class="fa fa-warning"></i>';
            } else {
                alert = '<span class="glyphicon glyphicon-check"></span>';
            }
            var content = '<div class="col-lg-4 col-lg-offset-8 text-center">\
                        <div class="alert alert-'+ type +'">\
                            '+ alert +'\
                            '+ " " + message +'\
                        </div>\
                    </div>';
            
            if(msg){
                msg
                    .html(content)
                    .hide()
                    .velocity("slideDown", { 
                        duration: 500 })
                    .velocity("slideUp", {
                        delay: 3000,
                        duration: 500
                });
            }

        var btnCreate = $('#createCat');
        var modalCreate = $('#modalCreate');

        btnCreate.on('click', function(){
            modalCreate.modal('show');
        });

        var btnContent = $('#createCont');
        var modalContent = $('#modalContent');
        var start = new Date();

        btnContent.on('click', function(){
            modalContent.modal('show');
        });

        var btnModalVue = $(".modalVue");
        var modalVue = $("#modalContentVue");

        btnModalVue.on('click', function(){
            var title = JSON.parse($(this).attr("data-contenu")).title;
            var description = JSON.parse($(this).attr("data-contenu")).description;
            var image = JSON.parse($(this).attr("data-contenu")).image;
            var note = JSON.parse($(this).attr("data-contenu")).note;
            var debut = JSON.parse($(this).attr("data-contenu")).dateStart;
            var fin = JSON.parse($(this).attr("data-contenu")).dateEnd;
            var creation = JSON.parse($(this).attr("data-contenu")).createdAt;


            var icone = '<i class="fa fa-star"></i>';

            $('#modalTitle').html(title);
            $("#modalImg").attr("src", image);
            $('#modalPara').html(description);
            $('#modalNote').html(icone.repeat(note));
            $('#modalDebut').html(debut);
            $('#modalFin').html(fin);
            $('#modalCreated').html(creation);

            modalVue.modal('show');


        });

        var note = $('#note');
        var icon = '<i class="fa fa-star"></i>';

        note.on('change', function(){
            var result = note.val();
            $("#idNote").html(icon.repeat(result) + " " + result);
        });

        var btnRmvCont = $('.idContent');
        var modalContentRemove = $('#modalContentRemove');
        var btnDeleteC = $('#boutonSuppressionCont');
        var translateDeleteCont = $('#transDeleteCont').data('delete');

        btnRmvCont.on('click', function(){

            var dataDContent = $(this).data('idcont');
            var boutonD = '<a href="' + dataDContent + '" type="button" class="btn btn-danger btn-block">\
                                <i class="fa fa-warning"></i>\
                                '+ translateDeleteCont + '\
                            </a>';

            btnDeleteC.html(boutonD);
            modalContentRemove.modal('show');
            
        });

        var tmppath;

        $("#fakeBtn").on("click", function() {
          $("#image").click();

          $("#image").on("change", function() {
            tmppath = URL.createObjectURL(event.target.files[0]);
            $("#emplacementImage").html('<img class="img-responsive center-block" src="' + tmppath + '" alt="icone contenu">');
          });
        });

            
});