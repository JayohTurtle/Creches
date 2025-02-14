

/**
 * Fonction qui affiche l'erreur directement dans l'input (placeholder)
 * @param {HTMLElement} elem 
 * @param {string} message 
 */
function fieldError(elem, message) {
  elem.classList.add('error'); // Ajoute la bordure rouge
  elem.setAttribute("placeholder", message); // Affiche le message dans l'input
  elem.value = ""; // Efface la valeur incorrecte
}

/**
* Fonction qui supprime l'erreur et restaure l'état normal du champ
* @param {HTMLElement} elem 
*/
function clearFieldError(elem) {
  elem.classList.remove('error'); // Supprime la bordure rouge
  elem.setAttribute("placeholder", ""); // Efface le message d'erreur
}









