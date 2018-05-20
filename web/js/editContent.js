$(function(){

            var icon = '<i class="fa fa-star"></i>';
            var noteVal = $('#note').val();
            var note = $('#note');

            var noteId = $('#noteId');
            var cible = noteId.children("label");
            var label = cible[0].innerText;
            noteId.children("label").html(label + " : " + icon.repeat(noteVal) + " " + noteVal);

            note.on('change', function(){
                noteId.children("label").html(label + " : " + icon.repeat(note.val()) + " " + note.val());
            });


            var inputImg = $("#inputImg");
            var file;
            var image = $("#image");

            image.on("click", function() {
              inputImg.click();

              inputImg.on("change", function() {
                file = URL.createObjectURL(event.target.files[0]);
                image.attr("src", file);
              });
            });

            $("#btnImage").on("click", function() {
              inputImg.click();

              inputImg.on("change", function() {
                file = URL.createObjectURL(event.target.files[0]);
                $("#imageAdd").html(`<img class="img-responsive image-edit center-block" src="" id="image">`);
                $("#image").attr("src", file);
                $("#btnImage").remove();
                $("#texte").html(`<div class="middle">
                                        <div class="text">
                                            Modifier l'image
                                        </div>
                                    </div>`);
                $("#image").on("click", function() {
                  inputImg.click();
                });
              });
            });
            
        });