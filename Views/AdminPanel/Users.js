document.addEventListener('DOMContentLoaded', GetData);
const API_ADDRESS = "http://localhost:7777/api";

// DOM
let userList;
let listItem;

let adminMail = localStorage.getItem("email");
let adminPassword = 123456

let data;
let currentEditId = null;

async function GetData()
{
    let apiUrl = API_ADDRESS + `?method=GetAllUsers&mail=${adminMail}&password=${adminPassword}`;
    let response = await fetch(apiUrl);
    data = await response.json();

    HideEditForm();
    ShowAllDiscounts();
}

async function EditUser()
{
    let editUsername = document.getElementById("Edit-Username");
    let editEmail = document.getElementById("Edit-Email");
    let editPassword = document.getElementById("Edit-Password");
    let editRole = document.getElementById("Edit-Role");
    let role = editRole.checked ? 1 : 0;

    let apiUrl = API_ADDRESS + `?method=EditUser&adminMail=${adminMail}&adminPassword=${adminPassword}&userName=${editUsername.value}&userMail=${editEmail.value}&userPassword=${editPassword.value}&userRole=${role}`;
    let response = await fetch(apiUrl);
    data = await response.json();

    console.log(data);

    await GetData();
}

async function ShowEditUser(arrayID)
{
    if(arrayID == currentEditId)
    {
        currentEditId = null;
        HideEditForm();
    }
    else
        currentEditId = arrayID;

    let card = document.getElementById("EditCard");
    card.style.display = "block";
    
    let cardTitle = document.getElementById("EditTitle");
    cardTitle.value = `Edit - ${data.data[currentEditId]["name"]}`;

    let editUsername = document.getElementById("Edit-Username");
    editUsername.disabled = false;
    editUsername.value = data.data[currentEditId]["name"];

    let editEmail = document.getElementById("Edit-Email");
    editEmail.disabled = false;
    editEmail.value = data.data[currentEditId]["mail"];

    let editPassword = document.getElementById("Edit-Password");
    editPassword.disabled = false;

    let editRole = document.getElementById("Edit-Role");
    editRole.disabled = false;
    let role = data.data[currentEditId].role;
    editRole.checked = role === 1;

    let editsubmit = document.getElementById("Edit-Submit");
    editsubmit.disabled = false;

}

function HideEditForm()
{
    let cardTitle = document.getElementById("EditTitle");
    cardTitle.value = `Edit - None}`;

    let editUsername = document.getElementById("Edit-Username");
    editUsername.value = null;
    editUsername.disabled = true;

    let editEmail = document.getElementById("Edit-Email");
    editEmail.value = null;
    editEmail.disabled = true;

    let editPassword = document.getElementById("Edit-Password");
    editPassword.value = null;
    editPassword.disabled = true;

    let editRole = document.getElementById("Edit-Role");
    editRole.value = null;
    editRole.disabled = true;

    let editsubmit = document.getElementById("Edit-Submit");
    editsubmit.disabled = true;
}

async function ShowAllDiscounts() 
{
    // Recoje la lista
    if(userList == null)
        userList = document.getElementById("UserList");

    if(listItem == null)
        listItem = document.getElementById('listItem');

    userList.innerHTML = '';

    if (data["status"] == 200) 
    {
        for (let i = 0; i < data.data.length; i++) 
        {
            currentIndexData = data.data[i];

            let clonedItem = listItem.cloneNode(true);
            clonedItem.style.display = 'block';
            clonedItem.id = "";
            let role = currentIndexData.role === 1 ? "Admin" : "User";

            let textContainer = clonedItem.firstChild;
            textContainer.textContent = `${currentIndexData.name} - ${currentIndexData.mail} - ${role}`;

            clonedItem.querySelector('.btn-warning').setAttribute('onclick', `ShowEditUser(${i})`);
            clonedItem.querySelector('.btn-danger').setAttribute('onclick', `deleteUser(${i})`);

            userList.appendChild(clonedItem);
        }
    }
    else 
    {
        let headerItem = document.createElement('li');
        headerItem.classList.add('list-group-item');
        headerItem.textContent = 'Error ' + data["status"];
        userList.appendChild(headerItem);
    }
}