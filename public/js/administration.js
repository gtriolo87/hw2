
function onJsonEdit(response){
    const risultato = document.getElementById("esitoModifica");
    risultato.classList.remove("hidden");
    risultato.textContent=response['message'];
}

function responseFetch(response){
    return response.json();
}

function aggiornaProfilo(event){
    event.preventDefault();
    const user_id=event.currentTarget.dataset.user_id;
    const group_id=document.querySelector('select[data-user_id="'+user_id+'"]').value;

    fetch("user/editUserGroup/"+user_id+"/"+group_id).then(responseFetch).then(onJsonEdit);
}


const btnsUpdate = document.querySelectorAll('.colEdit a');
for(let button of btnsUpdate){
    button.addEventListener("click", aggiornaProfilo);
};

