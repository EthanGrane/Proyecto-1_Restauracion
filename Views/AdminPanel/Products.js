document.addEventListener('DOMContentLoaded', GetData);

const API_ADDRESS = "http://localhost:7777/api";

// DOM
let DOM_productList;
let DOM_listItem;

let adminMail = localStorage.getItem("email");
let adminPassword = 123456;

let data;
let currentEditId;
let currentDeleteId;

const typeMapping = {
    0: "MainDish",
    1: "Drink"
};

async function GetData() {
    let apiUrl = API_ADDRESS + `?method=GetAllProducts&mail=${adminMail}&password=${adminPassword}`;
    let response = await fetch(apiUrl);
    data = await response.json();

    currentEditId = null;
    currentDeleteId = null;
    HideEditForm();

    ShowAllProducts();
}

async function ShowAllProducts() {
    // Recoje la lista
    if (DOM_productList == null)
        DOM_productList = document.getElementById("DOM_productList");

    if (DOM_listItem == null)
        DOM_listItem = document.getElementById('DOM_listItem');

    DOM_productList.innerHTML = '';

    if (data["status"] == 200) {
        for (let i = 0; i < data.data.length; i++) {
            let currentData = data.data[i];

            let clonedItem = DOM_listItem.cloneNode(true);
            clonedItem.style.display = 'block';
            clonedItem.id = "";

            let textContainer = clonedItem.firstChild;
            let state = currentData.state === 0 ? "Enabled" : "Disabled";

            // Añadir el texto con los detalles del producto
            textContainer.textContent = `${currentData.name} - ${currentData.price} - ${currentData.type} - ${state}`;

            // Botón de edición: Pasar el índice correcto (i) a ShowEditProduct
            let editButton = clonedItem.querySelector("button.btn-warning");
            editButton.setAttribute("onclick", `ShowEditProduct(${i})`);

            let deleteButton = clonedItem.querySelector("button.btn-danger");
            deleteButton.setAttribute("onclick", `ShowDeleteProduct(${i})`);

            DOM_productList.appendChild(clonedItem);
        }
    }
}

async function ShowEditProduct(arrayID) {
    if (arrayID === currentEditId) {
        currentEditId = null;
        HideEditForm();
        return;
    } else {
        currentEditId = arrayID;
    }

    if (currentDeleteId != null)
        HideDeleteForm();

    // Asegúrate de que currentEditId esté dentro de los límites de los datos
    if (data.data && data.data[currentEditId]) {
        let card = document.getElementById("EditCard");
        card.hidden = false;

        let cardTitle = document.getElementById("EditTitle");
        cardTitle.textContent = `Edit - ${data.data[currentEditId]["name"]}`;

        let editProductName = document.getElementById("Edit-ProductName");
        editProductName.disabled = false;
        editProductName.value = data.data[currentEditId]["name"];

        let editProductDescription = document.getElementById("Edit-ProductDescription");
        editProductDescription.disabled = false;
        editProductDescription.value = data.data[currentEditId]["description"];

        let editProductPrice = document.getElementById("Edit-ProductPrice");
        editProductPrice.disabled = false;
        editProductPrice.value = data.data[currentEditId]["price"];

        let editProductType = document.getElementById("Edit-ProductType");
        editProductType.disabled = false;
        editProductType.value = data.data[currentEditId]["type"];
        if (editProductType.value == 0)
            editProductType.value = typeMapping[0];

        let labelProductState = document.getElementById("Label-ProductState");
        let editProductState = document.getElementById("Edit-ProductState");
        editProductState.disabled = false;
        let state = data.data[currentEditId].state;
        editProductState.checked = state === 0;
        if (state == 0)
            labelProductState.textContent = "State (Enabled)";
        else
            labelProductState.textContent = "State (Disabled)";

        let editSubmit = document.getElementById("Edit-Submit");
        editSubmit.disabled = false;
    } else {
        console.error("Product not found or invalid index:", currentEditId);
    }
}

function ShowDeleteProduct(arrayID) {
    let card = document.getElementById("DeleteCard");
    card.hidden = false;

    if (currentEditId != null)
        HideEditForm();

    if (arrayID === currentDeleteId) {
        currentDeleteId = null;
        HideDeleteForm();
        return;
    } else {
        currentDeleteId = arrayID;
    }

    let error = document.getElementById("Delete-Error");
    error.hidden = true;

    let title = document.getElementById("DeleteTitle");
    title.textContent = `Delete - ${data.data[currentDeleteId]["name"]}`;
}

