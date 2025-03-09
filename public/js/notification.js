document.addEventListener("DOMContentLoaded", () => {

    const notiBtn = document.getElementById("notificationButton")

    let countNotifications = () => {
        fetch('/notificaciones/count')
            .then(response => response.json())
            .then(data => {
                let notiCount = document.createElement("div")
                notiCount.className = "notification-counter"
                notiCount.innerText = `${data.conteo}`

                notiBtn.appendChild(notiCount)
            })
            .catch(error => console.error("Error al obtener ingredientes:", error));
    }

    countNotifications()

    notiBtn.addEventListener("click", () => {
        const existingContainer = document.querySelector(".notifications-container");
        if (existingContainer) {
            existingContainer.remove();
        } else {
            displayNotifications();
        }
    })

    let displayNotifications = () => {
        fetch('/notificaciones/show')
            .then(response => response.json())
            .then(ingredientes => {
                console.log(ingredientes);
    
                var notiContainer = document.createElement("div");
                notiContainer.className = "notifications-container";
    
                ingredientes.forEach(ingrediente => {
                    let notiElement = document.createElement("div");
                    notiElement.className = "noti-element";
    
                    if (ingrediente.stock === 0) {
                        notiElement.innerHTML = `
                            <div class="noti-header empty"></div>
                            <div class="info-container"> 
                                <h4 class="ing-name">${ingrediente.nombre}</h4>
                                <p class="status-msg">¡Completamente agotado!</p>
                            </div>
                        `;
                    } else if (ingrediente.stock < ingrediente.cantidad_min) {
                        notiElement.innerHTML = `
                            <div class="noti-header almost-empty"></div>
                            <div class="info-container"> 
                                <h4 class="ing-name">${ingrediente.nombre}</h4>
                                <p class="status-msg">¡A punto de agotarse!</p>
                                <span class="current-stock">Stock: ${ingrediente.stock} ${ingrediente.nombre_unidad}</span>
                            </div>
                        `;
                    }
    
                    notiContainer.appendChild(notiElement);
                });
    
                notiBtn.appendChild(notiContainer);
            })
            .catch(error => console.error("Error al obtener ingredientes:", error));
    };

})