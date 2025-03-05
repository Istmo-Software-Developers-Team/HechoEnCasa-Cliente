<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventario</title>

    <!-- Dependencias Externas  -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

    <!-- Estilos  -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}">
  </head>
  <body>
    <div class="sidebar-box">
      <!-- Notificaciones -->
      <div class="menu-icono-box">
        <svg
          class="menu-icono bx-tada-hover"
          viewBox="0 0 64 64"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M24.889 53.5757C26.7761 55.0833 29.2682 56 32.0001 56C34.732 56 37.2241 55.0833 39.1112 53.5757M12.0204 45.8181C10.8961 45.8181 10.2682 44.0519 10.9483 43.0705C12.5264 40.7934 14.0496 37.4537 14.0496 33.432L14.1146 27.6044C14.1146 16.7772 22.1222 8 32.0001 8C42.0234 8 50.149 16.9065 50.149 27.8932L50.0839 33.432C50.0839 37.4813 51.5545 40.8393 53.0685 43.1173C53.7222 44.1011 53.0927 45.8181 51.9823 45.8181H12.0204Z"
          />
        </svg>
      </div>
      <!-- Menu -->
      <nav class="sidebar-menu">
        <ul>
          <!-- Inicio -->
          <a href="home">
            <li class="menu-seccion">
              <div class="menu-icono-box">
                <svg
                  class="menu-icono"
                  viewBox="0 0 60 60"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8.5 23.5401C8.5 22.9621 8.7939 22.4003 9.32162 22.0434L28.8216 8.85629C29.5241 8.38124 30.4759 8.38124 31.1784 8.85629L50.6784 22.0434C51.2061 22.4003 51.5 22.9621 51.5 23.5401V48.2205C51.5 49.985 49.9809 51.5 48 51.5H12C10.0191 51.5 8.5 49.985 8.5 48.2205V23.5401Z"
                  />
                </svg>
              </div>
              <span>Inicio</span>
            </li>
          </a>
          <!-- Calendario -->
          <a href="calendario.html">
            <li class="menu-seccion">
              <div class="menu-icono-box">
                <svg
                  class="menu-icono"
                  viewBox="0 0 60 60"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M18.3265 19.0362H43.6234M17.1862 5.00025V9.57924M17.1862 9.57924L43.7479 9.57875M17.1862 9.57924C12.7851 9.57924 9.21782 13.2083 9.21803 17.6855L9.21926 44.7065C9.21947 49.1834 12.787 52.8125 17.1878 52.8125H43.7495C48.1505 52.8125 51.7182 49.1829 51.718 44.7058L51.7168 17.6847C51.7166 13.2079 48.1487 9.57875 43.7479 9.57875M43.7479 5V9.57875M25.1567 43.3551V27.1424L19.8443 31.1955M39.7656 43.3551V27.1424L34.4533 31.1955"
                  />
                </svg>
              </div>
              <span>Calendario</span>
            </li>
          </a>
          <!-- Recetas -->
          <a href="recipe">
            <li class="menu-seccion">
              <div class="menu-icono-box">
                <svg
                  class="menu-icono"
                  viewBox="0 0 60 60"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M19.5 19.5H40.5M19.5 31.5H40.5M14.4 7.5H45.6C47.7539 7.5 49.5 9.51472 49.5 12V52.5L43 48L36.5 52.5L30 48L23.5 52.5L17 48L10.5 52.5V12C10.5 9.51472 12.2461 7.5 14.4 7.5Z"
                  />
                </svg>
              </div>
              <span>Recetas</span>
            </li>
          </a>
          <!-- Inventario -->
          <a href="inventary">
            <li class="menu-seccion">
              <div class="menu-icono-box activo">
                <svg
                  class="menu-icono"
                  viewBox="0 0 60 60"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M51.0998 19.375H8.90015M36.25 28.75C31.0633 28.75 23.75 28.75 23.75 28.75M51.25 20.6291V45.9375C51.25 48.8715 48.8715 51.25 45.9375 51.25H14.0625C11.1285 51.25 8.75 48.8715 8.75 45.9375V20.6291C8.75 19.8044 8.94202 18.991 9.31086 18.2533L12.9612 10.9525C13.6362 9.60266 15.0158 8.75 16.525 8.75H43.475C44.9842 8.75 46.3638 9.60267 47.0388 10.9525L50.6891 18.2533C51.058 18.991 51.25 19.8044 51.25 20.6291Z"
                  />
                </svg>
              </div>
              <span>Inventario</span>
            </li>
          </a>
          <!-- Postres -->
          <a href="postres.html">
            <li class="menu-seccion">
              <div class="menu-icono-box">
                <svg
                  class="menu-icono"
                  viewBox="0 0 60 60"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M30.4364 54.3005V19.3914M26.3739 17.2972C26.8061 17.3942 27.2615 17.2753 27.5726 16.9642C27.8838 16.653 28.0025 16.1975 27.9057 15.7655C27.5178 14.181 26.0889 8.87539 24.6218 7.40823C22.7939 5.58033 19.8189 5.57271 18 7.39157C16.1813 9.2103 16.1886 12.1853 18.0167 14.0133C19.5078 15.5045 24.7895 16.9094 26.3739 17.2972ZM30.8103 15.7653C30.7133 16.1975 30.8322 16.6529 31.1434 16.9641C31.4545 17.2752 31.9101 17.3939 32.3421 17.2971C33.9265 16.9092 39.2321 15.4804 40.6993 14.0132C42.5272 12.1853 42.5348 9.21031 40.716 7.39145C38.8972 5.57272 35.9222 5.58007 34.0942 7.4081C32.603 8.89928 31.1982 14.1809 30.8103 15.7653ZM7.74546 31.6096H52.2545C53.2185 31.6096 54 30.8282 54 29.8642V21.1369C54 20.1729 53.2185 19.3914 52.2545 19.3914H7.74545C6.78147 19.3914 6 20.1729 6 21.1369V29.8642C6 30.8282 6.78147 31.6096 7.74546 31.6096ZM49.6364 31.6096V52.5551C49.6364 53.5191 48.8549 54.3005 47.8909 54.3005H12.1091C11.1451 54.3005 10.3636 53.5191 10.3636 52.5551V31.6096H49.6364Z"
                  />
                </svg>
              </div>
              <span>Postres</span>
            </li>
          </a>
        </ul>
      </nav>
    </div>
    <div class="main-box">
      <div class="caja-filtrar-buscar">
      <div class="caja-buscar">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="" 
                    placeholder="Buscar ingredientes..." 
                    oninput="searchIngredients()" 
                />
            </div>
        <div class="caja-filtrar"><i class="bx bx-filter bx-md"></i></div>
      </div>
      <!-- Elementos -->
      <section class="contenedor-elementos">

      </section>
      <div class="boton-agregar" id="botonAgregar">
        <i class="bx bx-plus-circle bx-spin-hover bx-md"></i>
      </div>
    </div>
  </body>
  <script src="{{ asset('js/inventario.js') }}"></script>
  </html>

  <script>
        function searchIngredients() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const ingredientes = document.querySelectorAll('.caja-elemento');

        ingredientes.forEach(ingrediente => {
            const nombre = ingrediente.querySelector('.nombre-ingrediente').textContent.toLowerCase();
            if (nombre.includes(query)) {
                ingrediente.style.display = 'block';
            } else {
                ingrediente.style.display = 'none';
            }
        });
    }
  </script>