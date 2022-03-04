document.querySelectorAll(`.user-form textarea`).forEach(el=>el.value="lorem ipsum dolor");
document.querySelectorAll(`.user-form input:not([type="file"], [type="submit"], [type="hidden"], [type="password"], [type="radio"])`).forEach(el=>el.value="jhondoe");

document.querySelectorAll(`.user-form input[name^="pseudo"]`).forEach(el=>el.value="adminDemo");
document.querySelectorAll(`.user-form input[name^="nom"]`).forEach(el=>el.value="Jean");
document.querySelectorAll(`.user-form input[name^="prenom"]`).forEach(el=>el.value="Peuplu");
document.querySelectorAll(`.user-form input[name^="eMail"]`).forEach(el=>el.value='admin@email.com');
document.querySelectorAll(`.user-form input[type="password"]`).forEach(el=>el.value='admin2003!');

document.querySelectorAll(`.user-form input[type="datetime-local"]`).forEach(el=>el.value='2022-02-19T22:21');