document.querySelectorAll(`.user-form textarea`).forEach(el=>el.value="jhondoe");
document.querySelectorAll(`.user-form input:not([type="file"], [type="submit"], [type="hidden"], [type="password"], [type="radio"])`).forEach(el=>el.value="jhondoe");

document.querySelectorAll(`.user-form input[name^="nom"]`).forEach(el=>el.value="Doe");
document.querySelectorAll(`.user-form input[name^="prenom"]`).forEach(el=>el.value="Jhon");
document.querySelectorAll(`.user-form input[name^="eMailMemb"]`).forEach(el=>el.value='jhondoe@email.com');
document.querySelectorAll(`.user-form input[type="password"]`).forEach(el=>el.value='jhondoe2003!');

document.querySelectorAll(`.user-form input[type="datetime-local"]`).forEach(el=>el.value='2022-02-19T22:21');