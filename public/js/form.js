function checkForm(){
    const button=document.querySelector('#btnSignup');
    const esiti=document.querySelectorAll('#divFormSignup span');
    const textBoxes=document.querySelectorAll('#divFormSignup input');
    let formOk=true;
    button.disabled=false;
    for(let box of textBoxes){
        if (box.value=="" && box.type!="submit"){
            button.disabled=true;
            formOk=false;
            break;
        }
    }
    if (formOk){
        for(let esito of esiti){
            if (esito.className !== "hidden"){
                button.disabled=true;
                formOk=false;
                break
            }
        }    
    }
    return formOk;
}

function onJsonUsername(response){
    
    console.log("json " + response + " oppure " + response.exist);
    if(response.exist){
        document.querySelector('.new_username input').classList.add('error');
        document.querySelector('.new_username span').classList.remove('hidden');
    } else{
        document.querySelector('.new_username input').classList.remove('error');
        document.querySelector('.new_username span').classList.add('hidden');
    }
    checkForm();
}
function onResponse(response){
    console.log(response);
    if (!response.ok){
        return null;
    }
    return response.json();
}

function checkUsername(event){
    const input=event.currentTarget;
    if (!input.readOnly){
        const username=input.value;
        if (!/^[0-9a-zA-Z_.-]{2,15}$/.test(username)){
            input.classList.add('error');
            input.parentNode.parentNode.querySelector('span').classList.remove('hidden');
        } else {
            fetch("user/checkUsername/"+username).then(onResponse).then(onJsonUsername);
        }
    }
}
function checkPassword(event){
    const input=event.currentTarget;
    if (!input.readOnly){
        const valore=input.value;
        if (!/^[0-9a-zA-Z_!.-]{5,10}$/.test(valore)){
            input.classList.add('error');
            input.parentNode.parentNode.querySelector('span').classList.remove('hidden');
        } else {
            input.classList.remove('error');
            input.parentNode.parentNode.querySelector('span').classList.add('hidden');
        }
    }
    checkForm();
}
function checkDoublePassword(event){
    const secPassword= event.currentTarget.value;
    const priPassword= document.querySelector('.new_password input').value;
    if (secPassword!==priPassword){
        event.currentTarget.classList.add('error');
        document.querySelector('.checkPassword span').classList.remove('hidden');
    } else{
        event.currentTarget.classList.remove('error');
        document.querySelector('.checkPassword span').classList.add('hidden')
    }
    checkForm();
}
function checkName(event){
    const input=event.currentTarget;
    const valore=input.value;
    if (!/^[a-zA-Z ]{1,25}$/.test(valore)){
        input.classList.add('error');
        input.parentNode.parentNode.querySelector('span').classList.remove('hidden');
    } else {
        input.classList.remove('error');
        input.parentNode.parentNode.querySelector('span').classList.add('hidden');
    }
    checkForm();
}
function checkSurname(event){
    const input=event.currentTarget;
    const valore=input.value;
    if (!/^[a-zA-Z ]{1,25}$/.test(valore)){
        input.classList.add('error');
        input.parentNode.parentNode.querySelector('span').classList.remove('hidden');
    } else {
        input.classList.remove('error');
        input.parentNode.parentNode.querySelector('span').classList.add('hidden');
    }
    checkForm();
}
function checkEmail(event){
    const input=event.currentTarget;
    const valore=input.value;
    if (!/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/.test(valore)){
        input.classList.add('error');
        input.parentNode.parentNode.querySelector('span').classList.remove('hidden');
    } else {
        input.classList.remove('error');
        input.parentNode.parentNode.querySelector('span').classList.add('hidden');
    }
    checkForm();
}

document.querySelector('.new_username input').addEventListener('blur', checkUsername);
document.querySelector('.new_password input').addEventListener('blur', checkPassword);
document.querySelector('.checkPassword input').addEventListener('blur', checkDoublePassword);
document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.email input').addEventListener('blur', checkEmail);
//document.querySelector('#content form').addEventListener('submit', sendRegistration);