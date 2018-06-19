var form1 = document.querySelector('#formCat');
var action1= form1.getAttribute('action');
var btn1 = document.querySelector('button[type=submit]');
var btn1Text = btn1.textContent;


form1.addEventListener('submit', function(e){
    e.preventDefault();

    btn1.disabled = true;
    btn1.textContent = "Chargement...";

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
        btn1.disabled = false;
        btn1.textContent = btn1Text;
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