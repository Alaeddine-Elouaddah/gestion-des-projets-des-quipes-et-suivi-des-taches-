document.addEventListener('DOMContentLoaded', function() {
    var aboutButton = document.getElementById('about-button');
    var aboutSection = document.getElementById('about-section');
    var contactButton = document.getElementById('contact-button');
    var contactSection = document.getElementById('contact-section');

    aboutSection.style.display = 'none'; // Assurez-vous que la section est masquée au départ
    contactSection.style.display = 'none'; // Assurez-vous que la section est masquée au départ

    aboutButton.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        if (aboutSection.style.display === 'none') {
            aboutSection.style.display = 'block'; // Affiche la section
            contactSection.style.display = 'none'; // Masque la section contact
        } else {
            aboutSection.style.display = 'none'; // Masque la section
        }
    });

    contactButton.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        if (contactSection.style.display === 'none') {
            contactSection.style.display = 'block'; // Affiche la section
            aboutSection.style.display = 'none'; // Masque la section à propos
        } else {
            contactSection.style.display = 'none'; // Masque la section
        }
    });
});
