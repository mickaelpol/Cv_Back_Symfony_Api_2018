var form = document.querySelector('#createContenu');
var action = form.getAttribute('action');

form.addEventListener('submit', function (e) {
    e.preventDefault();

    var data = new FormData(form);
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function(){
        if (xhr.readyState === 4) {
            if (xhr.status != 200) {
                var err = JSON.parse(xhr.responseText);
                // console.log(err)
            } else {
                var result = JSON.parse(xhr.responseText);
                // console.log(result)
            }
        }
    }


    xhr.open('POST', action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(data);
    
});