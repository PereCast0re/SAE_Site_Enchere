function startCountdown(endDate, element) {
      const end = new Date(endDate).getTime();

      const timer = setInterval(() => {
        const now = new Date().getTime();
        const diff = end - now;

        if (diff <= 0) {
          clearInterval(timer);
          element.textContent = "Annonce terminée !";
          element.style.color = "red";
          return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        element.textContent = `${days}j ${hours}h ${minutes}m ${seconds}s`;

        // Couleur dynamique selon le temps restant
        if (days < 1) {
          element.style.color = "orange";
        }
        if (hours < 1 && days < 1) {
          element.style.color = "red";
        }
      }, 1000);

      // Lancer tous les timers de la page
      document.querySelectorAll('.timer').forEach(el => {
        const endDate = el.getAttribute('data-end');
        startCountdown(endDate, el); // ✅ Fonction importée depuis timer.js
      });
    }