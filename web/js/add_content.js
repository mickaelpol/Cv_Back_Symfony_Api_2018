var form = document.querySelector('#createContenu');
var action = form.getAttribute('action');
var btn = document.getElementById("createContenu").elements[9];
var btnText = btn.textContent;

form.addEventListener('submit', function (e) {
    e.preventDefault();

    btn.disabled = true;
    btn.textContent = "Chargement...";
    
    var data = new FormData(form);
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function(){
        if (xhr.readyState === 4) {
            if (xhr.status != 200) {
                var err = JSON.parse(xhr.responseText);
                var div = document.createElement('div');
                div.className = "alert alert-danger text-center text-uppercase";
                div.innerHTML = err.error;
                form.parentNode.prepend(div);
            } else {
                var result = JSON.parse(xhr.responseText);
                var div = document.createElement('div');
                var input = document.querySelectorAll('input, textarea');
                var range = document.querySelectorAll('input[type=range]');
                div.className = "alert alert-success text-center text-uppercase";
                div.innerHTML = result.valid;
                form.parentNode.prepend(div);
                for(var i = 0; i < input.length; i++){
                    input[i].value = "";
                }
                for(var i = 0; i < range.length; i++){
                    range[i].value = 0;
                }
                input.value = "";
                setTimeout(() => {
                    document.location.reload(true);
                }, 3000);
            }
            btn.disabled = false;
            btn.textContent = btnText;
        }
    }


    xhr.open('POST', action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(data);
    
});