async function EditProduct() {
    let editProductName = document.getElementById("Edit-ProductName").value;
    let editProductDescription = document.getElementById("Edit-ProductDescription").value;
    let editProductPrice = parseFloat(document.getElementById("Edit-ProductPrice").value);
    let editProductState = document.getElementById("Edit-ProductState").checked ? 0 : 1;
    let editProductType = document.getElementById("Edit-ProductType").value;

    // Validar entradas
    if (!editProductName || isNaN(editProductPrice)) {
        console.error("Invalid input data");
        return;
    }

    // Obtener producto actual
    let product = data.data[currentEditId];
    if (!product) {
        console.error("Product not found at index:", currentEditId);
        return;
    }

    // Generar la URL para la API
    let apiUrl = API_ADDRESS + `?method=EditProduct&adminMail=${adminMail}&adminPassword=${adminPassword}&productId=${product.id_products}&productName=${editProductName}&productDescription=${editProductDescription}&productPrice=${editProductPrice}&productType=${editProductType}&productState=${editProductState}`;

    console.log(apiUrl);

    let response = await fetch(apiUrl);
    let result = await response.json();
    console.log("Edit response:", result);


    GetData();
}

function HideEditForm() {
    let card = document.getElementById("EditCard");
    card.hidden = true;

    let cardTitle = document.getElementById("EditTitle");
    cardTitle.textContent = `Edit - None`;

    let editProductName = document.getElementById("Edit-ProductName");
    editProductName.value = null;
    editProductName.disabled = true;

    let editProductDescription = document.getElementById("Edit-ProductDescription");
    editProductDescription.value = null;
    editProductDescription.disabled = true;

    let editProductPrice = document.getElementById("Edit-ProductPrice");
    editProductPrice.value = null;
    editProductPrice.disabled = true;

    let editProductType = document.getElementById("Edit-ProductType");
    editProductType.value = null;
    editProductType.disabled = true;

    let editProductState = document.getElementById("Edit-ProductState");
    editProductState.checked = false;
    editProductState.disabled = true;

    let editSubmit = document.getElementById("Edit-Submit");
    editSubmit.disabled = true;
}

function HideDeleteForm() {
    let card = document.getElementById("DeleteCard");
    card.hidden = true;

    let error = document.getElementById("Delete-Error");
    error.hidden = true;
}

async function AddNewProduct() {
    let createProductName = document.getElementById("Create-ProductName").value;
    let createProductDescription = document.getElementById("Create-ProductDescription").value;
    let createProductPrice = parseFloat(document.getElementById("Create-ProductPrice").value);
    let createProductState = document.getElementById("Create-ProductState").checked ? 0 : 1;
    let createProductType = document.getElementById("Create-ProductType").value;

    // Validar entradas
    if (!createProductName || isNaN(createProductPrice)) {
        console.error("Invalid input data");
        return;
    }

    let apiUrl = API_ADDRESS + `?method=CreateProduct&adminMail=${adminMail}&adminPassword=${adminPassword}&productName=${createProductName}&productDescription=${createProductDescription}&productPrice=${createProductPrice}&productType=${createProductType}&productState=${createProductState}`;
    console.log(apiUrl);

    let response = await fetch(apiUrl);
    let result = await response.json();
    console.log("Edit response:", result);


    GetData();
    document.getElementById("Create-ProductName").value = "";
    document.getElementById("Create-ProductDescription").value = "";
    document.getElementById("Create-ProductPrice").value = "";
    document.getElementById("Create-ProductState").checked = 0;
    document.getElementById("Create-ProductType").value = 0;
}

async function DeleteProduct() {
    let confirmationName = document.getElementById("Delete-ProductName");

    if (confirmationName.value == data.data[currentDeleteId]["name"]) {
        let productId = data.data[currentDeleteId]["id_products"];

        let apiUrl = API_ADDRESS + `?method=DeleteProduct&adminMail=${adminMail}&adminPassword=${adminPassword}&productId=${productId}`;
        console.log("url:", apiUrl);
        
        let response = await fetch(apiUrl);
        let result = await response.json();
        console.log("Edit response:", result);

        GetData();
        HideDeleteForm();
    }
    else {
        let error = document.getElementById("Delete-Error");
        error.hidden = false;
    }

}
