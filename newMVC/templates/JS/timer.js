/**
 * Gère le compte à rebours dynamique d'une annonce.
 * Safely gère le multi-threading JavaScript (évite les conflits d'intervalles).
 * * @param {string} endDate - Date de fin (Format SQL ou ISO)
 * @param {HTMLElement} element - Élément DOM cible
 */
function startCountdown(endDate, element) {
    // 1. Protection contre les fuites de mémoire (Memory Leak)
    // Si l'élément a déjà un timer actif stocké dans son dataset, on le stoppe
    if (element.dataset.timerId) {
        clearInterval(parseInt(element.dataset.timerId, 10));
    }

    // 2. Normalisation de la date pour assurer la compatibilité Safari / Mobile
    // Remplace l'espace par un "T" pour respecter la norme ISO-8601 si nécessaire
    const formattedDate = endDate.includes(' ') && !endDate.includes('T') 
        ? endDate.replace(' ', 'T') 
        : endDate;

    const endTimestamp = new Date(formattedDate).getTime();

    // Clause de sécurité si la date est invalide
    if (isNaN(endTimestamp)) {
        element.textContent = "Date invalide";
        return;
    }

    // 3. Définition de la boucle de rafraîchissement
    const timerId = setInterval(() => {
        const now = new Date().getTime();
        const diff = endTimestamp - now;

        // Fin du compte à rebours
        if (diff <= 0) {
            clearInterval(timerId);
            element.removeAttribute('data-timer-id');
            element.textContent = "Annonce terminée !";
            element.style.color = "#C0392B"; // Rouge pro
            return;
        }

        // Calculs des unités temporelles
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        // 4. Correction de la logique d'affichage (Dégressivité propre)
        if (days > 0) {
            element.textContent = `${days}j ${hours}h`; // Plus informatif que juste 'days'
        } else if (hours > 0) {
            element.textContent = `${hours}h ${minutes}m`;
        } else if (minutes > 0) {
            element.textContent = `${minutes}m ${seconds}s`;
        } else {
            element.textContent = `${seconds}s`; // Correction du bug : affiche uniquement les secondes restantes
        }

        // 5. Gestion des alertes visuelles dynamiques
        if (days >= 1) {
            element.style.color = "#27AE60"; // Vert : tout est au vert
        } else if (days < 1 && hours >= 1) {
            element.style.color = "orange";   // Orange : moins de 24h
        } else if (hours < 1) {
            element.style.color = "#C0392B";  // Rouge : moins d'une heure (Urgent)
        }

    }, 1000);

    // Stockage de l'ID de l'intervalle dans le DOM de l'élément pour pouvoir le détruire au prochain fetch
    element.dataset.timerId = timerId;
}