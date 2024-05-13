// Cuando el contenido HTML y los recursos externos se han cargado completamente
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm'); // Obtiene el formulario de registro
    const userList = document.getElementById('userList'); // Obtiene la lista de usuarios

    // Agrega un evento de escucha para el envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Evita el envío del formulario por defecto
        const name = document.getElementById('name').value; // Obtiene el nombre del usuario
        const email = document.getElementById('email').value; // Obtiene el correo electrónico del usuario

        // Realiza una solicitud POST al controlador PHP con los datos del usuario
        fetch('controller.php', {
            method: 'POST',
            body: JSON.stringify({ name: name, email: email }) // Convierte los datos del usuario a formato JSON
        })
        .then(response => response.json()) // Convierte la respuesta del servidor a JSON
        .then(data => {
            if (data.success) { // Si la operación de inserción fue exitosa
                userList.innerHTML = ''; // Limpia la lista de usuarios
                fetchUsers(); // Obtiene y muestra nuevamente la lista de usuarios
                form.reset(); // Reinicia el formulario
            } else {
                alert('Error al agregar usuario.'); // Muestra un mensaje de error
            }
        });
    });

    // Función para obtener y mostrar la lista de usuarios
    function fetchUsers() {
        fetch('controller.php') // Realiza una solicitud GET al controlador PHP
        .then(response => response.json()) // Convierte la respuesta del servidor a JSON
        .then(data => {
            data.forEach(user => { // Para cada usuario en los datos recibidos
                const userItem = document.createElement('div'); // Crea un elemento de usuario
                userItem.innerHTML = `<strong>${user.name}</strong> - ${user.email}`; // Agrega el nombre y correo electrónico del usuario al elemento
                userList.appendChild(userItem); // Agrega el elemento de usuario a la lista de usuarios
            });
        });
    }

    fetchUsers(); // Obtiene y muestra la lista de usuarios cuando se carga la página
});
