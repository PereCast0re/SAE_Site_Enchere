console.log("test");

const btn_connexion = document.querySelector('#btn_connexion');

const menu = document.createElement("select");
menu.id = "menu_deroulant";

const opt1 = document.createElement("option");
opt1.value = "1";
opt1.textContent = "Option 1";

const opt2 = document.createElement("option");
opt2.value = "2";
opt2.textContent = "Option 2";

menu.appendChild(opt1);
menu.appendChild(opt2);


btn_connexion.replaceWith(menu);
