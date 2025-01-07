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
    let apiUrl = API_ADDRESS + `?method=GetAllDiscounts&adminMail=${adminMail}&adminPassword=${adminPassword}`;
    let response = await fetch(apiUrl);
    data = await response.json();

    ShowAllDiscounts();
}

async function ShowAllDiscounts() 
{
    // Recoje la lista
    if(userList == null)
        userList = document.getElementById("DOM_DiscountList");

    if(listItem == null)
        listItem = document.getElementById('DOM_listItem');

    userList.innerHTML = '';

    if (data["status"] == 200) 
    {
        for (let i = 0; i < data.data.length; i++) 
        {
            currentIndexData = data.data[i];

            let clonedItem = listItem.cloneNode(true);
            clonedItem.style.display = 'block';
            clonedItem.id = "";

            let textContainer = clonedItem.firstChild;
            textContainer.textContent = `${currentIndexData.discount_code} - ${currentIndexData.value}${currentIndexData.discount_type == 0 ? "%" : "€"} - ${currentIndexData.valid == 1 ? "Valid" : "Not Valid"}`;

            clonedItem.querySelector('.btn-danger').setAttribute('onclick', `DeleteDiscount(${i})`);

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

async function CreateDiscount() 
{
    // Obtener los valores de los campos del formulario
    let discountCode = document.getElementById("Create-DiscountCode").value;
    let discountAmount = document.getElementById("Create-DiscountAmount").value;
    let discountType = document.getElementById("Create-ProductType").value;
    let productState = document.getElementById("Create-ProductState").checked;

    let apiUrl = API_ADDRESS + `?method=CreateDiscount&adminMail=${adminMail}&adminPassword=${adminPassword}&discountCode=${discountCode}&discountAmount=${discountAmount}&discountType=${discountType}&discountValid=${productState}`;
    console.log(apiUrl);
    let response = await fetch(apiUrl);
    data = await response.json();
}


async function DeleteDiscount(arrayId)
{
    let apiUrl = API_ADDRESS + `?method=DeleteDiscount&adminMail=${adminMail}&adminPassword=${adminPassword}&discountId=${data.data[arrayId]["id_discount"]}`;
    console.log(apiUrl);
    let response = await fetch(apiUrl);
    data = await response.json();
}