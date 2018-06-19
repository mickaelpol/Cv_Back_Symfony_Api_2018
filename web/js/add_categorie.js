var form1 = document.querySelector('#formCat');
var action1= form1.getAttribute('action');
var btn = document.querySelector('button[type=submit]');
var btnText = btn.textContent;


form1.addEventListener('submit', function(e){
    e.preventDefault();

    btn.disabled = true;
    btn.textContent = "Chargement...";

    var errorElements = form1.querySelectorAll('.has-error');

    for(var i = 0; i < errorElements.length; i++){
        var div = errorElements[i].querySelector('.alert')
        var input = errorElements[i].querySelector('.form-control')

        input.parentNode.classList.remove('has-error')

        if (div) {
            div.remove();
        }
    }

    /**
        partie récupération des datas du formulaire
        et déclaration de l'xmlhttprequest
     */
    var data = new FormData(form1);
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function(){
        if (xhr.readyState === 4) {
            if (xhr.status != 200) {
            var err = JSON.parse(xhr.responseText);
            var input = document.querySelector('[name=newCategorie]');
            input.parentNode.classList.add('has-error');
            var div = document.createElement('div');
            div.className = "alert alert-danger text-center text-uppercase";
            div.innerHTML = err.error;
            input.parentNode.prepend(div);

            } else {
                var result = JSON.parse(xhr.responseText)
                var input = document.querySelector('[name=newCategorie]');
                var div = document.createElement('div');
                input.parentNode.classList.add('has-success');
                div.className = "alert alert-success text-center text-uppercase";
                div.innerHTML = result.valid;
                input.parentNode.prepend(div);
                input.value = "";
                setTimeout(() => {
                    document.location.reload(true);
                }, 3000);
            }
        btn.disabled = false;
        btn.textContent = btnText;
        }
    }

    /**
    Ouverture de la requete ajax avec le type de requete et l'action du formulaire
     */
    xhr.open("POST", action1, true);
    /**
    Passage de l'entête "xmlhttprequest" pour les requêtes ajax
     */
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    /**
    Envoi des données 
     */
    xhr.send(data);
    
})