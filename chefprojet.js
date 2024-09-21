document.addEventListener('DOMContentLoaded', function() {
    // Gérer le clic sur les boutons de la barre latérale
    document.querySelectorAll('.sidebar button').forEach(button => {
        button.addEventListener('click', function() {
            // Récupérer l'id de la section à afficher
            const sectionId = this.getAttribute('onclick').match(/'(.+?)'/)[1];
            showSection(sectionId);
        });
    });

    // Fonction pour afficher une section et cacher les autres
    function showSection(sectionId) {
        // Masquer toutes les sections
        document.querySelectorAll('.main-content .section').forEach(section => {
            section.classList.remove('active');
        });

        // Afficher la section sélectionnée
        document.getElementById(sectionId).classList.add('active');
    }

    // Charger les groupes et les membres dans les sélecteurs de la section des tâches
    loadGroups();
    loadMembers();

    // Fonction pour charger les groupes (pour la sélection dans les tâches)
    function loadGroups() {
        fetch('get_groups.php')
            .then(response => response.json())
            .then(groups => {
                const groupSelect = document.getElementById('task-group');
                groupSelect.innerHTML = ''; // Réinitialiser le contenu

                groups.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group;
                    option.textContent = group;
                    groupSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading groups:', error));
    }

    // Fonction pour charger les membres (pour la sélection dans les tâches)
    function loadMembers() {
        fetch('get_members.php')
            .then(response => response.json())
            .then(members => {
                const assigneeSelect = document.getElementById('task-assignee');
                assigneeSelect.innerHTML = ''; // Réinitialiser le contenu

                members.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member;
                    option.textContent = member;
                    assigneeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading members:', error));
    }
});

document.addEventListener("DOMContentLoaded", function () {
    fetchProjects();
});

function fetchProjects() {
    fetch('getprojet.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const projectsList = document.getElementById('projects-list');
            projectsList.innerHTML = '';

            data.forEach(project => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${project.name}</td>
                    <td>${project.end_date}</td>
                    <td>${project.budget}</td>
                    <td>${project.description}</td>
                `;
                
                projectsList.appendChild(row);
            });
        })
        .catch(error => console.error('Erreur:', error));
}
document.addEventListener('DOMContentLoaded', function() {
    // Gérer le clic sur les boutons de la barre latérale
    document.querySelectorAll('.sidebar button').forEach(button => {
        button.addEventListener('click', function() {
            const sectionId = this.getAttribute('onclick').match(/'(.+?)'/)[1];
            showSection(sectionId);
        });
    });

    // Fonction pour afficher une section et cacher les autres
    function showSection(sectionId) {
        document.querySelectorAll('.main-content .section').forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById(sectionId).classList.add('active');
    }

    // Charger les groupes et les membres dans les sélecteurs de la section des tâches
    loadGroups();
    loadMembers();

    // Fonction pour charger les groupes
    function loadGroups() {
        fetch('get_groups.php')
            .then(response => response.json())
            .then(groups => {
                const groupSelect = document.getElementById('task-group');
                groupSelect.innerHTML = '';
                groups.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group;
                    option.textContent = group;
                    groupSelect.appendChild(option);
                });

                // Charger les groupes dans le tableau de groupes
                const groupsTable = document.getElementById('groups-list');
                groupsTable.innerHTML = '';
                groups.forEach((group, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${group}</td>
                        <td><button onclick="deleteGroup(${index})">Supprimer</button></td>
                    `;
                    groupsTable.appendChild(row);
                });
            })
            .catch(error => console.error('Error loading groups:', error));
    }

    // Fonction pour charger les membres
    function loadMembers() {
        fetch('get_members.php')
            .then(response => response.json())
            .then(members => {
                const assigneeSelect = document.getElementById('task-assignee');
                assigneeSelect.innerHTML = '';
                members.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member;
                    option.textContent = member;
                    assigneeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading members:', error));
    }

    // Gestion de l'ajout de groupe
    document.getElementById('add-group-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const groupName = document.getElementById('group-name').value.trim();
        if (groupName) {
            fetch('add_group.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'group-name': groupName })
            })
            .then(response => response.json())
            .then(result => {
                showNotification(result.message);
                if (result.status === 'success') {
                    loadGroups(); // Recharger les groupes après ajout
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            showNotification('Veuillez entrer un nom de groupe.');
        }
    });

    // Gestion de l'ajout de membre
    document.getElementById('add-member-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('member-email').value.trim();
        const password = document.getElementById('member-password').value.trim();
        if (email && password) {
            fetch('add_member.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    'email': email,
                    'password': password
                })
            })
            .then(response => response.json())
            .then(result => {
                showNotification(result.message);
                if (result.status === 'success') {
                    loadMembers(); // Recharger les membres après ajout
                    alert("Le Membre ajouter avec succes");        // Recharger les membres après ajout

                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            showNotification('Veuillez remplir tous les champs.');
        }
    });

    // Fonction pour afficher les notifications
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 3000);
    }

    // Fonction pour supprimer un groupe
    window.deleteGroup = function(index) {
        const groupId = index; // Utiliser un ID ou un autre identifiant spécifique
        fetch('delete_group.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 'group-id': groupId })
        })
        .then(response => response.json())
        .then(result => {
            showNotification(result.message);
            if (result.status === 'success') {
                loadGroups(); // Recharger les groupes après suppression
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ajout de membre
    document.getElementById('add-member-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('member-email').value.trim();
        const password = document.getElementById('member-password').value.trim();

        if (email && password) {
            fetch('add_member.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    'email': email,
                    'password': password
                })
            })
            .then(response => response.json())
            .then(result => {
                showNotification(result.message);
                if (result.status === 'success') {
                    loadMembers(); // Recharger les membres après ajout
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            showNotification('Veuillez remplir tous les champs.');
        }
    });

    // Fonction pour afficher les notifications
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 3000);
    }

    // Fonction pour charger les membres
    function loadMembers() {
        fetch('get_members.php')
            .then(response => response.json())
            .then(members => {
                const assigneeSelect = document.getElementById('task-assignee');
                assigneeSelect.innerHTML = '';
                members.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member.email;
                    option.textContent = member.name;
                    assigneeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading members:', error));
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ajout de tâche
    document.getElementById('add-task-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const taskName = document.getElementById('task-name').value.trim();
        const taskDescription = document.getElementById('task-description').value.trim();
        const taskGroup = document.getElementById('task-group').value;
        const taskAssignee = document.getElementById('task-assignee').value;
        const taskStatus = document.getElementById('task-status').value;

        if (taskName && taskDescription && taskGroup && taskAssignee && taskStatus) {
            fetch('ajouter_tache.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    'name': taskName,
                    'description': taskDescription,
                    'group': taskGroup,
                    'assignee': taskAssignee,
                    'status': taskStatus
                })
            })
            .then(response => response.json())
            .then(result => {
                showNotification(result.message);
                if (result.status === 'success') {
                    loadTasks(); // Recharger les tâches après ajout
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            showNotification('Veuillez remplir tous les champs.');
        }
    });

    // Fonction pour afficher les notifications
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 3000);
    }

    // Fonction pour charger les tâches
    function loadTasks() {
        fetch('get_tasks.php')
            .then(response => response.json())
            .then(tasks => {
                const tasksTable = document.getElementById('tasks-list');
                tasksTable.innerHTML = '';
                tasks.forEach(task => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${task.name}</td>
                        <td>${task.description}</td>
                        <td>${task.group}</td>
                        <td>${task.assignee}</td>
                        <td>${task.status}</td>
                    `;
                    tasksTable.appendChild(row);
                });
            })
            .catch(error => console.error('Error loading tasks:', error));
    }
});
function loadMembersInTable() {
    fetch('get_members.php')
        .then(response => response.json())
        .then(data => {
            const membersTableBody = document.querySelector('#members-table tbody');
            membersTableBody.innerHTML = ''; // Vider le tableau avant de le remplir
            data.forEach(member => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${member.email}</td>
                    <td><button onclick="deleteMember(${member.id})">Supprimer</button></td>
                `;
                membersTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching members:', error));
}

// Appel de la fonction après le chargement de la page
window.addEventListener('DOMContentLoaded', loadMembersInTable);
function loadGroups() {
    fetch('get_groups.php')
        .then(response => response.json())
        .then(data => {
            const groupSelect = document.getElementById('task-group');
            groupSelect.innerHTML = ''; // Vider la liste avant de la remplir
            data.forEach(group => {
                const option = document.createElement('option');
                option.value = group.id;
                option.textContent = group.name;
                groupSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching groups:', error));
}

function loadMembers() {
    fetch('get_members.php')
        .then(response => response.json())
        .then(data => {
            const memberSelect = document.getElementById('task-assignee');
            memberSelect.innerHTML = ''; // Vider la liste avant de la remplir
            data.forEach(member => {
                const option = document.createElement('option');
                option.value = member.id;
                option.textContent = member.email;
                memberSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching members:', error));
}

// Appel des fonctions après le chargement de la page
window.addEventListener('DOMContentLoaded', function() {
    loadGroups();
    loadMembers();
});
document.getElementById('add-member-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('member-email').value;
    const password = document.getElementById('member-password').value;

    // Créer un objet avec les données à envoyer
    const data = {
        email: email,
        password: password
    };

    // Envoyer les données au backend via une requête POST
    fetch('insert_member.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Membre ajouté avec succès !');
            // Vous pouvez ajouter du code ici pour actualiser la liste des membres
        } else {
            alert('Erreur lors de l\'ajout du membre : ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erreur :', error);
    });
});
document.getElementById('add-task-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const title = document.getElementById('task-title').value;
    const groupId = document.getElementById('task-group').value;
    const assigneeId = document.getElementById('task-assignee').value;
    const status = document.getElementById('task-status').value;

    const data = {
        title: title,
        group_id: groupId,
        assignee_id: assigneeId,
        status: status
    };

    fetch('insert_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        const notification = document.getElementById('notification');
        if (data.success) {
            notification.textContent = 'Tâche ajoutée avec succès !';
            notification.className = 'notification';
        } else {
            notification.textContent = 'Erreur lors de l\'ajout de la tâche : ' + data.message;
            notification.className = 'notification error';
        }
        notification.style.display = 'block';

        // Cacher la notification après 3 secondes
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    })
    .catch(error => {
        console.error('Erreur :', error);
    });
});
document.getElementById('add-task-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du formulaire

    // Récupère les valeurs des champs du formulaire
    const title = document.getElementById('task-title').value;
    const groupId = document.getElementById('task-group').value;
    const assigneeId = document.getElementById('task-assignee').value;
    const status = document.getElementById('task-status').value;

    // Envoie les données au serveur
    fetch('ajouter_tache.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            title: title,
            group_id: groupId,
            assignee_id: assigneeId,
            status: status // Envoie le statut choisi par l'utilisateur
        })
    })
    .then(response => response.text())
    .then(data => {
        // Affiche une notification de succès
        alert('Tâche ajoutée avec succès');
        // Optionnel : Réinitialiser le formulaire ou mettre à jour l'affichage
        document.getElementById('add-task-form').reset();
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});
document.getElementById('add-group-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const groupName = document.getElementById('group-name').value.trim();
    if (groupName) {
        fetch('add_group.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 'group-name': groupName })
        })
        .then(response => response.json())
        .then(result => {
            showNotification(result.message); // Afficher la notification avec le message retourné
            if (result.status === 'success') {
                loadGroups(); // Recharger les groupes après ajout
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        showNotification('Veuillez entrer un nom de groupe.');
    }
});

function showNotification(message) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.style.display = 'block';
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}
document.getElementById('add-member-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('member-email').value.trim();
    const password = document.getElementById('member-password').value.trim();

    if (email && password) {
        fetch('add_member.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'email': email,
                'password': password
            })
        })
        .then(response => response.json())
        .then(result => {
            showNotification(result.message);
            if (result.status === 'success') {
                loadMembers(); // Recharger les membres après ajout
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        showNotification('Veuillez remplir tous les champs.');
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour charger et afficher les tâches
    function loadTasks() {
        fetch('get_tasks.php')
            .then(response => response.json())
            .then(tasks => {
                const tasksList = document.getElementById('tasks-list');
                tasksList.innerHTML = ''; // Vider le tableau avant de le remplir
                
                tasks.forEach(task => {
                    const row = document.createElement('tr');

                    const titleCell = document.createElement('td');
                    titleCell.textContent = task.title;
                    row.appendChild(titleCell);

                    const groupCell = document.createElement('td');
                    groupCell.textContent = task.group_name;
                    row.appendChild(groupCell);

                    const assigneeCell = document.createElement('td');
                    assigneeCell.textContent = task.assignee;
                    row.appendChild(assigneeCell);

                    const statusCell = document.createElement('td');
                    statusCell.textContent = task.status;
                    row.appendChild(statusCell);

                    tasksList.appendChild(row);
                });
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Charger les tâches au chargement de la page
    loadTasks();
});

