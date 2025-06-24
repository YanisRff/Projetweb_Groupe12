'use strict';

//------------------------------------------------------------------------------
//--- ajaxRequest --------------------------------------------------------------
//------------------------------------------------------------------------------
// Perform an Ajax request.
// \param type The type of the request (GET, DELETE, POST, PUT).
// \param url The url with the data.
// \param callback The callback to call where the request is successful.
// \param data The data associated with the request.
// console.log("utils.js loaded");

function ajaxRequest(type, url, callback, data = null)
{
  let xhr = new XMLHttpRequest();

  if (type === 'GET' && data != null)
    url += '?' + data;

  xhr.open(type, url);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = () => {
    console.log("Réponse du serveur :", xhr.responseText);

    switch (xhr.status) {
      case 200:
      case 201:
        // Vérifie que la réponse n'est pas vide avant de parser
        if (xhr.responseText.trim() !== "") {
          try {
            const json = JSON.parse(xhr.responseText);
            callback(json);
          } catch (e) {
            console.error("Erreur de parsing JSON :", e);
          }
        } else {
          console.warn("Réponse vide du serveur.");
          callback(null); // ou [] / {} selon ton besoin
        }
        break;

      case 404:
        alert("Erreur 404: Page non trouvée");
        break;

      case 500:
        alert("Erreur 500: Erreur interne du serveur");
        break;

      default:
        alert("Erreur: " + xhr.status);
        break;
    }
  };

  xhr.send(data);
}

